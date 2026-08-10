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
       Schema::create('events', function (Blueprint $table) {

    $table->id();


    $table->string('title');


    $table->text('description')
          ->nullable();


    $table->enum('type',[
        'holiday',
        'exam',
        'meeting',
        'activity'
    ]);


    $table->dateTime('start');


    $table->dateTime('end');


    $table->foreignId('group_id')
          ->nullable()
          ->constrained()
          ->nullOnDelete();


    $table->foreignId('teacher_subject_group_id')
          ->nullable()
          ->constrained()
          ->nullOnDelete();


    $table->timestamps();

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
