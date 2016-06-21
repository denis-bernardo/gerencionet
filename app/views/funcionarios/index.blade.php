@extends('template.template')
@section('styles')
{{ HTML::style('css/dataTables.bootstrap.css') }}
{{ HTML::style('css/dataTables.responsive.css') }}
@stop
@section('content')
{{ Breadcrumbs::render('funcionarios') }}
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Funcionários</h1>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="actions">
            <a href="{{URL::route('admin.funcionarios.create')}}" class="btn btn-success"><i class="fa fa-plus"></i> Adicionar funcionário</a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        @include('partials.messages')
        <div class="panel panel-default">
            <div class="panel-heading">
                Listagem de funcionários
            </div>
            <div class="panel-body">
                <table class="table-list table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Cod.</th>
                            <th>Nome</th>
                            <th>Função</th>
                            <th>Entregador</th>
                            <th>Telefone</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($funcionarios as $v)                        
                        <tr>
                            <td>{{ $v->id }}</td>
                            <td><a href="{{URL::route('admin.funcionarios.edit', [$v->id])}}">{{ $v->nome }}</a></td>
                            <td>{{ $v->funcao }}</td>
                            <td>{{ $v->entregador == 1 ? '<span class="label label-success">Sim</span>' : '<span class="label label-default">Não</span>' }}</td>
                            <td>{{ $v->telefone }}</td>
                            <td>{{ $v->status == 1 ? '<span class="label label-success">Ativo</span>' : '<span class="label label-default">Inativo</span>' }}</td>
                            <td>
                                {{ Form::open(['route' => ['admin.funcionarios.destroy', $v->id], 'method' => 'DELETE', 'class' => 'pull-right delete', 'data-message' => 'Deseja realmente deletar este funcionário?']) }}
                                <button class="btn btn-danger" type="submit" title="Deletar funcionário">
                                    <i class="fa fa-trash"></i>
                                </button>                        
                                {{ Form::close() }}
                                {{ HTML::decode(link_to_route('admin.funcionarios.edit', '<i class="fa fa-edit"></i>', [$v->id], ['class' => 'btn btn-default pull-left', 'title' => 'Editar funcionário'])) }}
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