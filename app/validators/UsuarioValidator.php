<?php

class UsuarioValidator
{
    public function validate($data, $id = null)
    {
        $rules = [
            'nome' => 'required',
            'email' => 'required|email|unique:usuarios,email' . ($id ? ",$id" : ''),
            'password' => 'min:6|same:confirm'
        ];
        
        $messages = [
            'nome.required' => 'O campo <b>nome</b> é obrigatório.',
            'email.required' => 'O campo <b>email</b> é obrigatório.',
            'email.email' => 'O formato do <b>email</b> é inválido.',
            'email.unique' => '<b>Email</b> já cadastrado',
            'password.min' => 'A <b>senha</b> deve conter no minímo 6 digitos.',
            'password.same' => '<b>Senhas</b> não conferem'
        ];
        
        $validator = Validator::make($data, $rules, $messages);
        
        if ($validator->fails()) {
            $errors = implode('<br>', array_values($validator->messages()->all()));
            throw new InvalidArgumentException($errors);
        }
        
        return true;
    }
}