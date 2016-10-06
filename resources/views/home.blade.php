@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
        
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
                    <th style="width: 1px">&nbsp;</th>
                    <th style="width: 1px">&nbsp;</th>
                </thead>

                <!-- Table Body -->
                <tbody>
                    @foreach ($tournaments as $tournament)
                        <tr>
                            <!-- Task Name -->
                            <td class="table-text">
                            	{{ $tournament->label }}
                            </td>

                            <td>
                                <a href="{{ url('tournament/play/' . $tournament->id) }}" type="button" class="btn btn-primary btn-sm">
                                	<i class="fa fa-play"></i> @lang('tournament.play')
                            	</a>
                        	</td>
                        	<td>
                                <button type="button" class="btn btn-danger btn-sm">
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
            
            
            @if (count($errors) > 0)
                <!-- Form Error List -->
                <div class="alert alert-danger">
                    <strong>@lang('tournament.error_create')</strong>
            
                    <br>
            
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
				
            <!-- New Task Form -->
            <?php echo Form::open(['url' => '/tournament/create', 'class' => 'form-horizontal']); ?>
                
    
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
            
        </div>
    </div>
</div>
@endsection
