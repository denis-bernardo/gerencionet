@extends('template.template')
@section('styles')
{{ HTML::style('css/dataTables.bootstrap.css') }}
{{ HTML::style('css/dataTables.responsive.css') }}
@stop
@section('content')
{{ Breadcrumbs::render('pedidos_create') }}
<div class="row">
    <div class="col-sm-12">
        <h1 class="page-header">Pedidos</h1>
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
@if(isset($pedido))
{{ Form::model($pedido, array('route' => array('admin.pedidos.update', $pedido->id), 'method' => 'PUT')) }}
@else
{{ Form::open(['route' => 'admin.pedidos.store', 'method' => 'POST']) }}
@endif
<div class="row">
    <div class="col-sm-12">
        @include('partials.messages')
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="badge">1</span> Dados do cliente e mesas
            </div>
            <div class="panel-body">
                <span class="help-block">Informe o telefone do cliente para buscar os seus dados. Caso não encontre, <a href="{{URL::route('admin.clientes.create')}}" class="label label-success">cadastre o cliente</a></span>
                <div class="row">
                    <div class="form-group input-group col-sm-6">
                        <label>Buscar cliente <span class="cliente-404 label label-danger hide">Nenhum usuário encontrado</span></label>
                        {{ Form::text('busca', Input::old('busca'), ['class' => 'telefone-cliente form-control tel-mask', 'placeholder' => 'Ex.: (43) 3333-3333']) }}
                        <span class="input-group-btn">
                            <button class="buscar-cliente btn btn-default" type="button">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                    <div class="form-group col-sm-3">
                        <label>Entrega?</label>
                        {{Form::select('selecionar_entregador', ['1' => 'Sim', '0' => 'Não'], isset($pedido) && $pedido->entrega ? 1 : 0, ['class' => 'select-entrega form-control'])}}
                    </div>                 
                </div>
                <div class="row">
                    <div class="form-group input-group col-sm-6">
                        <label>Vincular a mesa</label>
                        {{ Form::select('id_mesa', Helpers::withEmpty(isset($mesas) ? $mesas : [], 'Nenhuma'), Input::old('id_mesa'), ['class' => 'form-control id_mesa'])}}
                    </div>                       
                    <div class="entregador-group form-group col-sm-6">
                        <label>Selecionar entregador</label>
                        {{Form::select('entrega', $entregador, Input::old('entrega'), ['class' => 'entregador form-control'])}}
                    </div>                 
                </div>
                <div class="cliente-pedido row">
                    <div class="col-dados col-sm-6">
                        <label class="label label-primary">Dados do cliente</label>
                        <div class="form-group">
                            <label>Nome</label>
                            {{Form::hidden('id_cliente', isset($cliente) ? $cliente->id : Input::old('id_cliente'), ['class' => 'pedido-idcliente'])}}
                            {{Form::text('nome', isset($cliente) ? $cliente->nome : Input::old('nome'), ['class' => 'pedido-nome form-control'])}}
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            {{Form::text('email', isset($cliente, $cliente->email) ? $cliente->email : Input::old('email'), ['class' => 'pedido-email form-control'])}}
                        </div>
                        <div class="form-group">
                            <label>Telefone</label>
                            {{Form::text('telefone', isset($cliente) ? $cliente->telefone : Input::old('telefone'), ['class' => 'pedido-telefone form-control'])}}
                        </div>
                        <div class="form-group">
                            <label>Celular</label>
                            {{Form::text('celular', isset($cliente, $cliente->celular) ? $cliente->celular : Input::old('celular'), ['class' => 'pedido-celular form-control'])}}
                        </div>                        
                    </div>
                    <div class="col-entrega col-sm-6">
                        <label class="label label-primary">Dados de entrega</label>
                        <div class="row">
                            <div class="form-group input-group col-sm-6">
                                <label>CEP</label>
                                {{ Form::text('e_cep', isset($cliente, $cliente->cep) ? $cliente->cep : Input::old('e_cep'), ['class' => 'pedido-cep form-control cep', 'maxlength' => '8', 'onkeypress' => 'return isNumber(event)']) }}
                                <span class="input-group-btn">
                                    <button class="btn btn-default btn-cep" type="button"><i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </div>                        
                        <div class="row">
                            <div class="form-group required col-sm-6">
                                <label>Logradouro</label>
                                {{ Form::text('e_logradouro', isset($cliente) ? $cliente->logradouro : Input::old('e_logradouro'), ['class' => 'pedido-logradouro form-control logradouro', 'required']) }}
                            </div>
                            <div class="form-group required col-sm-6">
                                <label>Numero</label>
                                {{ Form::text('e_numero', isset($cliente) ? $cliente->numero : Input::old('e_numero'), ['class' => 'pedido-numero form-control', 'required']) }}
                            </div>
                            <div class="form-group required col-sm-6">
                                <label>Bairro</label>
                                {{ Form::text('e_bairro', isset($cliente) ? $cliente->bairro : Input::old('e_bairro'), ['class' => 'pedido-bairro form-control bairro', 'required']) }}
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Complemento</label>
                                {{ Form::text('e_complemento', isset($cliente, $cliente->complemento) ? $cliente->complemento : Input::old('e_complemento'), ['class' => 'pedido-complemento form-control']) }}
                            </div>
                            <div class="form-group required col-sm-6">
                                <label>Cidade</label>
                                {{ Form::text('e_cidade', isset($cliente) ? $cliente->cidade : Input::old('e_cidade'), ['class' => 'pedido-cidade form-control cidade', 'required']) }}
                            </div>
                            <div class="form-group required col-sm-6">
                                <label>Estado</label>
                                {{ Form::text('e_estado', isset($cliente) ? $cliente->estado : Input::old('e_estado'), ['class' => 'pedido-estado form-control estado', 'required']) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="badge">2</span> Adicionar produtos
            </div>
            <div class="panel-body">
                <table class="produtos-pedido table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Ref.</th>
                            <th>Produto</th>
                            <th>Preço</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($pedido))
                            @foreach($pedido->produtos as $k => $v)
                                <tr data-id="{{$v->pivot->id_produto}}">
                                    <input type="hidden" name="produto[{{$k}}][id]" value="{{$v->pivot->id_produto}}">
                                    <input type="hidden" class="preco-hidden" name="produto[{{$k}}][preco]" value="{{$v->pivot->preco}}">
                                    <td>{{$v->referencia}}</td>
                                    <td class="td-prod">
                                        {{$v->nome}}
                                        @if(!is_null($v->pivot->opcionais))
                                            @foreach(json_decode($v->pivot->opcionais) as $key => $value)
                                                <label class="label label-success" data-preco="{{$value->preco}}">
                                                    c/ {{$value->name}}
                                                    <input type="hidden" name="produto[{{$k}}][opcionais][{{$key}}][id]" value="{{$value->id}}">
                                                    <input type="hidden" name="produto[{{$k}}][opcionais][{{$key}}][name]" value="{{$value->name}}">
                                                    <input type="hidden" name="produto[{{$k}}][opcionais][{{$key}}][preco]" value="{{$value->preco}}">
                                                    <input type="hidden" name="produto[{{$k}}][opcionais][{{$key}}][quantidade]" value="{{$value->quantidade}}">
                                                    <i class="fa fa-close"></i>
                                                </label>
                                            @endforeach
                                        @endif
                                        @if(!is_null($v->pivot->composto))
                                            @foreach(json_decode($v->pivot->composto) as $key => $value)
                                                <label class="label label-primary" data-preco="{{$value->preco}}">
                                                    meia {{$value->name}}
                                                    <input type="hidden" name="produto[{{$k}}][composto][{{$key}}][id]" value="{{$value->id}}">
                                                    <input type="hidden" name="produto[{{$k}}][composto][{{$key}}][name]" value="{{$value->name}}">
                                                    <input type="hidden" name="produto[{{$k}}][composto][{{$key}}][preco]" value="{{$value->preco}}">
                                                    <i class="fa fa-close"></i>
                                                </label>
                                            @endforeach
                                        @endif
                                        @if(!is_null($v->pivot->removidos))
                                            @foreach(json_decode($v->pivot->removidos) as $key => $value)
                                                <label class="label label-danger">
                                                    s/ {{$value->name}}
                                                    <input type="hidden" name="produto[{{$k}}][removidos][{{$key}}][id]" value="{{$value->id}}">
                                                    <input type="hidden" name="produto[{{$k}}][removidos][{{$key}}][name]" value="{{$value->name}}">
                                                    <input type="hidden" name="produto[{{$k}}][removidos][{{$key}}][quantidade]" value="{{$value->quantidade}}">
                                                    <i class="fa fa-close"></i>
                                                </label>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td class="td-preco">{{Helpers::toMoney($v->pivot->preco)}}</td>
                                    <td>
                                        <a href="javascript:void(0)" data-id="{{$v->pivot->id_produto}}" class="prod-ped-half btn btn-default" title="Fracionar item">
                                            <i class="fa fa-pie-chart"></i>
                                        </a>
                                        <a href="javascript:void(0)" data-id="{{$v->pivot->id_produto}}" class="prod-ped-plus btn btn-default" title="Adicionar itens">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                        <a href="javascript:void(0)" data-id="{{$v->pivot->id_produto}}" class="prod-ped-minus btn btn-default" title="Remover itens">
                                            <i class="fa fa-minus"></i>
                                        </a>
                                        <a href="javascript:void(0)" class="prod-ped-remove btn btn-danger" data-preco="{{$v->pivot->preco}}">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="text-right">
                    <a class="add-produto btn btn-success" href="javascript:void(0)">
                        <i class="fa fa-plus"></i> ADICIONAR
                    </a>
                </div>
            </div>
        </div>
        <div class="produto-modal modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Produtos</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="produto-info form-group">
                                    <table class="table-list table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Ref.</th>
                                                <th>Produto</th>
                                                <th>Preço</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>                                            
                                            @foreach($produtos as $k => $v)                                                                                                                       
                                            <tr>
                                                <td class="produto-info-ref">{{$v->referencia}}</td>
                                                <td class="produto-info-produto">{{$v->nome}}</td>
                                                <td class="produto-info-preco">{{Helpers::toMoney($v->preco_final)}}</td>
                                                <td class="produto-info-acoes text-center">
                                                    <a href="javascript:void(0)" class="produto-add-pedido btn btn-success" data-id="{{$v->id}}">
                                                        <i class="fa fa-plus"></i> Adicionar
                                                    </a>
                                                </td>
                                            </tr>                                                
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="itens-modal modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Composição do produto</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="estoque-info form-group">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Itens</th>
                                                <th>Quantidade</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>                                            

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="produto-half-modal modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Produtos</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="produto-half-info form-group">
                                    <table class="table-list table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Ref.</th>
                                                <th>Produto</th>
                                                <th>Preço</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>                                            
                                            @foreach($produtos as $k => $v)                                                                                                                       
                                            <tr>
                                                <td class="produto-half-ref">{{$v->referencia}}</td>
                                                <td class="produto-half-produto">{{$v->nome}}</td>
                                                <td class="produto-half-preco">{{$v->preco_final}}</td>
                                                <td class="produto-half-acoes text-center">
                                                    <a href="javascript:void(0)" class="produto-add-half btn btn-success" data-id="{{$v->id}}">
                                                        <i class="fa fa-plus"></i> Adicionar
                                                    </a>
                                                </td>
                                            </tr>                                                
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="estoque-ped-modal modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Itens adicionais</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="estoque-ped-info form-group">
                                    <table class="table-list table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Itens</th>
                                                <th>Quantidade</th>
                                                <th>Preço</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($estoque as $x => $y)
                                            <tr>
                                                <td class="td-estoque">{{$y->item}}</td>
                                                <td><span class="label {{$y->quantidade <= $y->minimo ? 'label-danger' : 'label-success'}}">{{$y->quantidade}} {{$y->unidade->nome}}</span></td>
                                                <td class="td-estoque-preco">{{number_format($y->preco, 2)}}</td>
                                                <td>
                                                    <div class="opcionais_input form-group col-sm-8">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">{{$y->unidade->nome}}</span>
                                                            {{Form::text('opcionais_input', null, ['class' => 'form-control'])}}
                                                        </div>
                                                    </div>
                                                    <a href="javascript:void(0)" class="item-add btn btn-success" data-id="{{$y->id}}">
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="badge">3</span> Finalização do pedido
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="form-group col-sm-4">
                                <div class="form-group">
                                    <label>Aberto por</label>
                                    {{Form::text('usuario', Auth::user()->nome, ['class' => 'form-control', 'readonly'])}}
                                    {{Form::hidden('id_usuario', Auth::user()->id, ['class' => 'form-control', 'readonly'])}}
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <div class="form-group">
                                    <label>Criado em</label>
                                    {{Form::text('created_at', isset($pedido) ? $pedido->created_at->timezone('America/Sao_Paulo')->format('d/m/Y H:i') : null, ['class' => 'form-control', 'readonly'])}}
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <div class="form-group">
                                    <label>Modificado em</label>
                                    {{Form::text('updated_at', isset($pedido) ? $pedido->updated_at->timezone('America/Sao_Paulo')->format('d/m/Y H:i') : null, ['class' => 'form-control', 'readonly'])}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="form-group col-sm-4">
                                <div class="form-group">
                                    <label>Fiado?</label>
                                    {{Form::select('fiado', ['0' => 'Não', '1' => 'Sim'], Input::old('fiado'), ['class' => 'form-control'])}}
                                </div>
                            </div>
                            <div class="form-group required col-sm-8">
                                <label>Subtotal</label>
                                <div class="input-group">
                                    <span class="input-group-addon">R$</span>
                                    {{Form::text('valor', Input::old('valor'), ['readonly' => 'readonly', 'class' => 'preco_total valor form-control', 'required'])}}
                                </div>
                            </div>
                            <div class="taxa-group form-group col-sm-8 col-sm-offset-4">
                                <label>Taxa de entrega</label>
                                <div class="input-group">
                                    <span class="input-group-addon">R$</span>
                                    {{Form::text('taxa_entrega', Input::old('taxa_entrega'), ['class' => 'taxa_entrega money form-control'])}}
                                </div>
                            </div>
                            <div class="form-group required col-sm-8 col-sm-offset-4">
                                <label>Total</label>
                                <div class="input-group">
                                    <span class="input-group-addon">R$</span>
                                    {{Form::text('valor_total', Input::old('valor_total'), ['class' => 'preco_final money form-control', 'required'])}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    @if(isset($pedido))
                        <a href="javascript:void(0)" class="delete-pedido pull-left btn btn-danger">
                            <i class="fa fa-trash-o"></i> CANCELAR PEDIDO
                        </a>
                        @if(isset($pedido) && $pedido->status)
                            <a href="javascript:void(0)" class="finish btn btn-success">
                                <i class="fa fa-save"></i> FINALIZAR PEDIDO
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-save"></i> SALVAR ALTERAÇÕES
                            </button>
                        @endif
                    @else
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-save"></i> ABRIR PEDIDO
                        </button>
                    @endif                    
                </div>                
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
@if(isset($pedido))
<div class="delete-pedido-modal modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Alerta</h4>
            </div>
            <div class="modal-body">
                <p>Deseja realmente cancelar este pedido?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">FECHAR</button>                
                <div class="pull-right">
                    {{ Form::open(['route' => ['admin.pedidos.destroy', $pedido->id], 'method' => 'DELETE']) }}
                    <button type="submit" class="delete-pedido btn btn-danger">
                        <i class="fa fa-trash-o"></i> DELETAR
                    </button>
                    {{Form::close()}}
                </div>                
            </div>
        </div>
    </div>
</div>
<div class="finish-modal modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(['route' => ['admin.pedidos.finish', $pedido->id], 'method' => 'PUT']) }}
                <div class="modal-header">
                    <h4 class="modal-title">Finalizar pedido</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <strong class="finish-price">Valor total: R$ <span>{{$pedido->valor_total}}</span></strong>
                        </div>
                        {{Form::hidden('valor_finish', $pedido->valor_total, ['class' => 'valor-finish'])}}
                        <div class="form-group col-sm-6">
                            <label>Valor recebido</label>
                            <div class="input-group">
                                <span class="input-group-addon">R$</span>
                                {{Form::text('valor_recebido', Input::old('valor_recebido'), ['class' => 'valor_recebido money form-control'])}}
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Troco</label>
                            <div class="input-group">
                                <span class="input-group-addon">R$</span>
                                {{Form::text('troco', Input::old('troco'), ['class' => 'troco form-control'])}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">FECHAR</button>                
                    <div class="pull-right">                    
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-trash-o"></i> FINALIZAR
                        </button>                    
                    </div>                
                </div>
            {{Form::close()}}
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