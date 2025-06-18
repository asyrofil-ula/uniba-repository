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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('faculty_id')->constrained('faculties');
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('document_type_id')->constrained('document_types');
            $table->string('title');
            $table->text('abstract_id')->nullable(); // Abstrak Bahasa Indonesia
            $table->text('abstract_en')->nullable(); // Abstrak Bahasa Inggris
            $table->integer('publication_year');
            // $table->enum('language', ['id', 'en', 'both'])->default('id');
            $table->string('file_path');
            $table->string('file_name');
            $table->integer('file_size'); // dalam KB
            $table->string('file_mime_type');
            $table->integer('download_count')->default(0);
            $table->integer('view_count')->default(0);
            // $table->foreignId('license_id')->constrained('licenses');
            $table->string('doi')->nullable();
            $table->enum('status', ['draft', 'under_review', 'published', 'rejected'])->default('draft');
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
