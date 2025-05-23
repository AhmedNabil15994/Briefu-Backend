<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientSubscriptionPossibilitiesTable extends Migration {

	public function up()
	{
		Schema::create('client_subscription_possibilities', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('client_subscription_id')->unsigned();
			$table->string('title')->nullable();
			$table->timestamps();
            $table->foreign('client_subscription_id')->references('id')->on('client_subscription')->onDelete('cascade');
		});
	}

	public function down()
	{
		Schema::drop('client_subscription_possibilities');
	}
}