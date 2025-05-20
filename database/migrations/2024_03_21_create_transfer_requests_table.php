<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transfer_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->string('current_institution');
            $table->string('current_formation');
            $table->string('current_year');
            $table->decimal('average_grade', 4, 2);
            $table->string('specialization');
            $table->text('projects')->nullable();
            $table->text('motivation');
            $table->text('career_plan');
            $table->string('desired_formation');
            $table->text('technical_skills')->nullable();
            $table->json('languages')->nullable();
            $table->string('transcript_path')->nullable();
            $table->string('cv_path')->nullable();
            $table->string('motivation_letter_path')->nullable();
            $table->string('id_document_path')->nullable();
            $table->json('certificates_paths')->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamp('request_date')->useCurrent();
            $table->timestamp('approval_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transfer_requests');
    }
}; 