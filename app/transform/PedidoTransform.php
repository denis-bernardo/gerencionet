<?php

class PedidoTransform
{
    protected $pedido = [];
    
    public function transform($id, $data)
    {
        foreach ($data['produto'] as $k => $v) {
            $this->pedido[$k]['id_pedido'] = $id;
            $this->pedido[$k]['id_produto'] = $v['id'];
            $this->pedido[$k]['quantidade'] = 1;
            $this->pedido[$k]['preco'] = $v['preco'];
            if (isset($v['opcionais'])) {
                $this->pedido[$k]['opcionais'] = json_encode($v['opcionais']);
            }
            if (isset($v['removidos'])) {
                $this->pedido[$k]['removidos'] = json_encode($v['removidos']);
            }
            if (isset($v['composto'])) {
                $this->pedido[$k]['composto'] = json_encode($v['composto']);
            }
        }
        return $this->pedido;
    }
}