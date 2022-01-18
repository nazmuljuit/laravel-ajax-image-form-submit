<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationEducation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registration_education', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('applicant_id');
            $table->integer('exam_id');
            $table->integer('university_id')->nullable();
            $table->integer('board_id')->nullable();
            $table->float('result',3,2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registration_education');
    }
}
