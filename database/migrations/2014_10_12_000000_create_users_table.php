<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

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
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('type')->nullable();

            $table->string('avatar')->default('/images/default/avatar.png');
            $table->string('cover')->nullable('/images/default/cover.jpg');

            $table->string('phone')->nullable();
            $table->string('alt_email')->nullable();
            $table->string('alt_phone')->nullable();

            $table->string('city')->default('Nairobi');
            $table->string('country')->default('Kenya');

            $table->string('occupation')->nullable();
            $table->text('bio')->nullable();


            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
