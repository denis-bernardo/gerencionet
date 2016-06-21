<?php

class MesaController extends \BaseController {

    protected $validator;
    protected $mesa;

    public function __construct(MesaValidator $validator, Mesa $mesa) {
        $this->beforeFilter('csrf', ['on' => 'post', 'put', 'delete']);
        $this->validator = $validator;
        $this->mesa = $mesa;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $mesas = $this->mesa->all();
        return View::make('mesas.index')->with('mesas', $mesas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return View::make('mesas.create');
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
            $this->mesa->fill($data)->save();
            Session::flash('message', 'Mesa criada com sucesso!');
            return Redirect::route('admin.mesas.edit', [$this->mesa->id]);
        } catch (InvalidArgumentException $e) {
            return Redirect::route('admin.mesas.create')->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $mesa = $this->mesa->find($id);
        return View::make('mesas.create', ['mesa' => $mesa]);
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
            $this->mesa->find($id)->fill($data)->save();
            Session::flash('message', 'Mesa editada com sucesso!');
            return Redirect::route('admin.mesas.edit', [$id]);
        } catch (InvalidArgumentException $e) {
            return Redirect::route('admin.mesas.edit', [$id])->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $this->mesa->find($id)->delete();
        Session::flash('message', 'Mesa deletada com sucesso!');
        return Redirect::route('admin.mesas.index');
    }

}
