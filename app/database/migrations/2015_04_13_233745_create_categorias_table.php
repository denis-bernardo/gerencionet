<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if(!Schema::hasTable('categorias')){
            Schema::create('categorias', function($table){
                $table->increments('id');
                $table->string('nome', 200);
                $table->integer('parent')->nullable();
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
        Schema::drop('categorias');
	}

}
