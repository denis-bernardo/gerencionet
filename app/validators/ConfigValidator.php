<?php

class ConfigValidator
{
    public function validate($data)
    {
        $rules = [
            'nome_estabelecimento' => 'required'
        ];

        $messages = [
            'nome_estabelecimento.required' => 'O campo <b>nome do estabelecimento</b> é obrigatório.'
        ];

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            $errors = implode('<br>', array_values($validator->messages()->all()));
            throw new InvalidArgumentException($errors);
        }

        return true;
    }
}
