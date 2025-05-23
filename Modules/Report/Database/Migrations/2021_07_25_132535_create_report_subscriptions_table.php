<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->decimal('price',9,3)->default(0.000);

            $table->date('date_from');
            $table->date('date_to')->nullable();

            $table->integer('months')->nullable();

            $table->bigInteger('package_id')->unsigned()->nullable();
            $table->foreign('package_id')
                  ->references('id')->on('packages')
                  ->onUpdate('cascade');

            $table->bigInteger('company_id')->unsigned();
            $table->foreign('company_id')
                  ->references('id')->on('companies')
                  ->onUpdate('cascade')->onDelete('cascade');

            $table->softDeletes();
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
        Schema::dropIfExists('pages');
    }
}
