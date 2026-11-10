<?php

use App\Models\Ancestry;
use App\Models\Character;
use App\Models\CharacterClass;
use App\Models\Community;
use App\Models\DomainCard;
use App\Models\Subclass;
use App\Models\User;

test('character can be created with factory and has expected relations', function () {
    $character = Character::factory()->create([
        'name' => 'Kaelen Swiftwind',
    ]);

    expect($character->name)->toBe('Kaelen Swiftwind')
        ->and($character->user)->toBeInstanceOf(User::class)
        ->and($character->characterClass)->toBeInstanceOf(CharacterClass::class)
        ->and($character->subclass)->toBeInstanceOf(Subclass::class)
        ->and($character->ancestry)->toBeInstanceOf(Ancestry::class)
        ->and($character->community)->toBeInstanceOf(Community::class)
        ->and($character->level)->toBe(1)
        ->and($character->hit_points_current)->toBe(6)
        ->and($character->hit_points_max)->toBe(6);
});

test('character can equip and vault domain cards', function () {
    $character = Character::factory()->create();
    $card1 = DomainCard::factory()->create(['name' => 'Card In Loadout']);
    $card2 = DomainCard::factory()->create(['name' => 'Card In Vault']);

    // Attach card 1 as equipped, card 2 as vault
    $character->domainCards()->attach($card1->id, ['is_equipped' => true]);
    $character->domainCards()->attach($card2->id, ['is_equipped' => false]);

    expect($character->domainCards)->toHaveCount(2)
        ->and($character->equippedDomainCards)->toHaveCount(1)
        ->and($character->equippedDomainCards->first()->name)->toBe('Card In Loadout')
        ->and($character->vaultDomainCards)->toHaveCount(1)
        ->and($character->vaultDomainCards->first()->name)->toBe('Card In Vault');
});

test('character can exist without an authenticated user for guest mode', function () {
    $charClass = CharacterClass::factory()->create();
    $ancestry = Ancestry::factory()->create();
    $community = Community::factory()->create();

    $guestChar = Character::create([
        'user_id' => null,
        'character_class_id' => $charClass->id,
        'ancestry_id' => $ancestry->id,
        'community_id' => $community->id,
        'name' => 'Wandering Guest',
        'agility' => 2,
        'strength' => 1,
        'finesse' => 1,
        'instinct' => 0,
        'presence' => 0,
        'knowledge' => -1,
        'hit_points_current' => 6,
        'hit_points_max' => 6,
        'stress_current' => 0,
        'stress_max' => 6,
        'hope_current' => 2,
        'hope_max' => 6,
        'evasion' => 10,
        'major_threshold' => 5,
        'severe_threshold' => 10,
    ]);

    expect($guestChar->user_id)->toBeNull()
        ->and($guestChar->user)->toBeNull()
        ->and($guestChar->name)->toBe('Wandering Guest');
});
