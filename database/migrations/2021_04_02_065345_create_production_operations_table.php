<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_operations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("operation_id")->unsigned();
            $table->bigInteger("production_id")->unsigned();
            $table->foreign("operation_id")->references("id")->on("operations")->cascadeOnDelete();
            $table->foreign("production_id")->references("id")->on("productions")->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('production_operations');
    }
}
