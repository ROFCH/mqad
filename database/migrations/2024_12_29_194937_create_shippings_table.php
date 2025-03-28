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
        Schema::create('shippings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('address_id');
            $table->unsignedInteger('termin');
            $table->unsignedInteger('size');
            $table->unsignedInteger('language_id');
            $table->unsignedInteger('priority');
            $table->string('material');
            $table->unsignedInteger('amount');
            $table->string('note', 100);
            $table->decimal('weight', 8, 2);
            $table->unsignedInteger('grp');
            $table->unsignedInteger('lot');
            $table->unsignedInteger('packing');
            $table->string('sort', 100);
            $table->unsignedInteger('year');
            $table->unsignedInteger('quarter');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shippings');
    }
};
