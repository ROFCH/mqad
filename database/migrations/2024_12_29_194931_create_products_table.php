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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('textde', 50);
            $table->unsignedInteger('sample');
            $table->string('code', 4);
            $table->string('price');
            $table->unsignedInteger('sort');
            $table->unsignedInteger('delivery_note');
            $table->string('packaging');
            $table->unsignedInteger('membership');
            $table->unsignedInteger('type');
            $table->unsignedInteger('sort2');
            $table->unsignedInteger('evaluation');
            $table->unsignedInteger('sort3');
            $table->unsignedInteger('size');
            $table->string('weight');
            $table->unsignedInteger('translation_id');
            $table->string('matrix', 6);
            $table->boolean('infectious');
            $table->boolean('active');
            $table->string('volume', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
