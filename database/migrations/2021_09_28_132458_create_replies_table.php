<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replies', function (Blueprint $table) {
            $table->id();
            $table->longText('content');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('message_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('message_id')->references('id')->on('messages')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('replies');
    }
}
