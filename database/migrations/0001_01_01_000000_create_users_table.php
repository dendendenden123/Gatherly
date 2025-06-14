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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->enum('role', ['Finance', 'SCAN', 'Deacon', 'Kalihim', 'Choir', "None"])->required();
            $table->string('first_name')->required();
            $table->string('last_name')->required();
            $table->string('middle_name')->required();
            $table->string('email')->unique()->required();
            $table->string('password')->required();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->date('birthdate')->nullable();
            $table->enum('sex', ['male', 'female'])->nullable();
            $table->date('baptism_date')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('profile_image')->default('https://upload.wikimedia.org/wikipedia/commons/a/ac/Default_pfp.jpg')->nullable();
            $table->string('document_image')->nullable();
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->boolean('is_Verify')->default(false);
            $table->boolean('email_verified')->default(false);
            $table->timestamp('last_login_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
