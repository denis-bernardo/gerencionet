<?php

class PedidoController extends BaseController {
    
    protected $pedido;
    protected $cliente;
    protected $transform;
    protected $validator;

    public function __construct(Pedido $pedido, Cliente $cliente, PedidoTransform $transform, PedidoValidator $validator)
    {
        $this->pedido = $pedido;
        $this->cliente = $cliente;
        $this->transform = $transform;
        $this->validator = $validator;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $pedidos = $this->pedido->orderBy('id', 'desc');
        $pedidos->where('fiado', '=', Input::get('fiado', 0));
        $pedidos->where('status', '=', Input::get('status', 1));
        if (!is_null(Input::get('entrega')) && Input::get('entrega') == 0) {
            $pedidos->where('entrega', '=', '0');
        }
        return View::make('pedidos.index', ['pedidos' => $pedidos->get()]);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
            $mesas = Mesa::select()->where('status', '=', '1')->lists('nome','id');
            $produtos = Produto::select()->where('status', '=', '1')->get();
            $estoque = Estoque::has('unidade')->get();
            $entregador = Funcionario::select()->where('entregador', '=', '1')->where('status', '=', '1')->lists('nome', 'id');
            return View::make('pedidos.create',
                    ['mesas' => $mesas, 'produtos' => $produtos, 'estoque' => $estoque, 'entregador' => $entregador]);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
            try {
                $data = Input::all();
                $this->validator->validate($data);
                $data['status'] = '1';
                $data['valor'] = Helpers::toDecimal($data['valor']);
                $data['valor_total'] = Helpers::toDecimal($data['valor_total']);
                if (isset($data['taxa_entrega'])) {
                    $data['taxa_entrega'] = Helpers::toDecimal($data['taxa_entrega']);
                }
                $this->pedido->fill($data)->save();
                $pedido = $this->transform->transform($this->pedido->id, $data);
                $this->pedido->produtos()->detach();
                foreach ($pedido as $k => $v) {
                    $this->pedido->produtos()->attach($this->pedido->id, $v);
                }
                Session::flash('message', 'Pedido aberto com sucesso!');
                return Redirect::route('admin.pedidos.edit', [$this->pedido->id]);
            } catch (InvalidArgumentException $e) {
                return Redirect::route('admin.pedidos.create')->withErrors($e->getMessage())->withInput();
            }
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
            $cliente = Cliente::find($id);
            $mesas = Mesa::select()->where('status', '=', '1')->lists('nome','id');
            $produtos = Produto::select()->where('status', '=', '1')->get();
            $estoque = Estoque::all();
            $entregador = Funcionario::select()->where('entregador', '=', '1')->where('status', '=', '1')->lists('nome', 'id');
            return View::make('pedidos.create',
                    [
                        'cliente' => $cliente,
                        'mesas' => $mesas,
                        'produtos' => $produtos,
                        'estoque' => $estoque,
                        'entregador' => $entregador
                    ]
            );
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
            $mesas = Mesa::select()->where('status', '=', '1')->lists('nome','id');
            $produtos = Produto::select()->where('status', '=', '1')->get();
            $estoque = Estoque::has('unidade')->get();
            $entregador = Funcionario::select()->where('entregador', '=', '1')->where('status', '=', '1')->lists('nome', 'id');
            $pedido = $this->pedido->find($id);
            $pedido->valor = Helpers::toMoney($pedido->valor);
            $pedido->valor_total = Helpers::toMoney($pedido->valor_total);
            $pedido->taxa_entrega = Helpers::toMoney($pedido->taxa_entrega);
            $cliente = $this->cliente->find($pedido->id_cliente);
            return View::make('pedidos.create',
                    [
                        'mesas' => $mesas,
                        'produtos' => $produtos,
                        'estoque' => $estoque,
                        'entregador' => $entregador,
                        'pedido' => $pedido,
                        'cliente' => $cliente
                    ]);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
            try {
                $data = Input::all();
                $data['valor'] = Helpers::toDecimal($data['valor']);
                $data['valor_total'] = Helpers::toDecimal($data['valor_total']);
                if (isset($data['taxa_entrega'])) {
                    $data['taxa_entrega'] = Helpers::toDecimal($data['taxa_entrega']);
                }
                $this->validator->validate($data);
                $pedido = $this->pedido->find($id);
                $pedido->fill($data)->save();
                $itens = $this->transform->transform($id, $data);
                $pedido->produtos()->detach();
                foreach ($itens as $k => $v) {
                    $pedido->produtos()->attach($id, $v);
                }
                Session::flash('message', 'Pedido editado com sucesso!');
                return Redirect::route('admin.pedidos.edit', [$id]);
            } catch (InvalidArgumentException $e) {
                return Redirect::route('admin.pedidos.edit', [$id])->withErrors($e->getMessage())->withInput();
            }
        }


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
	    $this->pedido->find($id)->delete();
            Session::flash('message', 'Pedido deletado com sucesso!');
            return Redirect::route('admin.pedidos.index');
	}
        
        
        /**
	 * Finish a order
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function finish($id)
	{
            $data = Input::all();
            $data['status'] = 0;
            $data['valor_recebido'] = Helpers::toDecimal($data['valor_recebido']);
            $data['troco'] = Helpers::toDecimal($data['troco']);
    	    $pedido = $this->pedido->find($id);
            $pedido->fill($data)->save();
            Helpers::updateStock($id);
            Session::flash('message', 'Pedido finalizado com sucesso!');
            return Redirect::route('admin.pedidos.index');
	}

    public function stats()
    {
        if (\Request::ajax()) {
            $dateStart = !is_null(Input::get('date_start')) ? Helpers::dateDb(Input::get('date_start')) : '';
            $dateFinish = !is_null(Input::get('date_finish')) ? Helpers::dateDb(Input::get('date_finish')) : '';
            $orders = DB::table('pedidos')
                ->select(
                    DB::raw('MONTHNAME(created_at) as month'),
                    DB::raw("DATE_FORMAT(created_at,'%Y-%m') as monthNum"),
                    DB::raw('count(*) as pedidos')
                )->where('created_at', '>=', $dateStart)
                    ->where('created_at', '<=', $dateFinish)
                    ->where('status', '=', '0')
                    ->groupBy('monthNum')->get();

            $priceTotal = DB::table('pedidos')
                ->select(
                    DB::raw('MONTHNAME(created_at) as month'),
                    DB::raw("DATE_FORMAT(created_at,'%Y-%m') as monthNum"),
                    DB::raw('sum(valor_total) as priceTotal')
                )->where('created_at', '>=', $dateStart)
                ->where('created_at', '<=', $dateFinish)
                ->where('status', '=', '0')
                ->groupBy('monthNum')->get();

            $debitsTotal = DB::table('contas')
                ->select(
                    DB::raw('MONTHNAME(created_at) as month'),
                    DB::raw("DATE_FORMAT(created_at,'%Y-%m') as monthNum"),
                    DB::raw('sum(valor) as debits')
                )->where('created_at', '>=', $dateStart)
                ->where('created_at', '<=', $dateFinish)
                ->where('paga', '=', '1')
                ->groupBy('monthNum')->get();

            return Response::json(
                [
                    'priceTotal' => $priceTotal,
                    'debits' => $debitsTotal,
                    'orders' => $orders
                ], 200);
        }
        return View::make('pedidos.stats');
    }
}

