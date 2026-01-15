<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_gamifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('total_xp')->default(0);     
            $table->integer('today_xp')->default(0);
            $table->date('last_played_date')->nullable();
            $table->integer('current_level')->default(1);
            $table->integer('gold')->default(0);
            $table->integer('break_tokens')->default(0);
            $table->integer('current_streak')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_gamifications');
    }
};
