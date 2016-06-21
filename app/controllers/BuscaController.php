<?php

class BuscaController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function store()
	{
        $telefone = Input::get('telefone');
        $clientes = DB::table('clientes')->select()->where('telefone','=',$telefone)->where('status','=','1')->whereNull('deleted_at')->get();
        if(Request::ajax()){
            return $clientes;
        }
        return View::make('busca.index')->with('clientes',$clientes);
	}
}
