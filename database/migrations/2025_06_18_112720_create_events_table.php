<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('event_name');
            $table->text('event_description')->nullable();
            $table->enum("event_type", ["Weekend worship service", "weekdays worship service", "volunteer", "meeting", "evangelical"])->default("Weekend worship service");
            $table->date("start_date");
            $table->date("end_date")->nullable();
            $table->time("start_time");
            $table->time("end_time")->nullable();
            $table->string("location");
            $table->foreignId("user_id")
                ->constrained("users")
                ->onDelete("cascade")
                ->onUpdate("cascade");
            $table->integer("number_Volunteer_needed")->nullable();
            $table->enum("status", ["upcoming", "ongoing", "completed", "cancelled"])->default("upcoming");
            $table->boolean("reminder_sent")->default(false);
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
