<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedidosAssocProdutosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if(!Schema::hasTable('pedidos_assoc_produtos')){
            Schema::create('pedidos_assoc_produtos', function($table){
                $table->increments('id');
                $table->integer('id_pedido');
                $table->integer('id_produto');
                $table->text('opcionais')->nullable();
                $table->text('removidos')->nullable();
                $table->text('composto')->nullable();
                $table->integer('quantidade');
                $table->decimal('preco', 19, 2);
                $table->timestamps();
                $table->dateTime('deleted_at')->nullable();
            });
        }
	}
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('pedidos_assoc_produtos');
	}

}
