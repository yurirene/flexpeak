<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipeComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_components', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("inventory_id")->unsigned();
            $table->bigInteger("recipe_id")->unsigned();
            $table->decimal("percent", 5,2);
            $table->foreign("inventory_id")->references("id")->on("inventories")->cascadeOnDelete();
            $table->foreign("recipe_id")->references("id")->on("recipes")->cascadeOnDelete();
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
        Schema::dropIfExists('recipe_components');
    }
}
