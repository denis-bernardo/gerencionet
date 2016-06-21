<?php

class ProdutoController extends \BaseController {

    protected $produto;
    protected $validator;
    protected $categoria;
    protected $estoque;
    
    public function __construct(ProdutoValidator $validator, Produto $produto, Categoria $categoria, Estoque $estoque)
    {
        $this->produto = $produto;
        $this->validator = $validator;
        $this->categoria = $categoria;
        $this->estoque = $estoque;
    }
    
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
            $produtos = $this->produto->all();
            return View::make('produtos.index')->with('produtos', $produtos);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
            $categorias = $this->categoria->all();
            $estoque = $this->estoque->all();
            return View::make('produtos.create', ['categorias' => $categorias, 'estoque' => $estoque]);
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
                $data['preco_custo'] = Helpers::toDecimal($data['preco_custo']);
                $data['preco_final'] = Helpers::toDecimal($data['preco_final']);
                $this->validator->validate($data);
                $this->produto->fill($data)->save();
                if(isset($data['id_estoque'])){
                    foreach ($data['id_estoque'] as $k => $v) {
                        $this->produto->estoque()->attach([$k => ['quantidade' => $v['quantidade'], 'valor' => $v['valor'], 'status' => '1']]);
                    }
                }                
                Session::flash('message', 'Produto criado com sucesso!');
                return Redirect::route('admin.produtos.edit', [$this->produto->id]);
            } catch (InvalidArgumentException $e) {
                return Redirect::route('admin.produtos.create')->withErrors($e->getMessage())->withInput();
            }
        }


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
            $categorias = $this->categoria->all();
            $estoque = $this->estoque->all();
            $produto = $this->produto->find($id);
            return View::make('produtos.create', ['categorias' => $categorias, 'estoque' => $estoque, 'produto' => $produto]);
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
                $data['preco_custo'] = Helpers::toDecimal($data['preco_custo']);
                $data['preco_final'] = Helpers::toDecimal($data['preco_final']);
                $this->validator->validate($data, $id);
                $produto = $this->produto->find($id);
                $produto->fill($data)->save();
                if(isset($data['id_estoque'])){
                    $produto->estoque()->detach();
                    foreach ($data['id_estoque'] as $k => $v) {
                        $produto->estoque()->attach([$k => ['quantidade' => $v['quantidade'], 'valor' => $v['valor'], 'status' => '1']]);
                    }
                }                
                Session::flash('message', 'Produto editado com sucesso!');
                return Redirect::route('admin.produtos.edit', [$id]);
            } catch (InvalidArgumentException $e) {
                return Redirect::route('admin.produtos.edit', [$id])->withErrors($e->getMessage())->withInput();
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
            $this->produto->find($id)->delete();
            Session::flash('message', 'Produto deletado com sucesso!');
            return Redirect::route('admin.produtos.index');
	}
        
    public function estoque($id)
    {
        $estoque = DB::table('produtos AS p')->select('e.id AS id', 'e.item AS item', 'assoc.quantidade AS quantidade')->where('p.id', '=', $id)
                ->join('produtos_assoc_estoque AS assoc', 'assoc.id_produto', '=', 'p.id')
                ->join('estoque AS e', 'e.id', '=', 'assoc.id_estoque')->get();
        return Helpers::objectToArray($estoque);
    }
}
