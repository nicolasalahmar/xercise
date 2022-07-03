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
            $table->date('date');
            $table->unsignedBigInteger('user_id');
        	$table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('body_stats');
    }
};
