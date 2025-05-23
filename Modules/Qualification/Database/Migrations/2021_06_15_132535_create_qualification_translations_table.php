<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQualificationTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qualification_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('locale')->index();
            $table->bigInteger('qualification_id')->unsigned();
            $table->foreign('qualification_id')->references('id')->on('qualifications')->onDelete('cascade');
            $table->unique(['qualification_id','locale']);
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
        Schema::dropIfExists('qualification_translations');
    }
}
