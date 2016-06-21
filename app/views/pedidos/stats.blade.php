@extends('template.template')
@section('content')
{{  Breadcrumbs::render('pedidos_stats')}}
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Estatísticas de pedidos</h1>
    </div>
    <div class="col-sm-12">
        <div class="filters">
            <div class="form-group">
                <label class="label label-info">Filtrar por:</label>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Data inicial</label>
                        <div class="input-group datepicker">
                            <input class="date-start form-control date" required="required" name="date_start" type="text" autocomplete="off">
                            <span class="input-group-addon">
                                <span class="fa fa-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Data final</label>
                        <div class="input-group datepicker">
                            <input class="date-finish form-control date" required="required" name="date_finish" type="text" autocomplete="off">
                            <span class="input-group-addon">
                                <span class="fa fa-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group form-group-no-label">
                        <a href="{{URL::route('admin.pedidos.index')}}" class="get-charts btn btn-success">FILTRAR</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="charts">
            <label class="hide">Quantidade de pedidos finalizados (mensal)</label>
            <canvas id="chart-orders"></canvas>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="charts">
            <label class="hide">Faturamento mensal (Pedidos finalizados)</label>
            <canvas id="chart-orders-sales"></canvas>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="charts">
            <label class="hide">Pedidos finalizados x Contas pagas (mensal)</label>
            <canvas id="chart-orders-debits"></canvas>
        </div>
    </div>
</div>
@stop
@section('scripts')
{{ HTML::script('js/vendor/bootbox.min.js') }}
{{ HTML::script('js/Chart.min.js') }}
{{ HTML::script('js/charts.js') }}
@stop