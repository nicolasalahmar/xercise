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
        Schema::create('private_programs', function (Blueprint $table) {
            $table->bigIncrements('private_program_id');
            $table->string('name');
            $table->longtext('description');
            $table->time('duration');
            $table->timestamps();
        });

        Schema::table('private_programs',function(Blueprint $table){
        	$table->unsignedBigInteger('coach_id');
        	$table->foreign('coach_id')->references('coach_id')
     			->on('coaches')->onDelete('cascade');

                 $table->unsignedBigInteger('user_id');
                 $table->foreign('user_id')->references('user_id')
                      ->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('private_programs');
    }
};
