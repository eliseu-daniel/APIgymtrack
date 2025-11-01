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
        Schema::create('diet_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diet_id')->constrained('diets')->onDelete('cascade');
            $table->foreignId('food_id')->constrained('food')->onDelete('cascade');
            $table->enum('measure', ['und', 'gr', 'ml', 'l']);
            $table->string('others')->nullable();
            $table->boolean('send_notification')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diet_items');
    }
};
