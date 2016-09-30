@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
        
        	<!-- Created tournaments -->
            <div class="page-header">
				<h1>
					@lang('tournament.your_tournaments')
					<small>[]</small>
				</h1>
            </div>
            
            <!-- New tournament form -->
            <div class="page-header">
				<h1>
            	@lang('tournament.new_tournament')
				</h1>
            </div>
            
            
				
            <!-- New Task Form -->
            <?php echo Form::open(['url' => '/tournament/new', 'class' => 'form-horizontal']); ?>
                
    
                <!-- Label -->
                <div class="form-group">
                	<?php echo Form::label('label', Lang::get('tournament.label'), ['class' => 'col-sm-3 control-label']); ?>
    
                    <div class="col-sm-6">
                    	<?php echo Form::text('label', null, ['class' => 'form-control']); ?>
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
                            <i class="fa fa-plus"></i> @lang('tournament.add')
                        </button>
                    </div>
                </div>
                
                
            <?php echo Form::close(); ?>
            
        </div>
    </div>
</div>
@endsection
