<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skin_test_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('skin_type', ['dry', 'oily', 'combination', 'normal', 'sensitive']);
            $table->json('answers'); // Store quiz answers
            $table->integer('score_dry')->default(0);
            $table->integer('score_oily')->default(0);
            $table->integer('score_combination')->default(0);
            $table->integer('score_sensitive')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skin_test_results');
    }
};