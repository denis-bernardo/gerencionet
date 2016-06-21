<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Estoque extends Eloquent
{
    use SoftDeletingTrait;
    
    protected $table = 'estoque';

    protected $fillable = [
        'item',
        'preco',
        'quantidade',
        'id_unidades',
        'minimo',
        'deleted_at',
    ];
    protected $dates = ['deleted_at'];
    protected $softDelete = true;

    public function getDates() {
        return ['created_at', 'updated_at'];
    }
    
    public function unidade()
    {
        return $this->hasOne('Unidade', 'id', 'id_unidades');
    }    
}
