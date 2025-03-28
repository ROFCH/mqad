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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('salutation', 80)->nullable();
            $table->string('name', 80);
            $table->string('address', 80)->nullable();
            $table->string('address2', 80)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->string('city', 80)->nullable();
            $table->string('country', 10)->default('CH');
            $table->string('phone', 20)->nullable();
            $table->string('mail', 80)->nullable();
            $table->string('contact', 80)->nullable()->nullable();
            $table->string('remarks', 200)->nullable()->nullable();
            $table->foreignId('language_id')->default('1');
            $table->foreignId('lab_type_id')->default('1');
            $table->foreignId('lab_group_id')->nullable();
            $table->boolean('qualab')->default(1);
            $table->boolean('no_charge')->default(0);
            $table->foreignId('status_id')->default('1');
            $table->unsignedInteger('report_size_id')->default(1);
            $table->string('invoice_name', 80)->nullable();
            $table->string('invoice_address', 80)->nullable();
            $table->string('invoice_address2', 80)->nullable();
            $table->string('invoice_address3', 80)->nullable();
            $table->string('invoice_street', 80)->nullable();
            $table->string('invoice_postal_code', 20)->nullable();
            $table->string('invoice_city', 80)->nullable();
            $table->string('invoice_country', 20)->nullable();
            $table->string('invoice_mail', 80)->nullable();
            $table->foreignId('invoice_type_id')->nullable();
            $table->boolean('no_membership')->default(1);
            $table->boolean('simple_membership')->default(1);
            $table->foreignId('ship_format_id')->default('1');
            $table->foreignId('report_type_id')->default('1');
            $table->boolean('h3_education_only')->default(1);
            $table->boolean('difficult')->default(1);
            $table->string('default_password', 20)->nullable();
            $table->unsignedInteger('online_num')->nullable();
            $table->foreignId('ship_type_id')->default('1');
            $table->foreignId('report_format_id')->default('1');
            $table->boolean('no_reminder')->default(0);
            $table->boolean('temp_no_reminder')->default(0);
            $table->string('qualab_num', 13)->nullable();
            $table->string('sas_num', 20)->nullable();
            $table->string('Swissmedic_num', 16)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
