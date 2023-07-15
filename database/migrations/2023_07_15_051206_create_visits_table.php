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
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->dateTime('date_visit');
            $table->boolean('visited');

            // subscribes
            $table->unsignedBigInteger('subscribe_id')->nullable();
            $table->index('subscribe_id', 'visit_subscribe_idx');
            $table->foreign('subscribe_id', 'visit_subscribe_fk')->on('subscribes')->references('id')->cascadeOnUpdate()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visits');
    }
};
