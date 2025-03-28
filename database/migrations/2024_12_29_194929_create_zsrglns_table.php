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
        Schema::create('zsrglns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('address_id');
            $table->string('type', 24);
            $table->string('name', 50);
            $table->string('surname', 50);
            $table->string('addidional', 30);
            $table->string('postalnumber', 6);
            $table->string('place', 24);
            $table->string('zsr', 16);
            $table->string('gln', 14);
            $table->unsignedInteger('from_year');
            $table->unsignedInteger('till_year');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zsrglns');
    }
};
