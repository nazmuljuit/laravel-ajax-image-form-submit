<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registration', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('applicant_name');
            $table->string('email');
            $table->text('mailing_address');
            $table->integer('division_id');
            $table->integer('district_id');
            $table->integer('ps_id');
            $table->text('address_details');
            $table->string('photo');
            $table->string('cv');
            $table->tinyInteger('status')->default('1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registration');
    }
}
