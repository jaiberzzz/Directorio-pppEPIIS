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
        Schema::table('convocatorias', function (Blueprint $table) {
            $table->string('title')->after('id')->nullable(); // E.g. "Practicante de Desarrollo Web"
            $table->string('area')->after('company')->nullable();
            $table->integer('vacancies')->after('area')->default(1);
            $table->date('start_date')->after('vacancies')->nullable();
            $table->date('end_date')->after('start_date')->nullable();
            $table->text('requirements')->after('description')->nullable();

            // Structured contact info
            $table->string('contact_name')->after('contact_details')->nullable();
            $table->string('contact_email')->after('contact_name')->nullable();
            $table->string('contact_phone')->after('contact_email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('convocatorias', function (Blueprint $table) {
            $table->dropColumn(['title', 'area', 'vacancies', 'start_date', 'end_date', 'requirements', 'contact_name', 'contact_email', 'contact_phone']);
        });
    }
};
