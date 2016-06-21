<?php

class UnidadeController extends \BaseController {

    protected $validator;
    protected $unidade;

    public function __construct(UnidadeValidator $validator, Unidade $unidade) {
        $this->beforeFilter('csrf', ['on' => 'post', 'put', 'delete']);
        $this->validator = $validator;
        $this->unidade = $unidade;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $unidades = $this->unidade->all();
        return View::make('unidades.index')->with('unidades', $unidades);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return View::make('unidades.create');
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
            $this->unidade->fill($data)->save();
            Session::flash('message', 'Unidade criada com sucesso!');
            return Redirect::route('admin.unidades.edit', [$this->unidade->id]);
        } catch (InvalidArgumentException $e) {
            return Redirect::route('admin.unidades.create')->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $unidade = $this->unidade->find($id);
        return View::make('unidades.create', ['unidade' => $unidade]);
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
            $this->unidade->find($id)->fill($data)->save();
            Session::flash('message', 'Unidade editada com sucesso!');
            return Redirect::route('admin.unidades.edit', [$id]);
        } catch (InvalidArgumentException $e) {
            return Redirect::route('admin.unidades.edit', [$id])->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $this->unidade->find($id)->delete();
        Session::flash('message', 'Unidade deletada com sucesso!');
        return Redirect::route('admin.unidades.index');
    }

}
