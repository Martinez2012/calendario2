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
        Schema::create('student_grades', function (Blueprint $table) {

    $table->id();


    $table->foreignId('student_id')
          ->constrained()
          ->cascadeOnDelete();


    $table->foreignId('task_submission_id')
          ->nullable()
          ->constrained()
          ->cascadeOnDelete();


    $table->decimal('score',5,2);


    $table->text('observations')
          ->nullable();


    $table->timestamps();

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_grades');
    }
};
