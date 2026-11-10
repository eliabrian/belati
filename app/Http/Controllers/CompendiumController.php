<?php

namespace App\Http\Controllers;

use App\Models\Ancestry;
use App\Models\CharacterClass;
use App\Models\Community;
use App\Models\DomainCard;
use Inertia\Inertia;
use Inertia\Response;

class CompendiumController extends Controller
{
    /**
     * Display the SRD compendium browser.
     */
    public function index(): Response
    {
        return Inertia::render('Compendium/Index', [
            'ancestries' => Ancestry::where('is_public', true)
                ->orderBy('name')
                ->get(),
            'communities' => Community::where('is_public', true)
                ->orderBy('name')
                ->get(),
            'classes' => CharacterClass::where('is_public', true)
                ->with(['subclasses' => function ($query) {
                    $query->where('is_public', true)->orderBy('name');
                }])
                ->orderBy('name')
                ->get(),
            'domain_cards' => DomainCard::where('is_public', true)
                ->orderBy('domain')
                ->orderBy('level')
                ->orderBy('name')
                ->get(),
        ]);
    }
}
