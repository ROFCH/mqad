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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('address_id');
            $table->foreignId('product_id');
            $table->unsignedInteger('sample_quantity');
            $table->date('inscription_date');
            $table->unsignedInteger('start_year');
            $table->unsignedInteger('start_quarter');
            $table->date('termination_date');
            $table->unsignedInteger('stop_year');
            $table->unsignedInteger('stop_quarter');
            $table->binary('free');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
