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
        Schema::create('patient_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('educator_id')->constrained('educators')->onDelete('cascade');
            $table->foreignId('anthropometry_id')->nullable()->constrained('anthropometries')->onDelete('set null');
            $table->enum('plan_description', ['monthly', 'quarterly', 'semiannual'])->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('finalized_at')->nullable();   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_registrations');
    }
};
