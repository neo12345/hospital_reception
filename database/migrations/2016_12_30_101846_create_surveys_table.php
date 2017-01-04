<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('survey_template_id')->unsigned();
            $table->integer('patient_id')->unsigned();
            $table->string('name', 30);
            $table->string('survey_url', 30);
            $table->tinyInteger('is_sent');
            $table->timestamps();
            $table->foreign('survey_template_id')->references('id')->on('survey_templates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surveys');
    }
}
