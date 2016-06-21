<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedidosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if (!Schema::hasTable('pedidos')){
            Schema::create('pedidos', function($table){
                $table->increments('id');
                $table->integer('id_cliente')->nullable();
                $table->integer('id_mesa')->nullable();
                $table->integer('id_usuario');
                $table->tinyInteger('entrega');
                $table->tinyInteger('fiado');
                $table->decimal('valor', 19, 2);
                $table->decimal('taxa_entrega', 19, 2)->nullable();
                $table->decimal('valor_total', 19, 2);
                $table->decimal('valor_recebido', 19, 2);
                $table->decimal('troco', 19, 2);
                $table->string('e_logradouro', 200)->nullable();
                $table->string('e_numero', 10)->nullable();
                $table->string('e_bairro', 100)->nullable();
                $table->string('e_complemento', 200)->nullable();
                $table->string('e_cidade', 150)->nullable();
                $table->string('e_estado', 150)->nullable();
                $table->integer('e_cep')->nullable();
                $table->text('cupom')->nullable();
                $table->tinyInteger('status');
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
        Schema::drop('pedidos');
	}

}
