<?php

class UsuarioController extends BaseController {

    protected $validator;
    protected $usuarios;

    public function __construct(UsuarioValidator $validator, User $usuarios) {
        $this->beforeFilter('csrf', ['on' => 'post', 'put', 'delete']);
        $this->validator = $validator;
        $this->usuarios = $usuarios;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $usuarios = $this->usuarios->where('id', '!=', '1')->get();
        return View::make('usuarios.index')->with('usuarios', $usuarios);
    }
    
    public function create()
    {
        return View::make('usuarios.create');
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
            $data['password'] = Hash::make($data['password']);
            $this->usuarios->fill($data)->save();
            Session::flash('message', 'Usuário criado com sucesso!');
            return Redirect::route('admin.usuarios.edit', [$this->usuarios->id]);
        } catch (InvalidArgumentException $e) {
            return Redirect::route('admin.usuarios.create')->withErrors($e->getMessage())->withInput(Input::except('password', 'confirm'));
        }
    }
    
    public function edit($id)
    {
        $usuario = $this->usuarios->find($id);
        return View::make('usuarios.create', ['usuario' => $usuario]);
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
            $this->validator->validate($data, $id);
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }
            $this->usuarios->find($id)->fill($data)->save();
            Session::flash('message', 'Usuário editado com sucesso!');
            return Redirect::route('admin.usuarios.edit', [$id]);
        } catch (InvalidArgumentException $e) {
            return Redirect::route('admin.usuarios.edit', [$id])->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $this->usuarios->find($id)->delete();
        Session::flash('message', 'Usuário deletado com sucesso!');
        return Redirect::route('admin.usuarios.index');
    }

}
