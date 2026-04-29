<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nisn', 20)->unique();
            $table->string('nama');
            $table->string('kelas');
            $table->string('jurusan');
            $table->string('password');
            $table->enum('role', ['siswa'])->default('siswa');
            $table->boolean('sudah_voting')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('users');
    }
};