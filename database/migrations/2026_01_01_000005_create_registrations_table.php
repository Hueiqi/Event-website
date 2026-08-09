<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id('registration_id');
            $table->foreignId('user_id')
                ->constrained('users', 'user_id')->cascadeOnDelete();
            $table->foreignId('event_id')
                ->constrained('events', 'event_id')->cascadeOnDelete();
            $table->timestamp('registered_at')->useCurrent();
            $table->enum('status', ['registered', 'cancelled', 'attended'])
                ->default('registered');
            $table->string('qr_code', 255)->nullable();
            $table->boolean('checked_in')->default(false);
            $table->timestamp('checked_in_at')->nullable();
            $table->boolean('certificate_generated')->default(false);
            $table->boolean('questionnaire_completed')->default(false);
            $table->timestamps();

            $table->unique(['user_id', 'event_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
