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
        Schema::create('diet_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diet_item_id')->constrained('diet_items')->onDelete('cascade');
            $table->text('comment');
            $table->boolean('send_notification')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diet_feedback');
    }
};
