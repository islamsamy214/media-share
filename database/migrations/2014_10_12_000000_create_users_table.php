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
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('title')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('image')->default('default.jpg');
            $table->string('cv')->nullable();
            $table->text('about')->nullable();
            $table->string('education')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('linkedin_id')->nullable();
            $table->string('twitter_id')->nullable();
            $table->string('github_id')->nullable();
            $table->string('behance_id')->nullable();
            $table->string('youtube_id')->nullable();
            $table->string('instagram_id')->nullable();
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
