@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
        
        	<!-- Breadcrumbs -->
        	{!! Breadcrumbs::render('play', $tournament) !!}
        
        	<!-- Tournament details -->
            <div class="page-header">
				<h1>
					{{ $tournament->label }}
				</h1>
            </div>
            
            <!-- Error updating tournamnent -->
            <div class="alert alert-danger hidden" id="alertErrorTournamentUpdate">
                <strong>@lang('tournament.error_updating_tournament')</strong>
            </div>
            
            

            <table class="grid table table-striped table-hover" id="tableScores">  
                <thead>  
                <tr>
                	<th width="1px"></th>
                	<th width="1px"><?php echo trans_choice('player.players', 5); ?></th>
                	<th>1</th>
                </tr>  
                </thead>  
                <tbody>  
                </tbody>
                <tfoot>
                    <tr>
                    	<td></td>
                    	<td>
				        	<!-- FORM to add a new player -->
				        	<?php echo Form::open(['class' => 'form-inline', 'id' => 'newPlayerForm']); ?>
				        	<?php echo Form::hidden('tournament_id', $tournament->id); ?>
				        	
                                <!-- Payer name -->
                                <div class="form-group">
                                    <div class="form-group">
                                    	<?php echo Form::text('name', null, ['class' => 'form-control', 'maxlength' => 255, 'placeholder' => trans('player.new_player'), 'id' => 'playerName']); ?>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-user-plus"></i>
                                        </button>
                                    </div>
                                </div>
				        	
				        	<?php echo Form::close(); ?>
                    	</td>
                    	<td></td>
                	</tr>
                </tfoot>  
            </table> 
            
            <!-- Form for player deletion -->
            <?php echo Form::open(['id' => 'deletePlayerForm']); ?>
        	<?php echo Form::hidden('id', null, ['id' => 'deletePlayerForm_id']); ?>
            <?php echo Form::close(); ?>  
            
            <!-- Form for players order -->
            <?php echo Form::open(['id' => 'orderPlayerForm']); ?>
            <?php echo Form::close(); ?>  
      
            
        </div>
    </div>
</div>

<!-- Modal dialog box for deletion -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal-delete">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">&nbsp;</h4>
      </div>
      <div class="modal-body">
        <p>@lang('player.confirm_player_delete')</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal" id="modal-delete-button">
        	@lang('player.delete')
    	</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">
        	@lang('player.cancel')
    	</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" tabindex="-1" role="dialog" id="modal-delete-result">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">@lang('player.deleting_player')</h4>
      </div>
      <div class="modal-body">
        <p>&nbsp;</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">
        	@lang('player.ok')
    	</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">

/**
 * all needed details for the displayed tournament
 */
var tournament = <?php echo json_encode($tournament); ?>;
var details = <?php echo json_encode($details); ?>;


/**
 * Page initialisation
 */
$(document).ready(function() {

	// Make table score sortable to change players order
	$("#tableScores tbody").sortable({
	    helper: fixWidthHelper,
	    handle: '.handle',
	    items: 'tr:not(.no-handle)',
	    update: function(event, ui) {

		    // new players order
		    var data = $("#orderPlayerForm").serializeArray();
		    $("#tableScores tbody tr").each(function(index, value) {
			    data.push({name:'order[' + index + ']', value: $(value).attr("playerId")});
		    });

		    // ajax call to update order
		    
			console.debug(data);
		    
		    $.ajax({
		        type: "POST",
		        url: "{{ url('player/order') }}",
		        dataType : 'json',
		        data: data,
		        success: function(json) {
		            // success
		    		$("#alertErrorTournamentUpdate").addClass("hidden");
		        },
		        error: function(xhr, ajaxOptions, thrownError) {
		            // error occured
		        	$("#alertErrorTournamentUpdate").removeClass("hidden");
		        }
		    });
		    
	    }
	}).disableSelection();

	
	/**
	 * Helper to fix the cells with
	 */
	function fixWidthHelper(e, ui) {
	    ui.children().each(function() {
	        $(this).width($(this).width());
	    });
	    return ui;
	}


	// Set submit function to add a new player
    $("#newPlayerForm").submit(function(event){
        // cancels the form submission
        event.preventDefault();
        // Ajax call to add a new player and update current page
        addPlayer();
    });

    // refresh scores table
    refreshScores();

});

/**
 * Add a new player in the current tournament
 */  
function addPlayer() {

    $.ajax({
        type: "POST",
        url: "{{ url('player/add') }}",
        dataType : 'json',
        data: $("#newPlayerForm").serialize(),
        success: function(json) {
            // success
    		$("#alertErrorTournamentUpdate").addClass("hidden");
    		$("#playerName").val("");
    		details = json.details;
    		refreshScores();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            // error occured
        	$("#alertErrorTournamentUpdate").removeClass("hidden");
        }
    });

}


/**
 * Refresh scores table from details in variable tournament
 */
function refreshScores() {

	// empty current table
	var body = $("#tableScores").find("tbody");
	body.empty();
	
	// populate table with new data
	$(details.players).each(function() {

		var playerId = this.id;
		var playerName = this.name;
		
		var row = $('<tr>')
			.attr('playerId', this.id)
			.append($('<td>').attr('class', 'handle').append($('<i>').attr('class', 'fa fa-arrows-v')))
			.append($('<td>')
				.text(this.name)
				.append($('<div>').attr('class', 'dropdown pull-right')
    				.append($('<button>').attr('class', 'btn btn-default dropdown-toggle btn-xs').attr('type', 'button').attr('data-toggle', 'dropdown').attr('aria-expanded', 'true').attr('id',  'menuPlayer_' + this.id)
    					.append($('<i>').attr('class', 'fa fa-ellipsis-v'))
    				)
    				.append($('<ul>').attr('class', 'dropdown-menu').attr('aria-labelledby', 'menuPlayer_' + this.id)
	    				.append($('<li>')
    						.append($('<a>').attr('href', '#').click(function(){ showDeleteModal(playerId, playerName); }).append($('<i>').attr('class', 'fa fa-trash fa-fw')).append(' @lang('player.delete')'))
	    				)
    				)
				)
			)
			;
		$('#tableScores tbody').append(row);
		
	});
}



/**
 * show modal dialog to delete a player
 *
 * @param playerId
 * @param playerName 
 */
function showDeleteModal(playerId, playerName) {

	$('#deletePlayerForm_id').val(playerId);
	
	$("#modal-delete .modal-title").text(playerName);

	$("#modal-delete-button").off("click");
	$("#modal-delete-button").on( "click", function() {
		$.ajax({
            type: "POST",
            url: "{{ url('player/delete') }}",
            data: $('#deletePlayerForm').serialize(),
            dataType : 'json',
            success: function(json) {
                if (json.status == 'success') {
                    details = json.details;
                	refreshScores();
                } else {
                    $("#modal-delete-result .modal-body").text("@lang('player.deletion_error')");
                    $("#modal-delete-result").modal();
                }
            },
            error: function(json) {
                $("#modal-delete-result .modal-body").text("@lang('player.deletion_error')");
                $("#modal-delete-result").modal();
            }
		});
	});
	
	$("#modal-delete").modal();
}

</script>

@endsection