<?php

class ConfigEmail extends Eloquent
{

    protected $table = 'config_email';

    protected $fillable = [
        'email',
        'servidor',
        'porta',
        'senha',
        'seguranca',
        'autenticacao'
    ];

    public function getDates()
    {
        return ['created_at', 'updated_at'];
    }
}
