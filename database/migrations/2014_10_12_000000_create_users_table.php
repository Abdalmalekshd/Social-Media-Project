<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('avatar')->nullable();
            $table->string('name');
            $table->boolean('gender')->comment('(0=>male),(1=>female)')->default(0);
            $table->text('description')->nullable();
            $table->string('email')->unique();
            $table->bigInteger('phone');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('country_id')->unsigned();
            $table->rememberToken();
            $table->timestamps();
            
            // $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');

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
}
