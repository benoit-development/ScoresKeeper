@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('auth.login')</div>
                <div class="panel-body">
                	<div class="row text-center">
                        <a href="{{ url('/redirect/facebook') }}" class="btn btn-primary">
                        	<i class="fa fa-facebook-official fa-fw"></i> 
                        	Facebook
                    	</a>
                        <a href="{{ url('/redirect/google') }}" class="btn btn-danger">
                        	<i class="fa fa-google fa-fw"></i> 
                        	Google
                    	</a>
                        <a href="{{ url('/redirect/twitter') }}" class="btn btn-info">
                        	<i class="fa fa-twitter fa-fw"></i> 
                        	Twitter
                    	</a>
					</div>
					<div class="col-md-12">
						<br>
                		<hr>
                		<br>
					</div>
                    <div>
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                            {{ csrf_field() }}
    
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
    
                                <div class="col-md-8 col-md-offset-2">
    								<div class="input-group">
                                    	<span class="input-group-addon"><i class="fa fa-envelope fa-fw" aria-hidden="true"></i></span>
                                    	<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="@lang('auth.email_address')">
                                    </div>
    
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
    
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
    
                                <div class="col-md-8 col-md-offset-2">
    								<div class="input-group">
                                    	<span class="input-group-addon"><i class="fa fa-key fa-fw" aria-hidden="true"></i></span>
                                        <input id="password" type="password" class="form-control" name="password" required placeholder="@lang('auth.password')">
    								</div>
    								
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
    
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> @lang('auth.remember_me')
                                        </label>
                                    </div>
                                </div>
                            </div>
    
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-2">
                                    <button type="submit" class="btn btn-primary">
                                        @lang('auth.login')
                                    </button>
    
                                    <a class="btn btn-link" href="{{ url('/password/reset') }}">
                                        @lang('auth.forgot_password')
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
