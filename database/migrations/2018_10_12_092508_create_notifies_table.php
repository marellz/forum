<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotifiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifies', function (Blueprint $table) {
            $table->increments('id');

            //identifier
            $table->string('code');

            //if thread based
            $table->integer('from');
            $table->integer('to');
            $table->string('type');
            $table->string('thread')->nullable();

            // if not thread-based
            $table->string('content')->nullable();
            $table->string('url')->nullable();

            // read status
            $table->boolean('read')->default(false);
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
        Schema::dropIfExists('notifies');
    }
}
