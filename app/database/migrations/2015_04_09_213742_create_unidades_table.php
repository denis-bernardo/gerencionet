<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnidadesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
    {
        if(!Schema::hasTable('unidades')){
            Schema::create('unidades', function ($table){
                $table->increments('id');
                $table->string('nome', 200);
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
            Schema::drop('unidades');
	}

}
