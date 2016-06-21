<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdutosAssocEstoqueTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if(!Schema::hasTable('produtos_assoc_estoque')){
            Schema::create('produtos_assoc_estoque', function($table){
                $table->increments('id');
                $table->integer('id_produto');
                $table->integer('id_estoque');
                $table->integer('quantidade')->nullable();
                $table->decimal('valor', 19, 2)->nullable();
                $table->tinyInteger('status')->nullable();
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
        Schema::drop('produtos_assoc_estoque');
	}

}
