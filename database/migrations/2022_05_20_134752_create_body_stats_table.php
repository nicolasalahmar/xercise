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
        Schema::create('body_stats', function (Blueprint $table) {
            $table->bigIncrements('body_stats_id');
            $table->float('weight');
            $table->integer('height');
            $table->dateTime('dateTime');
        });

        Schema::table('body_stats',function(Blueprint $table){
            $table->unsignedBigInteger('user_id');
        	$table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('body_stats');
    }
};
