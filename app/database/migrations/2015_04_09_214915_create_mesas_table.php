<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMesasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if(!Schema::hasTable('mesas')){
            Schema::create('mesas', function($table){
                $table->increments('id');
                $table->string('nome', 200);
                $table->tinyInteger('status');
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
        Schema::drop('mesas');
	}

}
