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
        Schema::create('subscribes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->integer('price');
            $table->integer('count');
            $table->date('date_end');
            $table->boolean('payment')->default(true);

            // groups
            $table->unsignedBigInteger('group_id')->nullable();
            $table->index('group_id', 'subscribe_group_idx');
            $table->foreign('group_id', 'subscribe_group_fk')->on('subscribes')->references('id')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscribes');
    }
};
