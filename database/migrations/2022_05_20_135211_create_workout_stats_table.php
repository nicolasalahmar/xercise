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
            $table->enum('day_num',['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17'
            ,'18','19','20','21','22','23','24','25','26','27','28']);

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
