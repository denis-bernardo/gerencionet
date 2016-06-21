<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Conta extends Eloquent
{
    use SoftDeletingTrait;
    
    protected $fillable = [
        'nome',
        'valor',
        'vencimento',
        'descricao',
        'paga',
        'deleted_at',
    ];
    protected $dates = ['deleted_at'];
    protected $softDelete = true;

    public function getDates() {
        return ['vencimento', 'created_at', 'updated_at'];
    }
}

