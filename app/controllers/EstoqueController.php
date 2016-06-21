<?php

class EstoqueController extends \BaseController {

    protected $validator;
    protected $estoque;
    protected $unidade;

    public function __construct(EstoqueValidator $validator, Estoque $estoque, Unidade $unidade) {
        $this->beforeFilter('csrf', ['on' => 'post', 'put', 'delete']);
        $this->validator = $validator;
        $this->estoque = $estoque;
        $this->unidade = $unidade;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $estoque = $this->estoque->all();
        if(Request::ajax()){
            return $estoque;
        }
        return View::make('estoque.index')->with('estoque', $estoque);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $unidades = $this->unidade->lists('nome', 'id');
        return View::make('estoque.create')->with('unidades', $unidades);
    }
    
    public function show($id) {
        if (Request::ajax()) {
            $estoque = $this->estoque->find($id)->toArray();
            $estoque['valor'] = Helpers::toMoney($estoque['preco']);
            return $estoque;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        try {
            $data = Input::all();
            $this->validator->validate($data);
            $data['preco'] = Helpers::toDecimal($data['preco']);
            $this->estoque->fill($data)->save();
            Session::flash('message', 'Estoque criado com sucesso!');
            return Redirect::route('admin.estoque.edit', [$this->estoque->id]);
        } catch (InvalidArgumentException $e) {
            return Redirect::route('admin.estoque.create')->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $unidades = $this->unidade->lists('nome', 'id');
        $estoque = $this->estoque->find($id);
        $estoque['preco'] = Helpers::toMoney($estoque['preco']);
        return View::make('estoque.create', ['estoque' => $estoque, 'unidades' => $unidades]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        try {
            $data = Input::all();
            $this->validator->validate($data);
            $data['preco'] = Helpers::toDecimal($data['preco']);
            $this->estoque->find($id)->fill($data)->save();
            Session::flash('message', 'Estoque editado com sucesso!');
            return Redirect::route('admin.estoque.edit', [$id]);
        } catch (InvalidArgumentException $e) {
            return Redirect::route('admin.estoque.edit', [$id])->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $this->estoque->find($id)->delete();
        Session::flash('message', 'Estoque deletado com sucesso!');
        return Redirect::route('admin.estoque.index');
    }

}
