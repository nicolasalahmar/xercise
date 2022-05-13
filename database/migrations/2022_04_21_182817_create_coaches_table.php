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
        Schema::create('coaches', function (Blueprint $table){
            $table->bigIncrements('coach_id');
            $table->longText('description');
            $table->float('rating')->default(0);
            $table->integer('coach_num');
            $table->string('phone');
        });

        Schema::table('coaches',function(Blueprint $table){
            $table ->unsignedBigInteger('usr_id');

            $table ->foreign('usr_id')->references('usr_id')->on('users')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coaches');
    }
};
