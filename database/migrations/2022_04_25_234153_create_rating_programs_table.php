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
        Schema::create('rating_programs', function (Blueprint $table) {

            $table ->unsignedBigInteger('user_id');
            $table ->unsignedBigInteger('program_id');

            $table ->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table ->foreign('program_id')->references('program_id')->on('programs')->onDelete('cascade');

            $table ->primary(['user_id','program_id']);

            $table->enum('rating', ['1', '2', '3', '4', '5']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rating_programs');
    }
};
