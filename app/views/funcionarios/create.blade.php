@extends('template.template')
@section('content')
{{ Breadcrumbs::render('funcionarios_create') }}
<div class="row">
    <div class="col-sm-12">
        <h1 class="page-header">Funcionários</h1>
    </div>
</div>
@if(isset($funcionario))
<div class="row">
    <div class="col-sm-12">
        <div class="actions">
            <a href="{{URL::route('admin.funcionarios.create')}}" class="btn btn-success"><i class="fa fa-plus"></i> Adicionar funcionário</a>
        </div>
    </div>
</div>
@endif 
<div class="row">
    <div class="col-sm-12">
        @include('partials.messages')
        <div class="panel panel-default">
            <div class="panel-heading">
                @if(isset($funcionario))
                Editar funcionário
                @else
                Adicionar novo funcionário
                @endif                
            </div>
            <div class="panel-body">
                @if(isset($funcionario))
                {{ Form::model($funcionario, array('route' => array('admin.funcionarios.update', $funcionario->id), 'method' => 'PUT')) }}
                @else
                {{ Form::open(['route' => 'admin.funcionarios.store', 'method' => 'POST']) }}
                @endif
                <div class="row">
                    <div class="clearfix">
                        <div class="form-group col-sm-2">
                            <label>Status</label>
                            {{ Form::select('status', ['1' => 'Ativo', '0' => 'Inativo'], Input::old('status'), ['class' => 'form-control']) }}
                        </div>
                        <div class="form-group col-sm-2">
                            <label>Criado em</label>
                            {{ Form::text('created_at', isset($funcionario) ? $funcionario->created_at->timezone('America/Sao_Paulo')->format('d/m/Y H:i') : null, ['class' => 'form-control', 'readonly']) }}
                        </div>
                        <div class="form-group col-sm-2">
                            <label>Modificado em</label>
                            {{ Form::text('updated_at', isset($funcionario) ? $funcionario->updated_at->timezone('America/Sao_Paulo')->format('d/m/Y H:i') : null, ['class' => 'form-control', 'readonly']) }}
                        </div>
                    </div>
                    <div class="form-group required col-sm-12">
                        <label>Nome</label>
                        {{ Form::text('nome', Input::old('nome'), ['class' => 'form-control', 'required']) }}
                    </div>
                    <div class="form-group required col-sm-6">
                        <label>Função</label>
                        {{ Form::text('funcao', Input::old('funcao'), ['class' => 'form-control', 'required']) }}
                    </div>
                    <div class="form-group col-sm-2">
                        <label>Entregador</label>
                        {{ Form::select('entregador', ['1' => 'Sim', '0' => 'Não'], Input::old('entregador'), ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group col-sm-4">
                        <label>Salário</label>
                        <div class="input-group">
                            <span class="input-group-addon">R$</span>
                            {{ Form::text('salario', Input::old('salario'), ['class' => 'form-control money']) }}
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Email</label>
                        {{ Form::email('email', Input::old('email'), ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Data de nascimento</label>
                        <div class='input-group datepicker'>
                            {{ Form::text('data_nascimento', isset($funcionario) ? $funcionario->data_nascimento->format('d/m/Y') :  Input::old('data_nascimento'), ['class' => 'form-control date']) }}
                            <span class="input-group-addon">
                                <span class="fa fa-calendar"></span>
                            </span>
                        </div>      
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Documento (CPF ou CNPJ)</label>
                        {{ Form::text('documento', Input::old('documento'), ['class' => 'form-control', 'onkeypress' => 'return isNumber(event)']) }}
                        <span class="help-block">Somente números</span>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>RG</label>
                        {{ Form::text('rg', Input::old('rg'), ['class' => 'form-control', 'onkeypress' => 'return isNumber(event)']) }}
                        <span class="help-block">Somente números</span>
                    </div>
                    <div class="form-group required col-sm-6">
                        <label>Telefone</label>
                        {{ Form::text('telefone', Input::old('telefone'), ['class' => 'form-control tel-mask', 'required']) }}
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Celular</label>
                        {{ Form::text('celular', Input::old('celular'), ['class' => 'form-control tel-mask']) }}
                    </div>                    
                    <div class="form-group input-group col-sm-6">
                        <label>CEP</label>
                        {{ Form::text('cep', Input::old('cep'), ['class' => 'form-control cep', 'maxlength' => '8', 'onkeypress' => 'return isNumber(event)']) }}
                        <span class="input-group-btn">
                            <button class="btn btn-default btn-cep" type="button"><i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                    <div class="form-group required col-sm-4">
                        <label>Logradouro</label>
                        {{ Form::text('logradouro', Input::old('logradouro'), ['class' => 'form-control logradouro', 'required']) }}
                    </div>
                    <div class="form-group required col-sm-2">
                        <label>Numero</label>
                        {{ Form::text('numero', Input::old('numero'), ['class' => 'form-control', 'required']) }}
                    </div>
                    <div class="form-group required col-sm-6">
                        <label>Bairro</label>
                        {{ Form::text('bairro', Input::old('bairro'), ['class' => 'form-control bairro', 'required']) }}
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Complemento</label>
                        {{ Form::text('complemento', Input::old('complemento'), ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group required col-sm-6">
                        <label>Cidade</label>
                        {{ Form::text('cidade', Input::old('cidade'), ['class' => 'form-control cidade', 'required']) }}
                    </div>
                    <div class="form-group required col-sm-6">
                        <label>Estado</label>
                        {{ Form::text('estado', Input::old('estado'), ['class' => 'form-control estado', 'required']) }}
                    </div>
                    <div class="form-group col-sm-12">
                        <label>Observação</label>
                        {{ Form::textarea('obs', Input::old('obs'), ['class' => 'form-control', 'rows' => '5']) }}
                    </div>
                    <div class="col-sm-12 text-right">                        
                        <button class="btn btn-success" type="submit">
                            <i class="fa fa-save"></i> SALVAR
                        </button>
                        {{ Form::close() }}
                        @if (isset($funcionario))
                        {{ Form::open(['route' => ['admin.funcionarios.destroy', $funcionario->id], 'method' => 'DELETE', 'class' => 'pull-right delete', 'data-message' => 'Deseja realmente deletar este funcionário?']) }}
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