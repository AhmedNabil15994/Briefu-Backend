<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanySubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->date('date_from');
            $table->date('date_to')->nullable();

            $table->decimal('price',9,3)->default(0.000);
            $table->integer('job_posts')->nullable();
            $table->integer('months')->nullable();
            $table->integer('sort');
            $table->boolean('video_cv')->default(false);
            $table->boolean('company_in_home')->default(false);

            $table->bigInteger('package_id')->unsigned();
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
            $table->bigInteger('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

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
        Schema::dropIfExists('company_subscriptions');
    }
}
