<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('presentation_materials', function (Blueprint $table) {
            $table->id('material_id');
            $table->foreignId('event_id')
                ->constrained('events', 'event_id')->cascadeOnDelete();
            $table->string('title', 200);
            $table->string('file_path', 255);
            $table->foreignId('uploaded_by')->nullable()
                ->constrained('users', 'user_id')->nullOnDelete();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presentation_materials');
    }
};
