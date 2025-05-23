<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Modules\Subscription\Entities\Access;

class CreateAccessesTable extends Migration {

	public function up()
	{
		Schema::create('accesses', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('possibility_id')->unsigned();
			$table->string('access_to')->nullable();
            $table->foreign('possibility_id')->references('id')->on('possibilities')->onDelete('cascade');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('accesses');
	}
}