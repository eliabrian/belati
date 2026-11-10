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
        Schema::create('subclasses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('character_class_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('spellcast_trait')->nullable();
            $table->string('foundation_feature_name');
            $table->text('foundation_feature_description');
            $table->string('specialization_feature_name')->nullable();
            $table->text('specialization_feature_description')->nullable();
            $table->string('mastery_feature_name')->nullable();
            $table->text('mastery_feature_description')->nullable();
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
        Schema::dropIfExists('subclasses');
    }
};
