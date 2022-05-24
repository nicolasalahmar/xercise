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
        Schema::create('programs', function (Blueprint $table) {
            $table->bigIncrements('program_id');
            $table->string('name');
            $table->longtext('description');
            $table->float('rating')->default(0);
            $table->enum('knee',['Yes','No','A little']);
            $table->time('duration');
            $table->enum('category',['muscle','weight','height','stretching']);
            $table->timestamps();
        });

        Schema::table('programs',function(Blueprint $table){
        	$table->unsignedBigInteger('coach_id')->nullable();
        	$table->foreign('coach_id')->references('coach_id')->on('coaches')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('programs');
    }
};
