<?php

Breadcrumbs::register('admin', function($breadcrumbs) {
    $breadcrumbs->push('Admin', route('admin.index'));
});

Breadcrumbs::register('clientes', function($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Clientes', route('admin.clientes.index'));
});

Breadcrumbs::register('clientes_create', function($breadcrumbs) {
    $breadcrumbs->parent('clientes');
    $breadcrumbs->push('Adicionar/editar', route('admin.clientes.create'));
});

Breadcrumbs::register('funcionarios', function($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Funcionários', route('admin.funcionarios.index'));
});

Breadcrumbs::register('funcionarios_create', function($breadcrumbs) {
    $breadcrumbs->parent('funcionarios');
    $breadcrumbs->push('Adicionar/editar', route('admin.funcionarios.create'));
});

Breadcrumbs::register('mesas', function($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Mesas', route('admin.mesas.index'));
});

Breadcrumbs::register('mesas_create', function($breadcrumbs) {
    $breadcrumbs->parent('mesas');
    $breadcrumbs->push('Adicionar/editar', route('admin.mesas.create'));
});

Breadcrumbs::register('contas', function($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Contas a pagar', route('admin.contas.index'));
});

Breadcrumbs::register('contas_create', function($breadcrumbs) {
    $breadcrumbs->parent('contas');
    $breadcrumbs->push('Adicionar/editar', route('admin.contas.create'));
});

Breadcrumbs::register('unidades', function($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Unidades', route('admin.unidades.index'));
});

Breadcrumbs::register('unidades_create', function($breadcrumbs) {
    $breadcrumbs->parent('unidades');
    $breadcrumbs->push('Adicionar/editar', route('admin.unidades.create'));
});

Breadcrumbs::register('estoque', function($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Estoque', route('admin.estoque.index'));
});

Breadcrumbs::register('estoque_create', function($breadcrumbs) {
    $breadcrumbs->parent('estoque');
    $breadcrumbs->push('Adicionar/editar', route('admin.estoque.create'));
});

Breadcrumbs::register('categorias', function($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Categorias', route('admin.categorias.index'));
});

Breadcrumbs::register('categorias_create', function($breadcrumbs) {
    $breadcrumbs->parent('categorias');
    $breadcrumbs->push('Adicionar/editar', route('admin.categorias.create'));
});

Breadcrumbs::register('usuarios', function($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Usuários', route('admin.usuarios.index'));
});

Breadcrumbs::register('usuarios_create', function($breadcrumbs) {
    $breadcrumbs->parent('usuarios');
    $breadcrumbs->push('Adicionar/editar', route('admin.usuarios.create'));
});

Breadcrumbs::register('produtos', function($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Produtos', route('admin.produtos.index'));
});

Breadcrumbs::register('produtos_create', function($breadcrumbs) {
    $breadcrumbs->parent('produtos');
    $breadcrumbs->push('Adicionar/editar', route('admin.produtos.create'));
});

Breadcrumbs::register('pedidos', function($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Pedidos', route('admin.pedidos.index'));
});

Breadcrumbs::register('pedidos_create', function($breadcrumbs) {
    $breadcrumbs->parent('pedidos');
    $breadcrumbs->push('Adicionar/editar', route('admin.pedidos.create'));
});

Breadcrumbs::register('pedidos_stats', function($breadcrumbs) {
    $breadcrumbs->parent('pedidos');
    $breadcrumbs->push('Estatísticas', '#');
});

Breadcrumbs::register('config', function($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Configurações', route('admin.config.index'));
});