<?php

class ContaValidator
{
    public function validate($data)
    {
        $rules = [
            'nome' => 'required',
            'valor' => 'required',
            'vencimento' => 'required'
        ];
        
        $messages = [
            'nome.required' => 'O campo <b>nome</b> é obrigatório.',
            'valor.required' => 'O campo <b>valor</b> é obrigatório.',
            'vencimento.required' => 'O campo <b>vencimento</b> é obrigatório.'
        ];
        
        $validator = Validator::make($data, $rules, $messages);
        
        if ($validator->fails()) {
            $errors = implode('<br>', array_values($validator->messages()->all()));
            throw new InvalidArgumentException($errors);
        }
        
        return true;
    }
}