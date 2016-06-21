<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if(!Schema::hasTable('usuarios')){
            Schema::create('usuarios', function($table){
                $table->increments('id');
                $table->string('nome', 200);
                $table->string('email', 200)->unique();
                $table->string('password', 100);
                $table->tinyInteger('status');
                $table->string('foto', 300)->nullable();
                $table->string('remember_token', 200)->nullable();
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
        Schema::drop('usuarios');
	}

}
