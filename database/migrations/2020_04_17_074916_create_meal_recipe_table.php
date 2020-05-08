<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMealRecipeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meal_recipe', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('meal_id')->nullable();
            $table->unsignedInteger('recipe_id')->nullable();

            $table->foreign('meal_id')->references('id')
                  ->on('meals')->onDelete('cascade');
            $table->foreign('recipe_id')->references('id')
                  ->on('recipes')->onDelete('cascade');

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
        Schema::dropIfExists('meal_recipe');
    }
}
