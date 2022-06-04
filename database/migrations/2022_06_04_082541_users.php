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
        Schema::table('users',function(Blueprint $table){
            $table->unsignedBigInteger('active_program_id')->nullable();
        	$table->foreign('active_program_id')->references('program_id')->on('programs')->onDelete('set null');



            $table->unsignedBigInteger('active_private_program_id')->nullable();
        	$table->foreign('active_private_program_id')->references('private_program_id')->on('private_programs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
