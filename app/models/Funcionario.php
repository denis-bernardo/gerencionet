<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Funcionario extends Eloquent {

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
        'funcao',
        'salario',
        'entregador',
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

    public function getDates() {
        return ['data_nascimento', 'created_at', 'updated_at'];
    }

}
