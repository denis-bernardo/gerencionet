@extends('template.template')
@section('content')
{{ Breadcrumbs::render('estoque_create') }}
<div class="row">
    <div class="col-sm-12">
        <h1 class="page-header">Estoque</h1>
    </div>
</div>
@if(isset($estoque))
<div class="row">
    <div class="col-sm-12">
        <div class="actions">
            <a href="{{URL::route('admin.estoque.create')}}" class="btn btn-success"><i class="fa fa-plus"></i> Adicionar estoque</a>
        </div>
    </div>
</div>
@endif 
<div class="row">
    <div class="col-sm-12">
        @include('partials.messages')
        <div class="panel panel-default">
            <div class="panel-heading">
                @if(isset($estoque))
                Editar estoque
                @else
                Adicionar novo estoque
                @endif                
            </div>
            <div class="panel-body">
                @if(isset($estoque))
                {{ Form::model($estoque, array('route' => array('admin.estoque.update', $estoque->id), 'method' => 'PUT')) }}
                @else
                {{ Form::open(['route' => 'admin.estoque.store', 'method' => 'POST']) }}
                @endif
                <div class="row">
                    <div class="clearfix">
                        <div class="form-group col-sm-2">
                            <label>Criado em</label>
                            {{ Form::text('created_at', isset($estoque) ? $estoque->created_at->timezone('America/Sao_Paulo')->format('d/m/Y H:i') : null, ['class' => 'form-control', 'readonly']) }}
                        </div>
                        <div class="form-group col-sm-2">
                            <label>Modificado em</label>
                            {{ Form::text('updated_at', isset($estoque) ? $estoque->updated_at->timezone('America/Sao_Paulo')->format('d/m/Y H:i') : null, ['class' => 'form-control', 'readonly']) }}
                        </div>
                    </div>
                    <div class="form-group required col-sm-6">
                        <label>Item</label>
                        {{ Form::text('item', Input::old('item'), ['class' => 'form-control', 'required']) }}
                    </div>
                    <div class="form-group required col-sm-6">
                        <label>Preço unitário</label>
                        <div class="input-group">
                            <span class="input-group-addon">R$</span>
                            {{ Form::text('preco', Input::old('preco'), ['class' => 'form-control money', 'required']) }}
                        </div>
                    </div>
                    <div class="form-group required col-sm-3">
                        <label>Unidade</label>
                        {{ Form::select('id_unidades', $unidades, Input::old('id_unidades'), ['class' => 'form-control', 'required']) }}
                    </div>
                    <div class="form-group required col-sm-3">
                        <label>Quantidade</label>
                        {{ Form::text('quantidade', Input::old('quantidade'), ['class' => 'form-control', 'required']) }}
                    </div>                    
                    <div class="form-group required col-sm-6">
                        <label>Quantidade mínima <span class="info fa fa-info" title="Quantidade mínima" data-content="Caso a quantidade do item esteja igual ou menor que a quantidade mínima definida, o sistema irá notifica-lo."></span></label>
                        {{ Form::text('minimo', Input::old('minimo'), ['class' => 'form-control', 'required']) }}
                    </div>
                    <div class="col-sm-12 text-right">                        
                        <button class="btn btn-success" type="submit">
                            <i class="fa fa-save"></i> SALVAR
                        </button>
                        {{ Form::close() }}
                        @if (isset($estoque))
                        {{ Form::open(['route' => ['admin.estoque.destroy', $estoque->id], 'method' => 'DELETE', 'class' => 'pull-right delete', 'data-message' => 'Deseja realmente deletar este estoque?']) }}
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