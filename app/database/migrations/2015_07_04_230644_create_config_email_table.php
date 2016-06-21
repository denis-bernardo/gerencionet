<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigEmailTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('config_email', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('email', 200);
            $table->string('servidor', 200);
            $table->string('porta', 10);
            $table->string('senha', 100);
            $table->string('seguranca', 5)->nullable();
            $table->tinyInteger('autenticacao')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('config_email');
	}

}
