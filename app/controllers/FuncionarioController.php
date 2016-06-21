<?php

class FuncionarioController extends \BaseController {

    protected $validator;
    protected $funcionario;

    public function __construct(FuncionarioValidator $validator, Funcionario $funcionario) {
        $this->beforeFilter('csrf', ['on' => 'post', 'put', 'delete']);
        $this->validator = $validator;
        $this->funcionario = $funcionario;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $funcionarios = $this->funcionario->all();
        return View::make('funcionarios.index')->with('funcionarios', $funcionarios);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return View::make('funcionarios.create');
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
            $data['salario'] = Helpers::toDecimal($data['salario']);
            $data['data_nascimento'] = Helpers::dateDb($data['data_nascimento']);
            $this->funcionario->fill($data)->save();
            Session::flash('message', 'Funcionário criado com sucesso!');
            return Redirect::route('admin.funcionarios.edit', [$this->funcionario->id]);
        } catch (InvalidArgumentException $e) {
            return Redirect::route('admin.funcionarios.create')->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $funcionario = $this->funcionario->find($id);
        $funcionario['salario'] = Helpers::toMoney($funcionario['salario']);
        return View::make('funcionarios.create', ['funcionario' => $funcionario]);
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
            $data['salario'] = Helpers::toDecimal($data['salario']);
            $data['data_nascimento'] = Helpers::dateDb($data['data_nascimento']);
            $this->funcionario->find($id)->fill($data)->save();
            Session::flash('message', 'Funcionário editado com sucesso!');
            return Redirect::route('admin.funcionarios.edit', [$id]);
        } catch (InvalidArgumentException $e) {
            return Redirect::route('admin.funcionarios.edit', [$id])->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $this->funcionario->find($id)->delete();
        Session::flash('message', 'Funcionário deletado com sucesso!');
        return Redirect::route('admin.funcionarios.index');
    }

}
