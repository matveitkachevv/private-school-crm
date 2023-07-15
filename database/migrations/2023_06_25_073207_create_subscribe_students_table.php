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
        Schema::create('subscribe_students', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('subscribe_id');
            $table->unsignedBigInteger('student_id');

            $table->index('subscribe_id', 'subscribe_student_subscribe_idx');
            $table->index('student_id', 'subscribe_student_student_idx');

            $table->foreign('subscribe_id', 'subscribe_student_subscribe_fk')->on('subscribes')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('student_id', 'subscribe_student_student_fk')->on('students')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscribe_students');
    }
};
