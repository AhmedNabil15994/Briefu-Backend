<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubscriptionsTable extends Migration {

	public function up()
	{
		Schema::create('subscriptions', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title');
			$table->float('price');
			$table->integer('order')->nullable();
			$table->tinyInteger('is_free')->default(0);
			$table->integer('ber_type_id')->unsigned();
			$table->integer('ber_numbers');
			$table->tinyInteger('status')->default(0);
			$table->timestamps();
            $table->foreign('ber_type_id')->references('id')->on('ber_types')->onDelete('cascade');
		});
	}

	public function down()
	{
		Schema::drop('subscriptions');
	}
}