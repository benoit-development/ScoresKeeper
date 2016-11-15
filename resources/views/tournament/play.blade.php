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
      
            
        </div>
    </div>
</div>


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
	    items: 'tr:not(.no-handle)'
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
        url: "{{ url('tournament/addPlayer') }}",
        dataType : 'json',
        data: $("#newPlayerForm").serialize(),
        success: function(json) {
            // success
    		$("#alertErrorTournamentUpdate").addClass("hidden");
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

		var row = $('<tr>')
			.append($('<td>').attr('class', 'handle').append($('<i>').attr('class', 'fa fa-arrows-v')))
			.append($('<td>')
				.text(this.name)
				.append($('<div>').attr('class', 'dropdown pull-right')
    				.append($('<button>').attr('class', 'btn btn-default dropdown-toggle btn-xs').attr('type', 'button').attr('data-toggle', 'true').attr('aria-expanded', 'true').attr('id',  'menuPlayer_' + this.id)
    					.append($('<i>').attr('class', 'fa fa-ellipsis-v'))
    				)
    				.append($('<ul>').attr('class', 'dropdown-menu').attr('aria-labelledby', 'menuPlayer_' + this.id)
	    				.append($('<li>')
    						.append($('<span>').text('<?php echo trans('player.delete') ?>'))
	    				)
    				)
				)
			)
			;
		$('#tableScores tbody').append(row);
		
	});
}

</script>

@endsection