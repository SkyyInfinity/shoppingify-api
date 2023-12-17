<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('list_item', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->foreignUuid('list_id')->references('id')->on('shopping_lists');
            $table->foreignUuid('item_id')->references('id')->on('items');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_item');
    }
};
