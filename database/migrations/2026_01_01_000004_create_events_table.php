<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id('event_id');
            $table->foreignId('category_id')->nullable()
                ->constrained('categories', 'category_id')->nullOnDelete();
            $table->foreignId('agency_id')->nullable()
                ->constrained('agencies', 'agency_id')->cascadeOnDelete();
            $table->foreignId('organizer_id')->nullable()
                ->constrained('users', 'user_id')->nullOnDelete();
            $table->string('title', 200);
            $table->text('description')->nullable();
            $table->date('date');
            $table->time('time');
            $table->string('venue', 200);
            $table->integer('capacity');
            $table->enum('status', ['draft', 'open', 'closed', 'cancelled', 'completed'])
                ->default('draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
