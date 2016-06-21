<?php

class FuncionarioValidator {

    public function validate($data) {

        $rules = [
            'nome' => 'required',
            'email' => 'email',
            'funcao' => 'required',
            'telefone' => 'required',
            'logradouro' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'estado' => 'required'
        ];

        $messages = [
            'nome.required' => 'O campo <b>nome</b> é obrigatório.',
            'funcao.required' => 'O campo <b>função</b> é obrigatório.',
            'email.email' => 'Formato do <b>email</b> inválido.',
            'telefone.required' => 'O campo <b>telefone</b> é obrigatório.',
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
