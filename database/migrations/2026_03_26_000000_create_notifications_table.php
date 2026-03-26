<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->enum('type', ['diet', 'workout', 'feedback']);

            $table->string('title');
            $table->text('message')->nullable();
            $table->text('comment')->nullable();

            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->boolean('read')->default(false);
            $table->foreignId('educator_id')->constrained('educators')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
}
