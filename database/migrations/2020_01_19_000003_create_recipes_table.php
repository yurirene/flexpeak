<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string("name", 50);
            $table->decimal("per_water", 5, 2);
            $table->decimal("per_alcohol", 5, 2);
            $table->decimal("per_fragrance", 5, 2);
            $table->unsignedBigInteger("fragrance_id");
            $table->foreign('fragrance_id')
                ->references('id')->on('inventories');
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
        Schema::dropIfExists('recipes');
    }
}
