<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if(!Schema::hasTable('contas')){
            Schema::create('contas', function($table){
                $table->increments('id');
                $table->string('nome', 300);
                $table->text('descricao')->nullable();
                $table->decimal('valor', 19, 2);
                $table->date('vencimento');
                $table->tinyInteger('paga');
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
        Schema::drop('contas');
	}

}
