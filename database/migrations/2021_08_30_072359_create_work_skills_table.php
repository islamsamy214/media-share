<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_skills', function (Blueprint $table) {
            $table->id();
            $table->string('skill');
            $table->bigInteger('work_id')->unsigned();
            $table->timestamps();

            $table->foreign('work_id')->references('id')->on('works')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_skills');
    }
}
