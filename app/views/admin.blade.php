@extends('template.template')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Painel Admin</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-shopping-cart fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{$pedidos}}</div>
                        <div>Pedidos finalizados</div>
                    </div>
                </div>
            </div>
            <a href="{{URL::route('admin.pedidos.index')}}">
                <div class="panel-footer">
                    <span class="pull-left">Visualizar pedidos</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-cutlery fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{$produtos}}</div>
                        <div>Produtos ativos</div>
                    </div>
                </div>
            </div>
            <a href="{{URL::route('admin.produtos.index')}}">
                <div class="panel-footer">
                    <span class="pull-left">Visualizar produtos</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-users fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{$clientes}}</div>
                        <div>Clientes ativos</div>
                    </div>
                </div>
            </div>
            <a href="{{URL::route('admin.clientes.index')}}">
                <div class="panel-footer">
                    <span class="pull-left">Visualizar clientes</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-money fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{$contas}}</div>
                        <div>Contas a pagar</div>
                    </div>
                </div>
            </div>
            <a href="{{URL::route('admin.contas.index')}}">
                <div class="panel-footer">
                    <span class="pull-left">Visualizar contas</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-area-chart fa-fw"></i> Dados diário
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="list-group">
                    <a href="javascript:void(0)" class="list-group-item">
                        <i class="fa fa-money fa-fw"></i> Vendas
                        <span class="pull-right">
                            R$ {{Helpers::toMoney($dailySales[0]->priceTotal)}}
                        </span>
                    </a>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
</div>
@stop