@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('auth.register_form')</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    
                            <div class="col-md-8 col-md-offset-2">
								<div class="input-group">
                                	<span class="input-group-addon"><i class="fa fa-user fa-fw" aria-hidden="true"></i></span>
                            		<input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus placeholder="@lang('auth.name')">
                            	</div>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-md-8 col-md-offset-2">
								<div class="input-group">
                                	<span class="input-group-addon"><i class="fa fa-envelope fa-fw" aria-hidden="true"></i></span>
                                	<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="@lang('auth.email_address')">
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

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <div class="col-md-8 col-md-offset-2">
								<div class="input-group">
                                	<span class="input-group-addon"><i class="fa fa-key fa-fw" aria-hidden="true"></i></span>
                                	<input id="password" type="password" class="form-control" name="password_confirmation" required placeholder="@lang('auth.confirm_password')">
                            	</div>

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-2">
                                <button type="submit" class="btn btn-primary">
                                    @lang('auth.register')
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
