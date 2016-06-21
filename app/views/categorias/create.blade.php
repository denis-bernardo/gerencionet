@extends('template.template')
@section('content')
{{ Breadcrumbs::render('categorias_create') }}
<div class="row">
    <div class="col-sm-12">
        <h1 class="page-header">Categorias</h1>
    </div>
</div>
@if(isset($categoria))
<div class="row">
    <div class="col-sm-12">
        <div class="actions">
            <a href="{{URL::route('admin.categorias.create')}}" class="btn btn-success"><i class="fa fa-plus"></i> Adicionar categoria</a>
        </div>
    </div>
</div>
@endif 
<div class="row">
    <div class="col-sm-12">
        @include('partials.messages')
        <div class="panel panel-default">
            <div class="panel-heading">
                @if(isset($categoria))
                Editar categoria
                @else
                Adicionar nova categoria
                @endif                
            </div>
            <div class="panel-body">
                @if(isset($categoria))
                {{ Form::model($categoria, array('route' => array('admin.categorias.update', $categoria->id), 'method' => 'PUT')) }}
                @else
                {{ Form::open(['route' => 'admin.categorias.store', 'method' => 'POST']) }}
                @endif
                <div class="row">
                    <div class="clearfix">
                        <div class="form-group col-sm-2">
                            <label>Status</label>
                            {{ Form::select('status', ['1' => 'Ativo', '0' => 'Inativo'], Input::old('status'), ['class' => 'form-control']) }}
                        </div>
                        <div class="form-group col-sm-2">
                            <label>Criado em</label>
                            {{Form::text('created_at', isset($categoria) ? $categoria->created_at->timezone('America/Sao_Paulo')->format('d/m/Y H:i') : null, ['class' => 'form-control', 'readonly']) }}
                        </div>
                        <div class="form-group col-sm-2">
                            <label>Modificado em</label>
                            {{ Form::text('updated_at', isset($categoria) ? $categoria->updated_at->timezone('America/Sao_Paulo')->format('d/m/Y H:i') : null, ['class' => 'form-control', 'readonly']) }}
                        </div>
                    </div>
                    <div class="form-group required col-sm-12">
                        <label>Nome</label>
                        {{ Form::text('nome', Input::old('nome'), ['class' => 'form-control', 'required']) }}
                    </div>                    
                    <div class="form-group col-sm-6">
                        <label>Categoria-pai <span class="info fa fa-info" title="Categoria-pai" data-content="Ao definir uma categoria-pai, sua categoria se torna subcategoria."></span></label>
                        {{ Form::select('parent', Helpers::withEmpty($categorias, 'Nenhuma'), Input::old('parent'), ['class' => 'form-control']) }}
                    </div>
                    <div class="col-sm-12 text-right">                        
                        <button class="btn btn-success" type="submit">
                            <i class="fa fa-save"></i> SALVAR
                        </button>
                        {{ Form::close() }}
                        @if (isset($categoria))
                        {{ Form::open(['route' => ['admin.categorias.destroy', $categoria->id], 'method' => 'DELETE', 'class' => 'pull-right delete', 'data-message' => 'Deseja realmente deletar esta categoria? <small>(Categorias filhas também serão deletadas)</small>']) }}
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