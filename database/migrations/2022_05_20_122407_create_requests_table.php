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
        Schema::create('requests', function (Blueprint $table) {
            $table->bigIncrements('request_id');
            $table->longtext('message');
            $table->enum('time_per_day',['10','15','20','25','30','35','40']);
            $table->enum('status',['pending','accepted','rejected']);
            $table->enum('objective',['weight','muscle','height','stretching']);
            $table->enum('days',['1','2','3','4','5']);
            $table->timestamps();
        });

        Schema::table('requests',function(Blueprint $table){
            $table->unsignedBigInteger('coach_id')->nullable();
        	$table->foreign('coach_id')->references('coach_id')->on('coaches')->onDelete('set null');

            $table->unsignedBigInteger('user_id')->nullable();
        	$table->foreign('user_id')->references('user_id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests');
    }
};
