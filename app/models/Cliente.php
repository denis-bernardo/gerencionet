<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Cliente extends Eloquent
{
    
    use SoftDeletingTrait;
    
    protected $fillable = [
        'nome',
        'email',
        'data_nascimento',
        'telefone',
        'celular',
        'documento',
        'rg',
        'obs',
        'status',
        'deleted_at',
        'logradouro',
        'numero',
        'bairro',
        'complemento',
        'cidade',
        'estado',
        'cep'
    ];
    
    protected $dates = ['deleted_at'];
    
    protected $softDelete = true;
    
    public function getDates()
    {
        return ['data_nascimento', 'created_at', 'updated_at'];
    }
}