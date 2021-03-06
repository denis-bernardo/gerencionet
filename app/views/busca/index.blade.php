@extends('template.template')
@section('styles')
{{ HTML::style('css/dataTables.bootstrap.css') }}
{{ HTML::style('css/dataTables.responsive.css') }}
@stop
@section('content')
{{ Breadcrumbs::render('clientes') }}
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Busca</h1>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="actions">
            <a href="{{URL::route('admin.clientes.create')}}" class="btn btn-success"><i class="fa fa-plus"></i> Adicionar cliente</a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        @include('partials.messages')
        <div class="panel panel-default">
            <div class="panel-heading">
                Listagem de clientes
            </div>
            <div class="panel-body">
                <table class="table-list table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Cod.</th>
                            <th>Nome</th>
                            <th>Telefone</th>
                            <th>Email</th>
                            <th>Bairro</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($clientes as $v)                        
                        <tr>
                            <td>{{ $v->id }}</td>
                            <td><a href="{{URL::route('admin.clientes.edit', [$v->id])}}">{{ $v->nome }}</a></td>
                            <td>{{ $v->telefone }}</td>
                            <td>{{ $v->email }}</td>
                            <td>{{ $v->bairro }}</td>
                            <td>{{ $v->status == 1 ? '<span class="label label-success">Ativo</span>' : '<span class="label label-default">Inativo</span>' }}</td>
                            <td>
                                {{ HTML::decode(link_to_route('admin.clientes.edit', '<i class="fa fa-edit"></i>', [$v->id], ['class' => 'btn btn-default pull-left', 'title' => 'Editar cliente'])) }}
                                {{ HTML::decode(link_to_route('admin.pedidos.show', '<i class="fa fa-shopping-cart"></i>', [$v->id], ['class' => 'btn-pedido btn btn-default pull-left', 'title' => 'Abrir pedido'])) }}
                                {{ HTML::decode(link_to_route('admin.clientes.pedidos', '<i class="fa fa-list"></i>', [$v->id], ['class' => 'btn-pedido btn btn-default pull-left', 'title' => 'Últimos pedidos']))}}
                                {{ Form::open(['route' => ['admin.clientes.destroy', $v->id], 'method' => 'DELETE', 'class' => 'pull-left delete', 'data-message' => 'Deseja realmente deletar este cliente?']) }}
                                    <button class="btn btn-danger" type="submit" title="Deletar cliente">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                {{ Form::close() }}
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