<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdutosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if(!Schema::hasTable('produtos')){
            Schema::create('produtos', function($table){
                $table->increments('id');
                $table->string('nome', 200);
                $table->text('descricao')->nullable();
                $table->string('referencia', 100)->unique();
                $table->decimal('preco_custo', 19, 2);
                $table->integer('margem')->nullable();
                $table->decimal('preco_final', 19, 2)->nullable();
                $table->string('foto', 200)->nullable();
                $table->integer('categorias_id')->nullable();
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
        Schema::drop('produtos');
	}

}
