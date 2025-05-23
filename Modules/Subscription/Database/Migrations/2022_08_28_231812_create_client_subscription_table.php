<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientSubscriptionTable extends Migration {

	public function up()
	{
		Schema::create('client_subscription', function(Blueprint $table) {
			$table->increments('id');
			$table->bigInteger('client_id')->unsigned();
			$table->integer('subscription_id')->unsigned();
			$table->integer('days_number');
			$table->datetime('expired_date');
			$table->float('amount');
            $table->tinyInteger('is_free')->default(0);
			$table->enum('paid',['pending','paid','expired'])->default('pending');
			$table->enum('action_type',['new_subscribe','renew','change_subscription'])->default('new_subscribe');
			$table->timestamps();

            $table->foreign('subscription_id')->references('id')->on('subscriptions')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
		});
	}

	public function down()
	{
		Schema::drop('client_subscription');
	}
}
