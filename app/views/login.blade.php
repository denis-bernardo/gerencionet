@extends('template.login')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Acesso | Gerencionet</h3>
                </div>
                <div class="panel-body">
                    @if ($errors->has())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                        {{ $error }}<br>        
                        @endforeach
                    </div>
                    @endif
                    {{Form::open(['url' => 'login'])}}
                    <fieldset>
                        <div class="form-group">
                            {{Form::text('email', Input::old('email'), ['placeholder' => 'E-mail', 'class' => 'form-control', 'autofocus'])}}
                        </div>
                        <div class="form-group">
                            {{Form::password('password', ['placeholder' => 'Senha', 'class' => 'form-control'])}}
                        </div>
                        {{Form::submit('Login', ['class' => 'btn btn-lg btn-success btn-block'])}}
                        <div class="form-group text-right">
                            <a href="{{URL::route('login.reminder')}}" class="help-block"><small>Esqueci minha senha</small></a>
                        </div>
                    </fieldset>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
</div>
@stop