@extends('template.template')
@section('styles')
{{ HTML::style('css/dataTables.bootstrap.css') }}
{{ HTML::style('css/dataTables.responsive.css') }}
@stop
@section('content')
{{ Breadcrumbs::render('produtos_create') }}
<div class="row">
    <div class="col-sm-12">
        <h1 class="page-header">Produtos</h1>
    </div>
</div>
@if(isset($produto))
<div class="row">
    <div class="col-sm-12">
        <div class="actions">
            <a href="{{URL::route('admin.produtos.create')}}" class="btn btn-success"><i class="fa fa-plus"></i> Adicionar produto</a>
        </div>
    </div>
</div>
@endif
@if(isset($produto))
{{ Form::model($produto, array('route' => array('admin.produtos.update', $produto->id), 'method' => 'PUT')) }}
@else
{{ Form::open(['route' => 'admin.produtos.store', 'method' => 'POST']) }}
@endif
<div class="row">
    <div class="col-sm-12">
        @include('partials.messages')
        <div class="panel panel-default">
            <div class="panel-heading">
                Dados do produto
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="clearfix">
                        <div class="form-group col-sm-2">
                            <label>Status</label>
                            {{ Form::select('status', ['1' => 'Ativo', '0' => 'Inativo'], Input::old('status'), ['class' => 'form-control']) }}
                        </div>
                        <div class="form-group col-sm-2">
                            <label>Criado em</label>
                            {{ Form::text('created_at', isset($produto) ? $produto->created_at->timezone('America/Sao_Paulo')->format('d/m/Y H:i') : null, ['class' => 'form-control', 'readonly']) }}
                        </div>
                        <div class="form-group col-sm-2">
                            <label>Modificado em</label>
                            {{ Form::text('updated_at', isset($produto) ? $produto->updated_at->timezone('America/Sao_Paulo')->format('d/m/Y H:i') : null, ['class' => 'form-control', 'readonly']) }}
                        </div>
                    </div>
                    <div class="form-group required col-sm-2">
                        <label>Referência</label>
                        {{ Form::text('referencia', Input::old('referencia'), ['class' => 'form-control', 'required']) }}
                    </div>
                    <div class="form-group required col-sm-6">
                        <label>Nome</label>
                        {{ Form::text('nome', Input::old('nome'), ['class' => 'form-control', 'required']) }}
                    </div>
                    <div class="form-group required col-sm-4">
                        <label>Categoria</label>
                        <select name="categorias_id" class="form-control">
                            @foreach($categorias as $k => $v)
                            <option value="{{$v->id}}">{{$v->nome}}</option>
                            @endforeach
                        </select>
                    </div>                    
                </div>                
            </div>
        </div>
    </div>
    @if(isset($estoque))
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Composição do produto
            </div>
            <div class="panel-body">
                <table class="produto-itens table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Quantidade</th>
                            <th>Preço unitário</th>
                            <th>Preço total</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($produto))
                            @foreach($produto->estoque as $item)
                            <tr data-id="{{$item->id}}">
                                <td>
                                    {{$item->item}}
                                    <input type="hidden" name="id_estoque[{{$item->id}}][quantidade]" value="{{$item->pivot->quantidade}}">
                                    <input type="hidden" name="id_estoque[{{$item->id}}][valor]" value="{{$item->pivot->valor}}">
                                </td>
                                <td>{{$item->pivot->quantidade}}</td>
                                <td>{{Helpers::toMoney($item->preco)}}</td>
                                <td class="produto-itens-total">{{Helpers::toMoney($item->pivot->valor)}}</td>
                                <td><a href="javascript:void(0)" class="remove-item btn btn-danger"><i class="fa fa-trash-o"></i></a></td>
                            </tr>
                            @endforeach 
                        @endif
                    </tbody>
                </table>
                <div class="text-right">
                    <a class="add-estoque btn btn-success" href="javascript:void(0)">
                        <i class="fa fa-plus"></i> ADICIONAR
                    </a>
                </div>
            </div>
        </div>
        <div class="estoque-modal modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Estoque</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Item</label>
                                    <select class="form-control estoque-list">
                                        <option value="0">Selecione um item</option>
                                        @foreach($estoque as $k => $v)
                                        <option value="{{$v->id}}">{{$v->item}}</option>
                                        @endforeach
                                    </select>
                                </div>                               
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Quantidade</label>
                                    <input type="text" class="form-control estoque-qtd" readonly>
                                </div>                                                                
                            </div>
                            <div class="col-sm-12">
                                <div class="estoque-info hide form-group">
                                    <label></label>
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Cod.</th>
                                                <th>Quantidade</th>
                                                <th>Preço</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="estoque-info-cod"></td>
                                                <td class="estoque-info-qtd"></td>
                                                <td class="estoque-info-preco"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        <button type="button" class="estoque-add btn btn-primary">Salvar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Valor do produto
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group required col-sm-6">
                        <label>Preço de custo</label>
                        <div class="input-group">
                            <span class="input-group-addon">R$</span>
                            {{Form::text('preco_custo', Input::old('preco_custo'), ['class' => 'preco_custo money form-control', 'required'])}}
                        </div>
                    </div>
                    <div class="form-group col-sm-2">
                        <label>Margem de lucro</label>
                        <div class="input-group">                            
                            {{Form::text('margem', Input::old('margem'), ['class' => 'margem form-control'])}}
                            <span class="input-group-addon">%</span>
                        </div>
                    </div>
                    <div class="form-group col-sm-4">
                        <label>Preço final</label>
                        <div class="input-group">
                            <span class="input-group-addon">R$</span>
                            {{Form::text('preco_final', Input::old('preco_custo'), ['class' => 'preco_final money form-control'])}}
                        </div>
                    </div>
                </div> 
                <div class="text-right">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> SALVAR
                    </button>
                    <a href="javascript:void(0)" class="delete-product btn btn-danger">
                        <i class="fa fa-trash-o"></i> DELETAR
                    </a>
                </div>                
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
@if(isset($produto))
    <div class="delete-product-modal modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Alerta</h4>
                </div>
                <div class="modal-body">
                    <p>Deseja realmente deletar este produto?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">FECHAR</button>
                    <div class="pull-right">
                        {{ Form::open(['route' => ['admin.produtos.destroy', $produto->id], 'method' => 'DELETE']) }}
                            <button type="submit" class="delete-product btn btn-danger">
                                <i class="fa fa-trash-o"></i> DELETAR
                            </button>
                        {{Form::close()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@stop
@section('scripts')
{{ HTML::script('js/vendor/jquery.dataTables.min.js') }}
{{ HTML::script('js/vendor/dataTables.bootstrap.min.js') }}
{{ HTML::script('js/vendor/bootbox.min.js') }}
@stop