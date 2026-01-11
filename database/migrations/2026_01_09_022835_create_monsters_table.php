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
        Schema::create('monsters', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->integer('base_hp')->default(100);
            $table->integer('attack_interval_ms')->default(3000);
            $table->integer('damage_per_hit')->default(10);
            $table->integer('exp_reward')->default(50);
            $table->integer('gold_reward')->default(20);
            $table->string('asset_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monsters');
    }
};
