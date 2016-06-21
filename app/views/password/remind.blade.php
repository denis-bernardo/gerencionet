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
                    <form action="{{URL::route('login.reminder.post')}}" method="POST">
                        <fieldset>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" autofocus placeholder="Email">
                            </div>
                            <input type="submit" value="Enviar" class="btn btn-lg btn-block btn-success">
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop