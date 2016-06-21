@extends('template.template')
@section('styles')
{{ HTML::style('css/dataTables.bootstrap.css') }}
{{ HTML::style('css/dataTables.responsive.css') }}
@stop
@section('content')
{{ Breadcrumbs::render('estoque') }}
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Estoque</h1>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="actions">
            <a href="{{URL::route('admin.estoque.create')}}" class="btn btn-success"><i class="fa fa-plus"></i> Adicionar estoque</a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        @include('partials.messages')
        <div class="panel panel-default">
            <div class="panel-heading">
                Listagem de estoques
            </div>
            <div class="panel-body">
                <table class="table-list table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Cod.</th>
                            <th>Item</th>
                            <th>Preço unitário</th>
                            <th>Quantidade</th>
                            <th>Qtd. Mínima</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($estoque as $v)                        
                        <tr>
                            <td>{{ $v->id }}</td>
                            <td><a href="{{URL::route('admin.estoque.edit', [$v->id])}}">{{ $v->item }}</a></td>
                            <td>{{ 'R$ ' . Helpers::toMoney($v->preco) }}</td>
                            <td>{{ $v->quantidade <= $v->minimo ? '<span class="label label-danger">'. $v->quantidade .'</span>' : '<span class="label label-success">'. $v->quantidade .'</span>' }}</td>
                            <td>{{ $v->minimo }}</td>
                            <td>
                                {{ Form::open(['route' => ['admin.estoque.destroy', $v->id], 'method' => 'DELETE', 'class' => 'pull-right delete', 'data-message' => 'Deseja realmente deletar este estoque?']) }}
                                <button class="btn btn-danger" type="submit" title="Deletar estoque">
                                    <i class="fa fa-trash"></i>
                                </button>                        
                                {{ Form::close() }}
                                {{ HTML::decode(link_to_route('admin.estoque.edit', '<i class="fa fa-edit"></i>', [$v->id], ['class' => 'btn btn-default pull-left', 'title' => 'Editar estoque'])) }}
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