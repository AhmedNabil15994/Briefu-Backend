<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAppleTierDataToClientSubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_subscription', function (Blueprint $table) {
			$table->tinyInteger('is_apple_tier')->default(0);
			$table->json('apple_transaction_data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_subscription', function (Blueprint $table) {

        });
    }
}
