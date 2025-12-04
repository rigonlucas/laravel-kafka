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
        Schema::create('kafka_fallback', function (Blueprint $table) {
            $table->id();
            $table->string('topic', 255);
            $table->string('message_identifier', 255);
            $table->json('message');
            $table->json('headers')->nullable();
            $table->string('key')->default(-1);
            $table->enum('status', ['pending', 'processing', 'done', 'failed'])->default('pending');
            $table->integer('attempts')->default(0);
            $table->timestamps();

            $table->index('status');
            $table->index('topic');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kafka_fallback');
    }
};
