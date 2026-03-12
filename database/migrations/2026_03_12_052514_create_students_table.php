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
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name')->nullable();

            $table->date('date_of_birth');
            $table->string('sex');

            $table->string('email');
            $table->string('mobile_number');
            $table->string('address');

            $table->string('school_name');
            $table->string('course');
            $table->integer('year_level');

            $table->string('father_name');
            $table->string('mother_name');
            $table->string('parent_occupation');
            $table->decimal('parents_gross_income',10,2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
