<?php

class ClienteController extends \BaseController {
    
    protected $validator;
    protected $cliente;
    
    public function __construct(ClienteValidator $validator, Cliente $cliente)
    {
        $this->beforeFilter('csrf', ['on' => 'put', 'delete']);
        $this->validator = $validator;
        $this->cliente = $cliente;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $clientes = $this->cliente->all();
        return View::make('clientes.index')->with('clientes', $clientes);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('clientes.create');
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
            $data['data_nascimento'] = Helpers::dateDb($data['data_nascimento']);
            $this->cliente->fill($data)->save();
            Session::flash('message', 'Cliente criado com sucesso!');
            return Redirect::route('admin.clientes.edit', [$this->cliente->id]);
        } catch (InvalidArgumentException $e) {
            return Redirect::route('admin.clientes.create')->withErrors($e->getMessage())->withInput();
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
        $cliente = $this->cliente->find($id);
        return View::make('clientes.create', ['cliente' => $cliente]);
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
            $this->validator->validate($data, $id);
            $data['data_nascimento'] = Helpers::dateDb($data['data_nascimento']);
            $this->cliente->find($id)->fill($data)->save();
            Session::flash('message', 'Cliente editado com sucesso!');
            return Redirect::route('admin.clientes.edit', [$id]);
        } catch (InvalidArgumentException $e) {
            return Redirect::route('admin.clientes.edit', [$id])->withErrors($e->getMessage())->withInput();
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
        $this->cliente->find($id)->delete();
        Session::flash('message', 'Cliente deletado com sucesso!');
        return Redirect::route('admin.clientes.index');
    }

    /**
     * Send an email promotional
     *
     * @param  int  $id
     * @return Response
     */
    public function birthdate($id)
    {
        Mail::send('emails.birthdate', array(''), function($message) use ($id)
        {
            $message->to($this->cliente->find($id)->email, 'Gerencionet')->subject('Feliz Aniversário - Gerencionet');
        });

        if (count(Mail::failures()) > 0) {
            return Response::json('Houve um erro ao enviar o email, tente novamente mais tarde!', 400);
        } else {
            /* 32 days */
            if (Cookie::has('birthdates')) {
                $birthdates = array_merge(Cookie::get('birthdates')['users'], [$id]);
            } else {
                $birthdates = ['users' => [$id]];
            }
            $cookieBirthdate = Cookie::make('birthdates', $birthdates, 46080);
            $response = Response::json('Email enviado com sucesso!', 200);
            $response->headers->setCookie($cookieBirthdate);
            return $response;
        }
    }

    public function pedidos($idCustomer)
    {
        if (Input::get('fiado')) {
            $pedidos = Pedido::where('id_cliente', '=', $idCustomer)->where('fiado', '=', '1')->get();
        } else {
            $pedidos = Pedido::where('id_cliente', '=', $idCustomer)->get();
        }
        $cliente = Cliente::find($idCustomer);
        return View::make('clientes.pedidos', ['pedidos' => $pedidos, 'cliente' => $cliente]);
    }

}
