<?php

class ContaController extends \BaseController {

    protected $validator;
    protected $conta;

    public function __construct(ContaValidator $validator, Conta $conta) {
        $this->beforeFilter('csrf', ['on' => 'post', 'put', 'delete']);
        $this->validator = $validator;
        $this->conta = $conta;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $contas = $this->conta->all();
        return View::make('contas.index')->with('contas', $contas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return View::make('contas.create');
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
            $data['valor'] = Helpers::toDecimal($data['valor']);
            $data['vencimento'] = Helpers::dateDb($data['vencimento']);
            $this->conta->fill($data)->save();
            Session::flash('message', 'Conta criada com sucesso!');
            return Redirect::route('admin.contas.edit', [$this->conta->id]);
        } catch (InvalidArgumentException $e) {
            return Redirect::route('admin.contas.create')->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $conta = $this->conta->find($id);
        $conta['valor'] = Helpers::toMoney($conta['valor']);
        return View::make('contas.create', ['conta' => $conta]);
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
            $data['valor'] = Helpers::toDecimal($data['valor']);
            $data['vencimento'] = Helpers::dateDb($data['vencimento']);
            $this->conta->find($id)->fill($data)->save();
            Session::flash('message', 'Conta editada com sucesso!');
            return Redirect::route('admin.contas.edit', [$id]);
        } catch (InvalidArgumentException $e) {
            return Redirect::route('admin.contas.edit', [$id])->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $this->conta->find($id)->delete();
        Session::flash('message', 'Conta deletada com sucesso!');
        return Redirect::route('admin.contas.index');
    }

}
