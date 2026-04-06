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
        Schema::table('program_reports', function (Blueprint $table) {
            $table->string('payment_details')->nullable()->after('budget');
            $table->foreignId('pic_user_id')->nullable()->constrained('users')->nullOnDelete()->after('payment_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('program_reports', function (Blueprint $table) {
            $table->dropForeign(['pic_user_id']);
            $table->dropColumn(['payment_details', 'pic_user_id']);
        });
    }
};
