<?php

class CategoriaController extends \BaseController {

    protected $validator;
    protected $categoria;

    public function __construct(CategoriaValidator $validator, Categoria $categoria) {
        $this->beforeFilter('csrf', ['on' => 'post', 'put', 'delete']);
        $this->validator = $validator;
        $this->categoria = $categoria;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $categorias = $this->categoria->all();
        if (Request::ajax())
            return $categorias;
        else
            return View::make('categorias.index')->with('categorias', $categorias);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {        
        $categorias = $this->categoria->select()->whereNull('parent')->lists('nome', 'id');
        return View::make('categorias.create')->with('categorias', $categorias);
    }
    
    public function show($id)
    {
        if (Request::ajax()){
            $categoria = $this->categoria->select()->where('parent', '=', $id)->get();
            return $categoria; 
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
            $data['parent'] = empty($data['parent']) ? null : $data['parent'];
            $this->validator->validate($data);
            $this->categoria->fill($data)->save();
            Session::flash('message', 'Categoria criada com sucesso!');
            return Redirect::route('admin.categorias.edit', [$this->categoria->id]);
        } catch (InvalidArgumentException $e) {
            return Redirect::route('admin.categorias.create')->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $categoria = $this->categoria->find($id);
        $categorias = $this->categoria->select()->whereNull('parent')->lists('nome', 'id');
        return View::make('categorias.create', ['categoria' => $categoria, 'categorias' => $categorias]);
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
            $data['parent'] = empty($data['parent']) ? null : $data['parent'];
            $this->validator->validate($data);
            $this->categoria->find($id)->fill($data)->save();
            Session::flash('message', 'Categoria editada com sucesso!');
            return Redirect::route('admin.categorias.edit', [$id]);
        } catch (InvalidArgumentException $e) {
            return Redirect::route('admin.categorias.edit', [$id])->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $filhas = $this->categoria->where('parent', '=', $id)->get();
        if (!empty($filhas)) {
            foreach ($filhas->lists('id') as $v) {
                $this->categoria->find($v)->delete();
            }            
        }
        $this->categoria->find($id)->delete();
        Session::flash('message', 'Categoria deletada com sucesso!');
        return Redirect::route('admin.categorias.index');
    }

}
