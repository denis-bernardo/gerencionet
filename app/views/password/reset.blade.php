@extends('template.login')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Esqueci minha senha | Gerencionet</h3>
                </div>
                <div class="panel-body">
                    @if ($errors->has())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                        <% $error %><br>        
                        @endforeach
                    </div>
                    @endif
                    <form action="{{URL::route('login.reset.post') }}" method="POST">
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group">
                            <input type="email" name="email" placeholder="Email" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" placeholder="Nova senha" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password_confirmation" placeholder="Confirmar nova senha" class="form-control">
                        </div>
                        <input type="submit" value="Enviar" class="btn btn-lg btn-block btn-success">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop