<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('private_enrolls', function (Blueprint $table) {
        $table->bigIncrements('private_enroll_id');
        $table->date('date');
        $table->boolean('done');
    });

    Schema::table('private_enrolls',function(Blueprint $table){
        $table->unsignedBigInteger('user_id');
        $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');

        $table->unsignedBigInteger('private_program_id');
        $table->foreign('private_program_id')->references('private_program_id')->on('private_programs')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('private_enrolls');
    }
};
