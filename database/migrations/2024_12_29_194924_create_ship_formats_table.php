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
        Schema::create('ship_formats', function (Blueprint $table) {
            $table->id();
            $table->string('textde', 50);
            $table->unsignedInteger('translation_id');
            $table->unsignedInteger('maxweight');
            $table->unsignedInteger('maxnumber');
            $table->decimal('price', 8, 2);
            $table->unsignedInteger('lot');
            $table->string('remark', 100);
            $table->unsignedInteger('nextformat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ship_formats');
    }
};
