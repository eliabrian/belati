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
        Schema::create('domain_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('domain')->index(); // Blade, Bone, Codex, Grace, Midnight, Sage, Splendor, Valor, Arcana
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedTinyInteger('level')->default(1)->index();
            $table->string('type')->default('Ability'); // Ability, Spell, Grimoire
            $table->unsignedTinyInteger('recall_cost')->default(0); // Hope cost to recall
            $table->text('description');
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
        Schema::dropIfExists('domain_cards');
    }
};
