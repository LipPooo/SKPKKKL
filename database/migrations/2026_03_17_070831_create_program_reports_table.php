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
        Schema::create('program_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name_of_program');
            $table->date('date');
            $table->enum('type', ['sukan', 'sosial']);
            $table->string('location');
            $table->integer('total_members_involved');
            $table->integer('total_non_members')->nullable();
            $table->string('vip_details')->nullable();
            $table->integer('total_participation');
            $table->string('collaboration')->nullable();
            $table->enum('organizer', ['KKKL', 'TNB', 'Luar']);
            $table->decimal('budget', 12, 2);
            $table->string('recognition')->nullable();
            $table->string('image_proof_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_reports');
    }
};
