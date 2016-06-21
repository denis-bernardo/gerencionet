<?php

class ClienteValidator
{
    public function validate($data, $id = null)
    {
        $rules = [
            'nome' => 'required',
            'email' => 'email',
            'telefone' => 'required|unique:clientes,telefone' . ($id ? ",$id" : ''),
            'logradouro' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'estado' => 'required'
        ];
        
        $messages = [
            'nome.required' => 'O campo <b>nome</b> é obrigatório.',
            'email.email' => 'Formato do <b>email</b> inválido.',
            'telefone.required' => 'O campo <b>telefone</b> é obrigatório.',
            'telefone.unique' => 'Cliente já cadastrado.',
            'logradouro.required' => 'O campo <b>logradouro</b> é obrigatório.',
            'bairro.required' => 'O campo <b>bairro</b> é obrigatório.',
            'cidade.required' => 'O campo <b>cidade</b> é obrigatório.',
            'estado.required' => 'O campo <b>estado</b> é obrigatório.'
        ];
        
        $validator = Validator::make($data, $rules, $messages);
        
        if ($validator->fails()) {
            $errors = implode('<br>', array_values($validator->messages()->all()));
            throw new InvalidArgumentException($errors);
        }
        
        return true;
    }
}


