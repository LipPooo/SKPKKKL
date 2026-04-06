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
        Schema::create('fund_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_report_id')->constrained('program_reports')->onDelete('cascade');
            $table->foreignId('requester_id')->constrained('users')->onDelete('cascade');
            $table->integer('total_member_approvals')->default(0);
            $table->enum('status', ['pending_members', 'pending_boss', 'approved_by_boss', 'rejected'])->default('pending_members');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fund_requests');
    }
};
