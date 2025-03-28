<?php

use App\Models\Note;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('note_user', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Note::class);
            $table->foreignIdFor(User::class);
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        schema::dropIfExists('note_user');
    }
};
