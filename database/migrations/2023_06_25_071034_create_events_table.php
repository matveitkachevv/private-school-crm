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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->dateTime('date_start');
            $table->dateTime('date_end');
            $table->string('name');
            $table->string('class');

            // cabinets
            $table->unsignedBigInteger('cabinet_id');
            $table->index('cabinet_id', 'event_cabinet_idx');
            $table->foreign('cabinet_id', 'event_cabinet_fk')->on('cabinets')->references('id');

            // groups
            $table->unsignedBigInteger('group_id');
            $table->index('group_id', 'event_group_idx');
            $table->foreign('group_id', 'event_group_fk')->on('groups')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
};
