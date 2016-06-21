<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstoqueTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if(!Schema::hasTable('estoque')){
            Schema::create('estoque', function ($table){
                $table->increments('id');
                $table->string('item', 200);
                $table->decimal('preco', 19, 2);
                $table->integer('quantidade');
                $table->integer('id_unidades');
                $table->integer('minimo');
                $table->timestamps();
                $table->dateTime('deleted_at');
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
            Schema::drop('estoque');
	}

}
