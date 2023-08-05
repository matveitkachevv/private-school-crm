<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_students', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('student_id');

            $table->index('group_id', 'group_student_group_idx');
            $table->index('student_id', 'group_student_student_idx');

            $table->foreign('group_id', 'group_student_group_fk')->on('groups')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('student_id', 'group_student_student_fk')->on('students')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_students');
    }
};
