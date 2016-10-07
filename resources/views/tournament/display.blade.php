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
      
            
        </div>
    </div>
</div>
@endsection