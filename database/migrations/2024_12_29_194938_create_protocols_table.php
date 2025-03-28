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
        Schema::create('protocols', function (Blueprint $table) {
            $table->id();
            $table->foreignId('address_id');
            $table->foreignId('method_id');
            $table->unsignedInteger('unit_id');
            $table->unsignedInteger('device_id');
            $table->string('device_num', 20);
            $table->string('Serialnumber', 20);
            $table->unsignedInteger('department');
            $table->dateTime('start_date');
            $table->unsignedInteger('start_year');
            $table->unsignedInteger('start_quarter');
            $table->dateTime('stop_date');
            $table->unsignedInteger('stop_year');
            $table->unsignedInteger('stop_quarter');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('protocols');
    }
};
