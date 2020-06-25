<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMinutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('minutes', function (Blueprint $table) {
            $table->id();
            $table->string('agenda');
            $table->unsignedBigInteger('study_id')->nullable();
            $table->unsignedBigInteger('lecturer_id');
            $table->unsignedBigInteger('meeting_id');
            $table->unsignedBigInteger('room_id');
            $table->date('meeting_date');
            $table->time('start_at');
            $table->time('end_at');
            $table->longText('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('minutes');
    }
}
