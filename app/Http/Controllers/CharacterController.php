<?php

namespace App\Http\Controllers;

use App\Http\Requests\Character\StoreCharacterRequest;
use App\Http\Requests\Character\UpdateCharacterVitalsRequest;
use App\Models\Ancestry;
use App\Models\Character;
use App\Models\CharacterClass;
use App\Models\Community;
use App\Models\DomainCard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class CharacterController extends Controller
{
    /**
     * Display a listing of the user's characters.
     */
    public function index(Request $request): Response
    {
        $userId = Auth::id();

        $characters = $userId
            ? Character::where('user_id', $userId)
                ->with(['characterClass', 'ancestry', 'community'])
                ->latest()
                ->get()
            : collect();

        return Inertia::render('Characters/Index', [
            'characters' => $characters,
        ]);
    }

    /**
     * Show the multi-step character creation wizard.
     */
    public function create(): Response
    {
        $classes = CharacterClass::with('subclasses')->get();
        $ancestries = Ancestry::all();
        $communities = Community::all();
        $domainCards = DomainCard::where('level', 1)->get();

        return Inertia::render('Characters/Create', [
            'classes' => $classes,
            'ancestries' => $ancestries,
            'communities' => $communities,
            'domain_cards' => $domainCards,
        ]);
    }

    /**
     * Store a newly created character.
     */
    public function store(StoreCharacterRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $characterClass = CharacterClass::findOrFail($validated['character_class_id']);

        $character = Character::create([
            'user_id' => Auth::id(),
            'character_class_id' => $characterClass->id,
            'subclass_id' => $validated['subclass_id'] ?? null,
            'ancestry_id' => $validated['ancestry_id'],
            'community_id' => $validated['community_id'],

            'name' => $validated['name'],
            'pronouns' => $validated['pronouns'] ?? null,
            'level' => 1,

            'agility' => $validated['agility'],
            'strength' => $validated['strength'],
            'finesse' => $validated['finesse'],
            'instinct' => $validated['instinct'],
            'presence' => $validated['presence'],
            'knowledge' => $validated['knowledge'],

            'hit_points_current' => $characterClass->starting_hit_points,
            'hit_points_max' => $characterClass->starting_hit_points,
            'stress_current' => 0,
            'stress_max' => $characterClass->starting_stress,
            'hope_current' => $characterClass->starting_hope ?? 2,
            'hope_max' => 6,

            'armor_score' => 0,
            'armor_slots_current' => 0,
            'armor_slots_max' => 6,

            'evasion' => $characterClass->starting_evasion,
            'major_threshold' => $characterClass->base_major_threshold,
            'severe_threshold' => $characterClass->base_severe_threshold,

            'background' => $validated['background'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        if (! empty($validated['starting_card_ids'])) {
            foreach ($validated['starting_card_ids'] as $cardId) {
                $character->domainCards()->attach($cardId, ['is_equipped' => true]);
            }
        }

        return redirect()->route('characters.show', $character->id)
            ->with('success', "{$character->name} has been created!");
    }

    /**
     * Display the specified character sheet.
     */
    public function show(Character $character): Response
    {
        $character->load([
            'characterClass.subclasses',
            'subclass',
            'ancestry',
            'community',
            'equippedDomainCards',
            'vaultDomainCards',
        ]);

        return Inertia::render('Characters/Show', [
            'character' => $character,
        ]);
    }

    /**
     * Update real-time vitals (HP, Stress, Hope, Armor, Notes).
     */
    public function updateVitals(UpdateCharacterVitalsRequest $request, Character $character): RedirectResponse
    {
        $character->update($request->validated());

        return back();
    }

    /**
     * Delete a character.
     */
    public function destroy(Character $character): RedirectResponse
    {
        if ($character->user_id && $character->user_id !== Auth::id()) {
            abort(403);
        }

        $character->delete();

        return redirect()->route('characters.index')
            ->with('success', 'Character deleted.');
    }
}
