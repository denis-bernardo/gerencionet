@extends('template.template')
@section('styles')
{{ HTML::style('css/dataTables.bootstrap.css') }}
{{ HTML::style('css/dataTables.responsive.css') }}
@stop
@section('content')
{{Breadcrumbs::render('config')}}
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Configurações</h1>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        @include('partials.messages')
        <div class="alert alert-ajax hide"><span></span></div>
        <div class="config-wrap">
            <ul id="config-tabs" class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#config-gerais" id="gerais-tab" role="tab" data-toggle="tab" aria-controls="config-gerais" aria-expanded="true">
                        Gerais
                    </a>
                </li>
                <li role="presentation">
                    <a href="#config-emails" role="tab" id="emails-tab" data-toggle="tab" aria-controls="config-emails" aria-expanded="false">
                        E-mail
                    </a>
                </li>
            </ul>
            <div id="config-content" class="tab-content">
                <div role="tabpanel" class="tab-pane fade active in row" id="config-gerais" aria-labelledby="config-gerais">
                    @if(isset($config))
                        {{Form::model($config, ['route' => ['admin.config.gerais.update', $config->id], 'method' => 'PUT'])}}
                    @else
                        {{Form::open(['route' => 'admin.config.gerais', 'method' => 'POST'])}}
                    @endif
                        <div class="form-group col-sm-6">
                            {{Form::label('gerais-nome', 'Nome do estabelecimento')}}
                            {{Form::text('nome_estabelecimento', Input::old('nome_estabelecimento'), ['class' => 'form-control', 'id' => 'gerais-nome', 'required'])}}
                        </div>
                        <div class="col-sm-12 text-right">
                            {{Form::submit('SALVAR', ['class' => 'btn btn-success'])}}
                        </div>
                    {{Form::close()}}
                </div>
                <div role="tabpanel" class="tab-pane fade {{!is_null(Input::old('email')) ? 'active in' : ''}} row" id="config-emails" aria-labelledby="config-emails">
                    @if(isset($configEmail))
                        {{Form::model($configEmail, ['route' => ['admin.config.emails.update', $configEmail->id], 'method' => 'PUT', 'novalidate'])}}
                    @else
                        {{Form::open(['route' => 'admin.config.emails', 'method' => 'POST'])}}
                    @endif
                        <div class="form-group col-sm-6">
                            {{Form::label('emails-email', 'Email')}}
                            {{Form::email('email', Input::old('email'), ['class' => 'form-control', 'required', 'id' => 'emails-email', 'autocomplete' => 'off'])}}
                        </div>
                        <div class="form-group col-sm-4">
                            {{Form::label('emails-servidor', 'Servidor SMTP')}}
                            {{Form::text('servidor', Input::old('servidor'), ['class' => 'form-control', 'required', 'id' => 'emails-servidor', 'autocomplete' => 'off'])}}
                        </div>
                        <div class="form-group col-sm-2">
                            {{Form::label('emails-porta', 'Porta')}}
                            {{Form::text('porta', Input::old('porta'), ['class' => 'form-control', 'required', 'id' => 'emails-porta', 'autocomplete' => 'off'])}}
                        </div>
                        <div class="form-group col-sm-4">
                            {{Form::label('emails-senha', 'Senha')}}
                            {{Form::password('senha', ['class' => 'form-control', isset($configEmail) ? 'disabled' : '', 'required', 'id' => 'emails-senha', 'autocomplete' => 'off'])}}
                        </div>
                        <div class="form-group col-sm-2">
                            <a href="javascript:void(0)" class="alterar-senha btn btn-info">Alterar senha</a>
                        </div>
                        <div class="form-group col-sm-4">
                            {{Form::label('emails-seguranca', 'Segurança')}}
                            {{Form::select('seguranca', ['' => 'Nenhuma criptografia', 'ssl' => 'SSL', 'tls' => 'TLS'], Input::old('seguranca') ? Input::old('seguranca') :  $configEmail->seguranca, ['class' => 'form-control', 'id' => 'emails-seguranca', 'autocomplete' => 'off'])}}
                        </div>
                        <div class="form-group col-sm-2">
                            {{Form::label('emails-autenticacao', 'Autenticação')}}
                            {{Form::select('autenticacao', ['1' => 'Sim', '0' => 'Não'], Input::old('autenticacao') ? Input::old('autenticacao') : $configEmail->autenticacao, ['class' => 'form-control', 'id' => 'emails-autenticacao', 'autocomplete' => 'off'])}}
                        </div>
                        <div class="col-sm-12 text-right">
                            <a class="emails-testar btn btn-info" href="javascript:void(0)">TESTAR ENVIO</a>
                            {{Form::submit('SALVAR', ['class' => 'btn btn-success'])}}
                        </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('scripts')
{{ HTML::script('js/vendor/jquery.dataTables.min.js') }}
{{ HTML::script('js/vendor/dataTables.bootstrap.min.js') }}
{{ HTML::script('js/vendor/bootbox.min.js') }}
@stop