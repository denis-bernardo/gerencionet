@extends('template.template')
@section('content')
{{ Breadcrumbs::render('unidades_create') }}
<div class="row">
    <div class="col-sm-12">
        <h1 class="page-header">Unidades</h1>
    </div>
</div>
@if(isset($unidade))
<div class="row">
    <div class="col-sm-12">
        <div class="actions">
            <a href="{{URL::route('admin.unidades.create')}}" class="btn btn-success"><i class="fa fa-plus"></i> Adicionar unidade</a>
        </div>
    </div>
</div>
@endif 
<div class="row">
    <div class="col-sm-12">
        @include('partials.messages')
        <div class="panel panel-default">
            <div class="panel-heading">
                @if(isset($unidade))
                Editar unidade
                @else
                Adicionar nova unidade
                @endif                
            </div>
            <div class="panel-body">
                @if(isset($unidade))
                {{ Form::model($unidade, array('route' => array('admin.unidades.update', $unidade->id), 'method' => 'PUT')) }}
                @else
                {{ Form::open(['route' => 'admin.unidades.store', 'method' => 'POST']) }}
                @endif
                <div class="row">
                    <div class="clearfix">
                        <div class="form-group col-sm-2">
                            <label>Criado em</label>
                            {{ Form::text('created_at', isset($unidade) ? $unidade->created_at->timezone('America/Sao_Paulo')->format('d/m/Y H:i') : null, ['class' => 'form-control', 'readonly']) }}
                        </div>
                        <div class="form-group col-sm-2">
                            <label>Modificado em</label>
                            {{ Form::text('updated_at', isset($unidade) ? $unidade->updated_at->timezone('America/Sao_Paulo')->format('d/m/Y H:i') : null, ['class' => 'form-control', 'readonly']) }}
                        </div>
                    </div>
                    <div class="form-group required col-sm-12">
                        <label>Nome</label>
                        {{ Form::text('nome', Input::old('nome'), ['class' => 'form-control', 'required']) }}
                    </div>
                    <div class="col-sm-12 text-right">                        
                        <button class="btn btn-success" type="submit">
                            <i class="fa fa-save"></i> SALVAR
                        </button>
                        {{ Form::close() }}
                        @if (isset($unidade))
                        {{ Form::open(['route' => ['admin.unidades.destroy', $unidade->id], 'method' => 'DELETE', 'class' => 'pull-right delete', 'data-message' => 'Deseja realmente deletar esta unidade?']) }}
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