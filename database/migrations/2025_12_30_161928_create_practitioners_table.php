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
        Schema::create('practitioners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('dni', 8)->unique();
            $table->string('student_code')->unique();
            $table->string('phone')->nullable();
            $table->string('semester'); // e.g., '24-1'
            $table->string('company_name');
            $table->string('practice_area');

            // Academic Supervisors (Docentes)
            $table->foreignId('academic_supervisor_1_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('academic_supervisor_2_id')->nullable()->constrained('users')->nullOnDelete();

            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['por iniciar', 'en proceso', 'finalizado'])->default('por iniciar');
            $table->integer('hours_completed')->default(0);

            $table->string('photo_path')->nullable();
            $table->string('final_report_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('practitioners');
    }
};
