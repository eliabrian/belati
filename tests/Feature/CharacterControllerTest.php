<?php

use App\Models\Ancestry;
use App\Models\Character;
use App\Models\CharacterClass;
use App\Models\Community;
use App\Models\DomainCard;
use App\Models\Subclass;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

test('character creation page can be rendered with srd options', function () {
    CharacterClass::factory()->create();
    Ancestry::factory()->create();
    Community::factory()->create();
    DomainCard::factory()->create(['level' => 1]);

    $response = $this->get(route('characters.create'));

    $response->assertStatus(200);
    $response->assertInertia(fn (Assert $page) => $page
        ->component('Characters/Create')
        ->has('classes')
        ->has('ancestries')
        ->has('communities')
        ->has('domain_cards')
    );
});

test('a user can create a character via the wizard', function () {
    $user = User::factory()->create();
    $class = CharacterClass::factory()->create([
        'starting_hit_points' => 7,
        'starting_stress' => 6,
        'starting_evasion' => 8,
        'base_major_threshold' => 7,
        'base_severe_threshold' => 13,
    ]);
    $subclass = Subclass::factory()->create(['character_class_id' => $class->id]);
    $ancestry = Ancestry::factory()->create();
    $community = Community::factory()->create();
    $card1 = DomainCard::factory()->create(['level' => 1]);
    $card2 = DomainCard::factory()->create(['level' => 1]);

    $response = $this->actingAs($user)->post(route('characters.store'), [
        'name' => 'Seraphina Ironheart',
        'pronouns' => 'she/her',
        'character_class_id' => $class->id,
        'subclass_id' => $subclass->id,
        'ancestry_id' => $ancestry->id,
        'community_id' => $community->id,
        'agility' => 1,
        'strength' => 2,
        'finesse' => 0,
        'instinct' => 1,
        'presence' => 0,
        'knowledge' => -1,
        'starting_card_ids' => [$card1->id, $card2->id],
        'background' => 'A brave guardian from the borderlands.',
    ]);

    $character = Character::where('name', 'Seraphina Ironheart')->first();

    expect($character)->not->toBeNull()
        ->and($character->user_id)->toBe($user->id)
        ->and($character->hit_points_max)->toBe(7)
        ->and($character->hit_points_current)->toBe(7)
        ->and($character->evasion)->toBe(8)
        ->and($character->major_threshold)->toBe(7)
        ->and($character->severe_threshold)->toBe(13)
        ->and($character->equippedDomainCards)->toHaveCount(2);

    $response->assertRedirect(route('characters.show', $character->id));
});

test('character sheet can be viewed', function () {
    $character = Character::factory()->create();

    $response = $this->get(route('characters.show', $character->id));

    $response->assertStatus(200);
    $response->assertInertia(fn (Assert $page) => $page
        ->component('Characters/Show')
        ->has('character')
    );
});

test('character vitals can be updated in real-time', function () {
    $character = Character::factory()->create([
        'hit_points_current' => 6,
        'stress_current' => 0,
        'hope_current' => 2,
    ]);

    $response = $this->patch(route('characters.vitals.update', $character->id), [
        'hit_points_current' => 4,
        'stress_current' => 2,
        'hope_current' => 3,
        'armor_slots_current' => 1,
    ]);

    $response->assertSessionHasNoErrors();
    $character->refresh();

    expect($character->hit_points_current)->toBe(4)
        ->and($character->stress_current)->toBe(2)
        ->and($character->hope_current)->toBe(3)
        ->and($character->armor_slots_current)->toBe(1);
});

test('character can be deleted', function () {
    $user = User::factory()->create();
    $character = Character::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->delete(route('characters.destroy', $character->id));

    $response->assertRedirect(route('characters.index'));
    expect(Character::find($character->id))->toBeNull();
});
