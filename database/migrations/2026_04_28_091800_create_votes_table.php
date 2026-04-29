<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kandidat_id')->constrained('kandidat')->onDelete('cascade');
            $table->string('token')->unique();
            $table->timestamp('voted_at');
        });
    }

    public function down(): void {
        Schema::dropIfExists('votes');
    }
};