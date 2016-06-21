@extends('template.template')
@section('content')
{{ Breadcrumbs::render('usuarios_create') }}
<div class="row">
    <div class="col-sm-12">
        <h1 class="page-header">Usuários</h1>
    </div>
</div>
@if(isset($usuario))
<div class="row">
    <div class="col-sm-12">
        <div class="actions">
            <a href="{{URL::route('admin.usuarios.create')}}" class="btn btn-success"><i class="fa fa-plus"></i> Adicionar usuário</a>
        </div>
    </div>
</div>
@endif 
<div class="row">
    <div class="col-sm-12">
        @include('partials.messages')
        <div class="panel panel-default">
            <div class="panel-heading">
                @if(isset($usuario))
                Editar usuário
                @else
                Adicionar novo usuário
                @endif                
            </div>
            <div class="panel-body">
                @if(isset($usuario))
                {{ Form::model($usuario, array('route' => array('admin.usuarios.update', $usuario->id), 'method' => 'PUT')) }}
                @else
                {{ Form::open(['route' => 'admin.usuarios.store', 'method' => 'POST']) }}
                @endif
                <div class="row">
                    <div class="clearfix">
                        <div class="form-group col-sm-2">
                            <label>Status</label>
                            {{ Form::select('status', ['1' => 'Ativo', '0' => 'Inativo'], Input::old('status'), ['class' => 'form-control']) }}
                        </div>
                        <div class="form-group col-sm-2">
                            <label>Criado em</label>
                            {{ Form::text('created_at', isset($usuario) ? $usuario->created_at->timezone('America/Sao_Paulo')->format('d/m/Y H:i') : null, ['class' => 'form-control', 'readonly']) }}
                        </div>
                        <div class="form-group col-sm-2">
                            <label>Modificado em</label>
                            {{ Form::text('updated_at', isset($usuario) ? $usuario->updated_at->timezone('America/Sao_Paulo')->format('d/m/Y H:i') : null, ['class' => 'form-control', 'readonly']) }}
                        </div>
                    </div>
                    <div class="form-group required col-sm-12">
                        <label>Nome</label>
                        {{ Form::text('nome', Input::old('nome'), ['class' => 'form-control', 'required']) }}
                    </div>
                    <div class="form-group required col-sm-6">
                        <label>Email</label>
                        {{ Form::email('email', Input::old('email'), ['class' => 'form-control', 'required', isset($usuario) ? 'readonly' : '']) }}
                    </div>
                    @if(isset($usuario))
                    <div class="form-group col-sm-6">
                        <a href="javascript:void" class="show-fields-user btn btn-primary"><i class="fa fa-lock"></i> Alterar senha</a>
                    </div>                    
                    @endif
                    <div class="form-group {{isset($usuario) ? 'field-disabled' : ''}} required col-sm-3">
                        <label>Senha</label>
                        {{ Form::password('password', ['class' => 'form-control', 'required', isset($usuario) ? 'disabled' : '']) }}
                    </div>
                    <div class="form-group {{isset($usuario) ? 'field-disabled' : ''}} required col-sm-3">
                        <label>Confirmar senha</label>
                        {{ Form::password('confirm', ['class' => 'form-control', 'required', isset($usuario) ? 'disabled' : '']) }}
                    </div>
                    <div class="col-sm-12 text-right">                        
                        <button class="btn btn-success" type="submit">
                            <i class="fa fa-save"></i> SALVAR
                        </button>
                        {{ Form::close() }}
                        @if (isset($usuario))
                        {{ Form::open(['route' => ['admin.usuarios.destroy', $usuario->id], 'method' => 'DELETE', 'class' => 'pull-right delete', 'data-message' => 'Deseja realmente deletar este usuário?']) }}
                        <button class="btn btn-danger" type="submit">
                            <i class="fa fa-trash"></i> DELETAR
                        </button>                        
                        {{ Form::close() }}
                        @endif
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>
@stop
@section('scripts')
{{ HTML::script('js/vendor/bootbox.min.js') }}
@stop