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
            
            

            <table class="grid table table-striped table-hover" id="tableScores">  
                <thead>  
                <tr>
                	<th width="1px"></th>
                	<th width="1px"><?php echo trans_choice('player.players', 5); ?></th>
                	<th>1</th>
                </tr>  
                </thead>  
                <tbody>  
                    <tr><td class="handle"><i class="fa fa-arrows-v"></i></td><td>Slaughterhouse-Five</td><td>A+</td></tr>  
                    <tr><td class="handle"><i class="fa fa-arrows-v"></i></td><td>B</td><td></td></tr>  
                    <tr><td class="handle"><i class="fa fa-arrows-v"></i></td><td>Cat’s Cradle</td><td>A+</td></tr>  
                    <tr><td class="handle"><i class="fa fa-arrows-v"></i></td><td>Breakfast of Champions</td><td>C</td></tr>    
                </tbody>
                <tfoot>
                    <tr>
                    	<td></td>
                    	<td>
				        	<!-- FORM to add a new player -->
				        	<?php echo Form::open(['class' => 'form-inline', 'id' => 'newTournamentForm']); ?>
				        	
                                <!-- Payer name -->
                                <div class="form-group">
                                    <div class="form-group">
                                    	<?php echo Form::text('name', null, ['class' => 'form-control', 'maxlength' => 255, 'placeholder' => trans('player.new_player')]); ?>
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

});

</script>

@endsection