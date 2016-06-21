<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Unidade extends Eloquent
{
    use SoftDeletingTrait;
    
    protected $fillable = [
        'nome',
        'deleted_at'
    ];
    
    protected $dates = ['deleted_at'];
    protected $softDelete = true;

    public function getDates() {
        return ['created_at', 'updated_at'];
    }
}