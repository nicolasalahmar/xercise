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
            $table->string('FirstName');
            $table->string('LastName');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('coach_num');
            $table->enum('gender',['Male','Female']);
            $table->string('image')->nullable()->default(null);
            $table->integer('programs')->default(0);
            $table->longText('description');
            $table->string('phone');
            $table->float('rating')->default(0);
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
        Schema::dropIfExists('coaches');
    }
};
