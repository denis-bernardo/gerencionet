@extends('template.template')
@section('content')
{{ Breadcrumbs::render('contas_create') }}
<div class="row">
    <div class="col-sm-12">
        <h1 class="page-header">Contas a pagar</h1>
    </div>
</div>
@if(isset($conta))
<div class="row">
    <div class="col-sm-12">
        <div class="actions">
            <a href="{{URL::route('admin.contas.create')}}" class="btn btn-success"><i class="fa fa-plus"></i> Adicionar conta</a>
        </div>
    </div>
</div>
@endif 
<div class="row">
    <div class="col-sm-12">
        @include('partials.messages')
        <div class="panel panel-default">
            <div class="panel-heading">
                @if(isset($conta))
                Editar conta
                @else
                Adicionar nova conta
                @endif                
            </div>
            <div class="panel-body">
                @if(isset($conta))
                {{ Form::model($conta, array('route' => array('admin.contas.update', $conta->id), 'method' => 'PUT')) }}
                @else
                {{ Form::open(['route' => 'admin.contas.store', 'method' => 'POST']) }}
                @endif
                <div class="row">
                    <div class="clearfix">
                        <div class="form-group col-sm-2">
                            <label>Paga?</label>
                            {{ Form::select('paga', ['0' => 'Não', '1' => 'Sim'], Input::old('paga'), ['class' => 'form-control']) }}
                        </div>
                        <div class="form-group col-sm-2">
                            <label>Criado em</label>
                            {{ Form::text('created_at', isset($conta) ? $conta->created_at->timezone('America/Sao_Paulo')->format('d/m/Y H:i') : null, ['class' => 'form-control', 'readonly']) }}
                        </div>
                        <div class="form-group col-sm-2">
                            <label>Modificado em</label>
                            {{ Form::text('updated_at', isset($conta) ? $conta->updated_at->timezone('America/Sao_Paulo')->format('d/m/Y H:i') : null, ['class' => 'form-control', 'readonly']) }}
                        </div>
                    </div>
                    <div class="form-group required col-sm-12">
                        <label>Nome</label>
                        {{ Form::text('nome', Input::old('nome'), ['class' => 'form-control', 'required']) }}
                    </div>                    
                    <div class="form-group required col-sm-6">
                        <label>Valor</label>
                        <div class="input-group">
                            <span class="input-group-addon">R$</span>
                            {{ Form::text('valor', Input::old('valor'), ['class' => 'form-control money', 'required']) }}
                        </div>
                    </div>
                    <div class="form-group required col-sm-6">
                        <label>Data de vencimento</label>
                        <div class='input-group datepicker'>
                            {{ Form::text('vencimento', isset($conta) ? $conta->vencimento->format('d/m/Y') :  Input::old('vencimento'), ['class' => 'form-control date', 'required']) }}
                            <span class="input-group-addon">
                                <span class="fa fa-calendar"></span>
                            </span>
                        </div>                        
                    </div>
                    <div class="form-group col-sm-12">
                        <label>Descrição</label>
                        {{ Form::textarea('descricao', Input::old('descricao'), ['class' => 'form-control', 'rows' => '5']) }}
                    </div>
                    <div class="col-sm-12 text-right">                        
                        <button class="btn btn-success" type="submit">
                            <i class="fa fa-save"></i> SALVAR
                        </button>
                        {{ Form::close() }}
                        @if (isset($conta))
                        {{ Form::open(['route' => ['admin.contas.destroy', $conta->id], 'method' => 'DELETE', 'class' => 'pull-right delete', 'data-message' => 'Deseja realmente deletar esta conta?']) }}
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