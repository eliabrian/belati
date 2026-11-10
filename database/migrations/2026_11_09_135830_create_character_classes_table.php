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
        Schema::create('character_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->json('primary_domains');
            $table->unsignedTinyInteger('starting_evasion')->default(8);
            $table->unsignedTinyInteger('starting_hit_points')->default(6);
            $table->unsignedTinyInteger('starting_stress')->default(6);
            $table->unsignedTinyInteger('starting_hope')->default(2);
            $table->unsignedTinyInteger('base_major_threshold')->default(5);
            $table->unsignedTinyInteger('base_severe_threshold')->default(10);
            $table->string('class_feature_name');
            $table->text('class_feature_description');
            $table->string('hope_feature_name');
            $table->text('hope_feature_description');
            $table->boolean('is_srd')->default(true);
            $table->boolean('is_public')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('character_classes');
    }
};
