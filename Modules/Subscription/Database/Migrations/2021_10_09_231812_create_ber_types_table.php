<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBerTypesTable extends Migration {

	public function up()
	{
		Schema::create('ber_types', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title');
			$table->integer('days_number');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('ber_types');
	}
}