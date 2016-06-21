<?php

class MesaValidator
{
    public function validate($data)
    {
        $rules = [
            'nome' => 'required',
        ];
        
        $messages = [
            'nome.required' => 'O campo <b>nome</b> é obrigatório.',
        ];
        
        $validator = Validator::make($data, $rules, $messages);
        
        if ($validator->fails()) {
            $errors = implode('<br>', array_values($validator->messages()->all()));
            throw new InvalidArgumentException($errors);
        }
        
        return true;
        
    }
}
