<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('privileges', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->primary(['role_id', 'user_id']);
        });

        Schema::create('privilege_role', function (Blueprint $table) {
            $table->foreignId('privilege_id')->constrained()->cascadeOnDelete();
            $table->foreignId('role_id')->constrained()->cascadeOnDelete();
            $table->primary(['privilege_id', 'role_id']);
        });

        Schema::create('privilege_user', function (Blueprint $table) {
            $table->foreignId('privilege_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->primary(['privilege_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('privilege_user');
        Schema::dropIfExists('privilege_role');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('privileges');
        Schema::dropIfExists('roles');
    }
};
