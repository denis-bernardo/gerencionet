<?php

class ProdutoValidator
{
    public function validate($data, $id = null)
    {
        $rules = [
            'referencia' => 'required|unique:produtos,referencia' . ($id ? ",$id" : ''),
            'nome' => 'required',
            'categorias_id' => 'required',
            'preco_custo' => 'required'
        ];
        
        $messages = [
            'referencia.required' => 'O campo <b>referência</b> é obrigatório.',
            'referencia.unique' => 'Produto já existente.',
            'nome.required' => 'O campo <b>nome</b> é obrigatório.',
            'categorias_id.required' => 'Necessário vincular uma <b>categoria</b>.',
            'preco_custo.required' => 'O campo <b>preço</b> é obrigatório.'
        ];
        
        $validator = Validator::make($data, $rules, $messages);
        
        if($validator->fails()){
            $errors = implode('<br>', array_values($validator->messages()->all()));
            throw new InvalidArgumentException($errors);
        }
        
        return true;
    }
}
