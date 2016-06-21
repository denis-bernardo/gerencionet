<?php

class AdminController extends BaseController
{
    public function index()
    {
        $clientes = Cliente::select()->where('status', '=', '1')->count();
        $pedidos = Pedido::select()->where('status', '=', '0')->count();
        $contas = Conta::select()->where('paga', '=', '0')->count();
        $produtos = Produto::select()->where('status', '=', '1')->count();
        $today = \Carbon\Carbon::today()->toDateTimeString();
        $dailySales = DB::table('pedidos')->select(
            DB::raw('SUM(valor_total) as priceTotal')
        )->whereDate('created_at', '=', $today)->get();
        return View::make(
            'admin',
            [
                'produtos' => $produtos,
                'clientes' => $clientes,
                'contas' => $contas,
                'pedidos' => $pedidos,
                'dailySales' => $dailySales
            ]
        );
    }
}