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
        Schema::create('task_submissions', function (Blueprint $table) {

    $table->id();


    $table->foreignId('task_id')
          ->constrained()
          ->cascadeOnDelete();


    $table->foreignId('student_id')
          ->constrained()
          ->cascadeOnDelete();


    $table->enum('status',[
        'pending',
        'submitted',
        'graded',
        'late'
    ])
    ->default('pending');


    $table->dateTime('submitted_at')
          ->nullable();


    $table->string('file')
          ->nullable();


    $table->text('teacher_feedback')
          ->nullable();


    $table->timestamps();


    $table->unique([
        'task_id',
        'student_id'
    ]);

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_submissions');
    }
};
