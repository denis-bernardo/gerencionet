@extends('template.template')
@section('styles')
{{ HTML::style('css/dataTables.bootstrap.css') }}
{{ HTML::style('css/dataTables.responsive.css') }}
@stop
@section('content')
{{ Breadcrumbs::render('produtos') }}
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Produtos</h1>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="actions">
            <a href="{{URL::route('admin.produtos.create')}}" class="btn btn-success"><i class="fa fa-plus"></i> Adicionar produto</a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        @include('partials.messages')
        <div class="panel panel-default">
            <div class="panel-heading">
                Listagem de produtos
            </div>
            <div class="panel-body">
                <table class="table-list table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Ref.</th>
                            <th>Nome</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($produtos as $v)                        
                        <tr>
                            <td>{{ $v->id }}</td>
                            <td><a href="{{URL::route('admin.produtos.edit', [$v->id])}}">{{ $v->nome }}</a></td>
                            <td>{{ $v->status == 1 ? '<span class="label label-success">Ativo</span>' : '<span class="label label-default">Inativo</span>' }}</td>
                            <td>
                                {{ Form::open(['route' => ['admin.produtos.destroy', $v->id], 'method' => 'DELETE', 'class' => 'pull-right delete', 'data-message' => 'Deseja realmente deletar este produto?']) }}
                                <button class="btn btn-danger" type="submit" title="Deletar produto">
                                    <i class="fa fa-trash"></i>
                                </button>                        
                                {{ Form::close() }}
                                {{ HTML::decode(link_to_route('admin.produtos.edit', '<i class="fa fa-edit"></i>', [$v->id], ['class' => 'btn btn-default pull-left', 'title' => 'Editar produto'])) }}
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