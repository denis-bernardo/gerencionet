<?php

class AuthController extends BaseController {

    public function login() {
        
        $rules = array(
            'email' => 'required|email',
            'password' => 'required|alphaNum|min:6' 
        );
        
        $messages = [
            'email.required' => 'O campo <b>email</b> é obrigatório.',
            'email.email' => 'O formato do <b>email</b> é inválido.',
            'password.required' => 'O campo <b>senha</b> é obrigatório.',
            'password.alphaNum' => 'A <b>senha</b> deve conter números e letras',
            'password.min' => 'A <b>senha</b> deve conter no minímo 6 caracteres'
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to('login')
                    ->withErrors($validator)
                    ->withInput(Input::except('password'));
        } else {

            // create our user data for the authentication
            $userdata = array(
                'email' => Input::get('email'),
                'password' => Input::get('password')
            );

            // attempt to do the login
            if (Auth::attempt($userdata)) {
                return Redirect::to('admin');
            } else {
                return Redirect::to('login')->withErrors('Usuário/Senha não encontrados.');
            }
        }
    }
    
    public function logout () {
        Auth::logout();
        return Redirect::to('login');
    }

}
