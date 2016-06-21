<?php

class PedidoValidator
{
    public function validate($data)
    {
        $rules = [
            'valor' => 'required',
            'valor_total' => 'required'
        ];
        
        $messages = [
            'valor.required' => '<b>Preço</b> do pedido vazio, verique atentamente.',
            'valor_total.required' => '<b>Preço final</b> do pedido vazio, verique atentamente.'
        ];
        
        $validator = Validator::make($data, $rules, $messages);
        
        if ($validator->fails()) {
            $errors = implode('<br>', array_values($validator->messages()->all()));
            throw new InvalidArgumentException($errors);
        }
        
        return true;
    }
}
