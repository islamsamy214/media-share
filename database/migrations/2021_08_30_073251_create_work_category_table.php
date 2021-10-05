<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_category', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('work_id')->unsigned();
            $table->bigInteger('work_category_id')->unsigned();
            $table->timestamps();

            $table->foreign('work_id')->references('id')->on('works')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('work_category_id')->references('id')->on('work_categories')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_category');
    }
}
