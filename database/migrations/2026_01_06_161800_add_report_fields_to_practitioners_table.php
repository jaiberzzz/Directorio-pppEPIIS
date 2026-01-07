<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('practitioners', function (Blueprint $table) {
            $table->enum('report_status', ['pending', 'approved', 'rejected'])->nullable()->after('final_report_path');
            $table->text('feedback')->nullable()->after('report_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('practitioners', function (Blueprint $table) {
            $table->dropColumn(['report_status', 'feedback']);
        });
    }
};
