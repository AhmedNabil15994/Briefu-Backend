<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_levels', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->decimal('price',9,3)->default(0.000);
            $table->boolean('video_cv')->default(false);
            $table->boolean('company_in_home')->default(false);
            $table->integer('job_posts')->default(1);
            $table->integer('months')->default(1)->nullable();

            $table->bigInteger('package_id')->unsigned();
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
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
        Schema::dropIfExists('package_levels');
    }
}
