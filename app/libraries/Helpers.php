<?php

class Helpers
{
    public static function dateDb($date)
    {
        return date('Y-m-d', strtotime(str_replace('/', '-', $date)));
    }
    
    public static function toDecimal($value)
    {
        return (double) str_replace(',', '.', str_replace('.', '', $value));
    }
    
    public static function toMoney($value)
    {
        return number_format($value, 2, ',', '.');
    }
    
    public static function withEmpty($data, $empty = '')
    {
        return ['' => $empty] + $data;
    }
    
    public static function objectToArray($data)
    {
        return json_decode(json_encode($data), true);
    }
    
    public static function updateStock($id)
    {
        $pedido = Pedido::find($id);
        //Percorre os produtos do pedido
        foreach ($pedido->produtos as $k => $v) {

            //estoque do produto
            $estoqueProd = Produto::find($v->id)->estoque;

            //estoque geral
            $estoqueGeral = Estoque::all();
            

            //Verifica se foi removidos itens do produto
            if ($v->pivot->removidos) {
                foreach (json_decode($v->pivot->removidos, true) as $key => $value) {
                    foreach ($estoqueProd as $ek => $ev) {
                        if ($ev->id == $value['id']) {
                            //remove os itens do produto
                            unset($estoqueProd[$ek]);
                        }
                    }
                }
            }

            //verifica se possui itens adicionais (opcionais)
            if ($v->pivot->opcionais) {
                foreach (json_decode($v->pivot->opcionais, true) as $key => $value) {
                    foreach ($estoqueGeral as $ek => $ev) {
                        if ($ev->id == $value['id']) {
                            $calc = ($ev->quantidade - $value['quantidade']);
                            DB::table('estoque')->where('id', '=', $ev->id)->update(['quantidade' => $calc]);
                        }
                    }
                }
            }

            //Caso o produto for composto, é dividido a quantidade dos itens
            if ($v->pivot->composto) {
                $c = count(json_decode($v->pivot->composto, true)) + 1;
            } else {
                $c = 1;
            }

            //Baixa no estoque de produtos compostos
            if ($v->pivot->composto) {
                foreach (json_decode($v->pivot->composto, true) as $key => $value) {
                    $estoqueProd = Produto::find($value['id'])->estoque;
                    foreach ($estoqueProd as $ck => $cv) {
                        $stockProd = $cv->pivot->quantidade / $c;
                        $calc = ($cv->quantidade - $stockProd);                        
                        DB::table('estoque')->where('id', '=', $cv->id)->update(['quantidade' => $calc]);
                    }                    
                }
            }

            //Baixa no estoque do produto principal
            foreach ($estoqueProd as $key => $value) {
                $stockProd = $value->pivot->quantidade / $c;
                $calc = ($value->quantidade - $stockProd);
                DB::table('estoque')->where('id', '=', $value->id)->update(['quantidade' => $calc]);
            }
        }
    }
}
