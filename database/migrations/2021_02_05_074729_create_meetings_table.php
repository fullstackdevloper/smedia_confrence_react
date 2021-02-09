<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->string('guid');
            $table->string('meeting_id');
            $table->integer('host');
            $table->string('title');
            $table->string('description');
            $table->string('start_time');
            $table->string('meeting_duration');
            $table->integer('participant_count');
            $table->timestamp('original_start_time')->nullable();
            $table->timestamp('original_end_time')->nullable();
            $table->boolean('is_started')->default(0);
            $table->boolean('is_ended')->default(0);
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
        Schema::dropIfExists('meetings');
    }
}
