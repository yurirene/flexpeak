<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operations', function (Blueprint $table) {
            $table->id();
            $table->decimal("volume", 8,2);
            $table->unsignedBigInteger("inventory_id");
            $table->unsignedBigInteger("operation_type_id");
            $table->foreign("inventory_id")
                    ->references("id")
                    ->on("inventories")->cascadeOnDelete();
            $table->foreign("operation_type_id")
                    ->references("id")
                    ->on("operation_types")
                    ->cascadeOnDelete();
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
        Schema::dropIfExists('operations');
    }
}
