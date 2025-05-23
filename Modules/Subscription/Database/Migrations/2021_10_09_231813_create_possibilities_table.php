<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePossibilitiesTable extends Migration {

	public function up()
	{
		Schema::create('possibilities', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('subscription_id')->unsigned();
			$table->string('title')->nullable();
			$table->timestamps();
            $table->foreign('subscription_id')->references('id')->on('subscriptions')->onDelete('cascade');
		});
	}

	public function down()
	{
		Schema::drop('possibilities');
	}
}