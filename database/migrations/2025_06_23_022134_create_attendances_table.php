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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('event_id')->constrained()->onDelete('cascade')->onUpdate('cascade')->nullable();
            $table->date("service_date");
            $table->time("check_in_time");
            $table->time("check_out_time")->nullable();
            $table->enum('attendance_method', ['in-person', 'online', 'fingerprint', 'mobile'])->default('fingerprint');
            $table->string('biometric_data_id')->nullable();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('status', ['present', 'absent'])->default('absent');
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
