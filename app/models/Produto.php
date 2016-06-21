<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Produto extends Eloquent
{
    
    use SoftDeletingTrait;
    
    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'produtos';
        
    protected $fillable = array('nome', 'referencia', 'preco_custo', 'margem', 'preco_final', 'status', 'categorias_id');

    protected $dates = ['deleted_at'];
        
    public function getDates()
    {
        return ['created_at', 'updated_at'];
    }
    
    public function estoque()
    {
        return $this->belongsToMany('Estoque', 'produtos_assoc_estoque', 'id_produto', 'id_estoque')->withPivot('id_produto','id_estoque','quantidade', 'valor');
    }
}

