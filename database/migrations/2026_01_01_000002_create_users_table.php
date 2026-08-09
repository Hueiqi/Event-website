<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->foreignId('agency_id')->nullable()
                ->constrained('agencies', 'agency_id')->nullOnDelete();
            $table->string('name', 100);
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->enum('role', ['admin', 'agency_admin', 'organizer', 'participant'])
                ->default('participant');
            $table->enum('user_type', [
                'government', 'educational', 'private',
                'politician', 'international', 'public',
            ])->default('public');
            $table->string('mykad', 50)->nullable();
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
