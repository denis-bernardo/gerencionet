<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Pedido extends Eloquent
{
    use SoftDeletingTrait;
    
    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'pedidos';
    
    protected $fillable = [
        'id_cliente',
        'id_mesa',
        'id_usuario',
        'entrega',
        'fiado',
        'valor',
        'taxa_entrega',
        'valor_total',
        'valor_recebido',
        'troco',
        'e_logradouro',
        'e_numero',
        'e_bairro',
        'e_complemento',
        'e_cidade',
        'e_estado',
        'e_cep',
        'cupom',
        'status'
    ];

    protected $dates = ['deleted_at'];
        
    public function getDates()
    {
        return ['created_at', 'updated_at'];
    }
    
    public function produtos()
    {
        return $this->belongsToMany('Produto', 'pedidos_assoc_produtos', 'id_pedido', 'id_produto')->withPivot('id_produto', 'opcionais', 'removidos', 'composto', 'quantidade', 'preco');
    }
    
    public function cliente()
    {
        return $this->hasOne('Cliente', 'id', 'id_cliente');
    }
    
    public function mesa()
    {
        return $this->hasOne('Mesa', 'id', 'id_mesa');
    }
}
