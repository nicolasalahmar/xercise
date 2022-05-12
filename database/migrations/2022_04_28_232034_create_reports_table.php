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
        Schema::create('reports', function (Blueprint $table) {
            $table->bigIncrements('report_id');
            $table->enum('status',['pending','approved','rejected']);
            $table->text('message');

            $table->timestamps();
        });

        Schema::table('reports',function(Blueprint $table){
            $table ->unsignedBigInteger('coach_id');
            $table ->unsignedBigInteger('trainee_id');

            $table ->foreign('coach_id')->references('coach_id')->on('coaches')->onDelete('cascade');
            $table ->foreign('trainee_id')->references('trainee_id')->on('trainees')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
};
