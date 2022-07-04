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
        Schema::create('workout_stats', function (Blueprint $table) {
            $table->bigIncrements('workout_stats_id');
            $table->time('duration');
            $table->float('Kcal');
            $table->enum('day_num',['1','2','3','4','5','6','7']);

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
        Schema::dropIfExists('workout_stats');
    }
};
