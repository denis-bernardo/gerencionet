<?php

class ConfigGeral extends Eloquent
{

    protected $table = 'config';

    protected $fillable = [
        'nome_estabelecimento'
    ];

    public function getDates()
    {
        return ['created_at', 'updated_at'];
    }
}
