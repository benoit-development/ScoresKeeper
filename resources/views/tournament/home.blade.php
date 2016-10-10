@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
        
        	<!-- Breadcrumbs -->
        	{!! Breadcrumbs::render('home') !!}
        
        	<!-- Created tournaments -->
            <div class="page-header">
				<h1>
					@lang('tournament.your_tournaments')
					<small>[{{ count($tournaments) }}]</small>
				</h1>
            </div>
            
            
            <table class="table table-striped table-hover">

                <!-- Table Headings -->
                <thead>
                    <th>@lang('tournament.label')</th>
                    <th>@lang('tournament.date')</th>
                    <th style="width: 1px">&nbsp;</th>
                    <th style="width: 1px">&nbsp;</th>
                </thead>

                <!-- Table Body -->
                <tbody>
                    @foreach ($tournaments as $tournament)
                        <tr>
                            <td class="table-text">
                            	{{ $tournament->label }}
                            </td>
                            
                            <td class="table-text">
                            	{{ strftime("%d/%m/%Y") }}
                            </td>
	
                            <td>
                                <a href="{{ url('tournament/play/' . $tournament->id) }}" type="button" class="btn btn-primary">
                                	<i class="fa fa-play-circle-o"></i> @lang('tournament.play')
                            	</a>
                        	</td>
                        	<td>
                                <button type="button" class="btn btn-danger" onclick="showDeleteModal({{ $tournament->id }}, '{{ $tournament->label }}')">
                                	<i class="fa fa-trash-o"></i> @lang('tournament.delete')
                            	</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            
            <!-- New tournament form -->
            <div class="page-header">
				<h1>
            		@lang('tournament.new_tournament')
				</h1>
            </div>
            
            
            <!-- Form Error List -->
            <div class="alert alert-danger hidden" id="newTournamentFormErrors">
                <strong>@lang('tournament.error_create')</strong>
                <br>
                <ul>
                </ul>
            </div>
				
            <!-- New Tournament Form -->
            <?php echo Form::open(['class' => 'form-horizontal', 'id' => 'newTournamentForm']); ?>
                
    
                <!-- Label -->
                <div class="form-group">
                	<?php echo Form::label('label', Lang::get('tournament.label'), ['class' => 'col-sm-3 control-label']); ?>
    
                    <div class="col-sm-6">
                    	<?php echo Form::text('label', null, ['class' => 'form-control', 'maxlength' => 255]); ?>
                    </div>
                </div>
    
                <!-- Type -->
                <div class="form-group">
                	<?php echo Form::label('type', Lang::get('tournament.type'), ['class' => 'col-sm-3 control-label']); ?>
    
                    <div class="col-sm-6">
                        <?php echo Form::select('type', array(1 => 'card'), null, ['class' => 'form-control']); ?>
                    </div>
                </div>
    
                <!-- Add Task Button -->
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-6">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-trophy"></i> @lang('tournament.begin')
                        </button>
                    </div>
                </div>
                
                
            <?php echo Form::close(); ?>
            
            <script type="text/javascript">

            	$(document).ready(function() {
                	// Set submit function to create new tournament
                    $("#newTournamentForm").submit(function(event){
                        // cancels the form submission
                        event.preventDefault();
                        // Ajax call
                        $.ajax({
                            type: "POST",
                            url: "{{ url('tournament/create') }}",
                            dataType : 'json',
                            data: $("#newTournamentForm").serialize(),
                            success: function(json) {
                                if (json.status == "success") {
                                    // tournmanet successfully created
                                	window.location.replace("{{ url('tournament/play') }}/" + json.id);
                                } else {
                                    // error occured
                                    var ul = $("#newTournamentFormErrors ul");
                                    ul.empty();
                                	$.each(json.errors, function(key, data) {
                                    	ul.append($("<li>").text(data));
                                	});
                                    $("#newTournamentFormErrors").removeClass("hidden");
                                }
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                // error occured
                                var ul = $("#newTournamentFormErrors ul");
                                ul.empty();
                            }
                        });
                    });
            	});
                
            </script>
            
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
        <p>@lang('tournament.confirm_tournament_delete')</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal" id="modal-delete-button">
        	@lang('tournament.delete')
    	</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">
        	@lang('tournament.cancel')
    	</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">

/**
 * show modal dialog to delete a tournament 
 */
function showDeleteModal(tournamentId, tournamentLabel) {
	$("#modal-delete .modal-title").text(tournamentLabel);

	$("#modal-delete-button").off("click");
	$("#modal-delete-button").on( "click", function() {
		  alert( tournamentId );
		  // AJAX to delete tournament
	});
	
	$("#modal-delete").modal();
}

</script>

@endsection
