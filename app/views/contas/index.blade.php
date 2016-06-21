@extends('template.template')
@section('styles')
{{ HTML::style('css/dataTables.bootstrap.css') }}
{{ HTML::style('css/dataTables.responsive.css') }}
@stop
@section('content')
{{ Breadcrumbs::render('contas') }}
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Contas a pagar</h1>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="actions">
            <a href="{{URL::route('admin.contas.create')}}" class="btn btn-success"><i class="fa fa-plus"></i> Adicionar conta</a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        @include('partials.messages')
        <div class="panel panel-default">
            <div class="panel-heading">
                Listagem de contas
            </div>
            <div class="panel-body">
                <table class="table-list table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Cod.</th>
                            <th>Nome</th>
                            <th>Valor</th>
                            <th>Vencimento</th>
                            <th>Paga</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($contas as $v)                        
                        <tr>
                            <td>{{ $v->id }}</td>
                            <td><a href="{{URL::route('admin.contas.edit', [$v->id])}}">{{ $v->nome }}</a></td>
                            <td>{{ 'R$ ' . Helpers::toMoney($v->valor) }}</td>
                            <td>{{ $v->vencimento->format('d/m/Y') }}</td>
                            <td>{{ $v->paga == 1 ? '<span class="label label-success">Sim</span>' : '<span class="label label-default">Não</span>' }}</td>
                            <td>
                                {{ Form::open(['route' => ['admin.contas.destroy', $v->id], 'method' => 'DELETE', 'class' => 'pull-right delete', 'data-message' => 'Deseja realmente deletar esta conta?']) }}
                                <button class="btn btn-danger" type="submit" title="Deletar conta">
                                    <i class="fa fa-trash"></i>
                                </button>                        
                                {{ Form::close() }}
                                {{ HTML::decode(link_to_route('admin.contas.edit', '<i class="fa fa-edit"></i>', [$v->id], ['class' => 'btn btn-default pull-left', 'title' => 'Editar conta'])) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop       
@section('scripts')
{{ HTML::script('js/vendor/jquery.dataTables.min.js') }}
{{ HTML::script('js/vendor/dataTables.bootstrap.min.js') }}
{{ HTML::script('js/vendor/bootbox.min.js') }}   
@stop