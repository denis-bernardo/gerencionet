<?php

class EstoqueValidator
{
    public function validate($data)
    {
        $rules = [
            'item' => 'required',
            'preco' => 'required',
            'quantidade' => 'required',
            'id_unidades' => 'required',
            'minimo' => 'required'
        ];
        
        $messages = [
            'item.required' => 'O campo <b>item</b> é obrigatório.',
            'preco.required' => 'O campo <b>preço unitário</b> é obrigatório.',
            'quantidade.required' => 'O campo <b>quantidade</b> é obrigatório.',
            'id_unidades.required' => 'O campo <b>unidade</b> é obrigatório.',
            'minimo.required' => 'O campo <b>quantidade mínima</b> é obrigatório.',
        ];
        
        $validator = Validator::make($data, $rules, $messages);
        
        if ($validator->fails()) {
            $errors = implode('<br>', array_values($validator->messages()->all()));
            throw new InvalidArgumentException($errors);
        }
        
        return true;
    }
}

