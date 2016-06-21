<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if(!Schema::hasTable('clientes')){
            Schema::create('clientes', function($table){
                $table->increments('id');
                $table->string('nome', 200);
                $table->string('email', 200)->nullable();
                $table->date('data_nascimento')->nullable();
                $table->string('telefone', 30)->unique();
                $table->string('celular', 30)->nullable();
                $table->string('documento', 30)->nullable();
                $table->string('rg', 30)->nullable();
                $table->text('obs')->nullable();
                $table->string('logradouro', 200);
                $table->string('numero', 10);
                $table->string('bairro', 100);
                $table->string('complemento', 200)->nullable();
                $table->string('cidade', 150);
                $table->string('estado', 150);
                $table->integer('cep')->nullable();
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
        Schema::drop('clientes');
	}

}
