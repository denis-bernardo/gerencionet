@extends('template.template')
@section('styles')
{{ HTML::style('css/bootstrap-treeview.css') }}
@stop
@section('content')
{{ Breadcrumbs::render('categorias') }}
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Categorias</h1>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="actions">
            <a href="{{URL::route('admin.categorias.create')}}" class="btn btn-success"><i class="fa fa-plus"></i> Adicionar categoria</a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        @include('partials.messages')
        <div class="panel panel-default">
            <div class="panel-heading">
                Árvore de categorias
            </div>
            <div class="panel-body">
                <div class="category-tree">
                    <ul class="list-group">
                    @foreach ($categorias as $k => $v)
                        @if (is_null($v->parent))
                        <li class="list-group-item">
                            <i class="icon-categories fa fa-plus" onclick="getCategories({{$v->id}}, this)"></i>
                            <a href="/admin/categorias/{{$v->id}}/edit">{{$v->nome}}</a>
                        </li>
                        @endif
                    @endforeach                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@stop       
@section('scripts')
{{ HTML::script('js/vendor/bootstrap-treeview.js') }}  
@stop