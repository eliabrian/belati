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
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('character_class_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subclass_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('ancestry_id')->constrained()->cascadeOnDelete();
            $table->foreignId('community_id')->constrained()->cascadeOnDelete();

            $table->string('name');
            $table->string('pronouns')->nullable();
            $table->unsignedTinyInteger('level')->default(1);

            // 6 Core Traits
            $table->tinyInteger('agility')->default(0);
            $table->tinyInteger('strength')->default(0);
            $table->tinyInteger('finesse')->default(0);
            $table->tinyInteger('instinct')->default(0);
            $table->tinyInteger('presence')->default(0);
            $table->tinyInteger('knowledge')->default(0);

            // Vitals & Combat Stats
            $table->unsignedTinyInteger('hit_points_current')->default(6);
            $table->unsignedTinyInteger('hit_points_max')->default(6);
            $table->unsignedTinyInteger('stress_current')->default(0);
            $table->unsignedTinyInteger('stress_max')->default(6);
            $table->unsignedTinyInteger('hope_current')->default(2);
            $table->unsignedTinyInteger('hope_max')->default(6);

            $table->unsignedTinyInteger('armor_score')->default(0);
            $table->unsignedTinyInteger('armor_slots_current')->default(0);
            $table->unsignedTinyInteger('armor_slots_max')->default(6);

            $table->unsignedTinyInteger('evasion')->default(8);
            $table->unsignedTinyInteger('major_threshold')->default(5);
            $table->unsignedTinyInteger('severe_threshold')->default(10);

            $table->unsignedInteger('gold')->default(0);

            // Background / Notes
            $table->text('background')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_public')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
