<?php

use App\Models\Ancestry;
use App\Models\CharacterClass;
use App\Models\Community;
use App\Models\DomainCard;
use App\Models\Subclass;
use App\Models\User;

test('compendium screen can be rendered with seeded data', function () {
    $class = CharacterClass::factory()->create([
        'name' => 'Warrior',
    ]);
    Subclass::factory()->create([
        'character_class_id' => $class->id,
        'name' => 'Juggernaut',
    ]);
    Ancestry::factory()->create([
        'name' => 'Clank',
    ]);
    Community::factory()->create([
        'name' => 'Highborne',
    ]);
    DomainCard::factory()->create([
        'domain' => 'Blade',
        'name' => 'Whirlwind Strike',
    ]);

    $response = $this->get('/compendium');

    $response->assertStatus(200);
});

test('authenticated users can also access the compendium', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/compendium');

    $response->assertStatus(200);
});
