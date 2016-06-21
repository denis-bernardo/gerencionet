@extends('template.template')
@section('content')
{{ Breadcrumbs::render('clientes_create') }}
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">{{$cliente->nome}} - Pedidos</h1>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="actions">
            <a href="{{URL::route('admin.pedidos.show', $cliente->id)}}" class="btn btn-success"><i class="fa fa-plus"></i> Adicionar pedido</a>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="filters">
            <div class="form-group">
                <label class="label label-info">Filtrar por:</label>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Fiado</label>
                        <select class="form-control filter-by" data-key="fiado">
                            <option value="0" {{Input::get('fiado') == 0 || is_null(Input::get('fiado')) ? 'selected' : ''}}>Não</option>
                            <option value="1" {{Input::get('fiado') == 1 ? 'selected' : ''}}>Sim</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        @include('partials.messages')
    </div>
    @if(count($pedidos) > 0)
    @foreach($pedidos as $k => $v)
    <div class="col-sm-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <b>#{{$v['id']}} - Pedido</b>
                @if($v['status'] != 0)
                    <label class="label label-info pull-right">Aberto</label>
                @endif
                @if($v['entrega'] != 0)
                    <label class="label label-primary pull-right">Entrega</label>
                @endif
                @if($v['fiado'] != 0)
                    <label class="label label-warning pull-right">Fiado</label>
                @endif
            </div>
            <div class="panel-body">
                <ul class="list-group">
                    <li class="list-group-item">
                        <i class="fa fa-clock-o"></i> Aberto às: {{$v->created_at->timezone('America/Sao_Paulo')->format('d/m/Y H:i')}}
                    </li>
                    @if($v['id_mesa'] != 0)
                    <li class="list-group-item">
                        <i class="fa fa-ticket"></i> {{$v->mesa->nome}}
                    </li>
                    @endif
                    @if($v['id_cliente'] != 0)
                    <li class="list-group-item">
                        <i class="fa fa-user"></i> Cliente: {{$v->cliente->nome}}
                    </li>
                    @endif
                    <li class="list-group-item">
                        <i class="fa fa-money"></i> Valor: R$ {{Helpers::toMoney($v->valor_total)}}
                    </li>
                </ul>
            </div>
            <div class="panel-footer text-right">
                {{Form::open(['route' => ['admin.pedidos.destroy', $v->id], 'method' => 'DELETE', 'class' => 'pull-left delete', 'data-message' => 'Deseja realmente cancelar este pedido?'])}}
                <button class="btn btn-danger" type="submit" title="Cancelar pedido">
                    <i class="fa fa-trash"></i>
                </button>
                {{Form::close()}}
                <a class="btn btn-default" href="{{URL::route('admin.pedidos.edit', [$v->id])}}">
                    <i class="fa fa-edit"></i> Visualizar
                </a>
                @if ($v->status)
                    <a class="finish-btn btn btn-default btn-success" href="javascript:void(0)" data-preco="{{$v->valor_total}}" data-pedido="{{$v->id}}">
                        <i class="fa fa-check"></i> Finalizar
                    </a>
                @endif
            </div>
        </div>
    </div>
    @endforeach
    @else
    <div class="col-sm-12">
        <h2 class="text-info">Ainda não há pedidos em aberto.</h2>
    </div>
    @endif
</div>
<div class="finish-modal-order modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(['url' => '', 'method' => 'PUT', 'class' => 'finish-form']) }}
                <div class="modal-header">
                    <h4 class="modal-title">Finalizar pedido</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <strong class="finish-price">Valor total: R$ <span>1</span></strong>
                        </div>
                        {{Form::hidden('valor_finish', null, ['class' => 'valor-finish'])}}
                        <div class="form-group col-sm-6">
                            <label>Valor recebido</label>
                            <div class="input-group">
                                <span class="input-group-addon">R$</span>
                                {{Form::text('valor_recebido', null, ['class' => 'valor_recebido_order form-control'])}}
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Troco</label>
                            <div class="input-group">
                                <span class="input-group-addon">R$</span>
                                {{Form::text('troco', null, ['class' => 'troco_order form-control'])}}
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
@stop
@section('scripts')
{{ HTML::script('js/vendor/bootbox.min.js') }}
@stop