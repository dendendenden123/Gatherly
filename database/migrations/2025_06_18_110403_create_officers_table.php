<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('officers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            // Role identifiers: 0=None, 1=Minister, 2=Head Deacon, 3=deacon, 4=deaconess, 5=Choir, 6=Secretary, 7=Finance, 8=SCAN, 9=Overseer
            $table->enum('role', [0, 1, 2, 3, 4, 5, 6, 7, 8, 9])->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('officers');
    }
};
