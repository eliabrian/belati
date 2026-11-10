<script setup>
import { ref, computed } from 'vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { 
    Shield, 
    Sparkles, 
    ChevronRight, 
    ChevronLeft, 
    Check, 
    Sword, 
    Heart, 
    Flame, 
    User,
    ArrowUpRight,
    HelpCircle
} from 'lucide-vue-next';

const props = defineProps({
    classes: {
        type: Array,
        required: true,
    },
    ancestries: {
        type: Array,
        required: true,
    },
    communities: {
        type: Array,
        required: true,
    },
    domain_cards: {
        type: Array,
        required: true,
    },
});

const currentStep = ref(1);
const totalSteps = 5;

// Standard array values for traits in Daggerheart
const standardArray = [2, 1, 1, 0, 0, -1];
const traitNames = [
    { key: 'agility', label: 'Agility', desc: 'Sprint, leap, dodge, maneuver' },
    { key: 'strength', label: 'Strength', desc: 'Lift, crush, grapple, endurance' },
    { key: 'finesse', label: 'Finesse', desc: 'Precision, stealth, sleight of hand' },
    { key: 'instinct', label: 'Instinct', desc: 'Perception, intuition, survival' },
    { key: 'presence', label: 'Presence', desc: 'Charm, command, inspire, deceive' },
    { key: 'knowledge', label: 'Knowledge', desc: 'Lore, recall, deduce, comprehend' },
];

const form = useForm({
    character_class_id: props.classes[0]?.id || null,
    subclass_id: props.classes[0]?.subclasses[0]?.id || null,
    ancestry_id: props.ancestries[0]?.id || null,
    community_id: props.communities[0]?.id || null,

    // Trait assignments (default mapped from standard array)
    agility: 1,
    strength: 2,
    finesse: 0,
    instinct: 1,
    presence: 0,
    knowledge: -1,

    starting_card_ids: [],
    name: '',
    pronouns: '',
    background: '',
    notes: '',
});

// Domain Colors map
const domainColors = {
    Blade: 'text-red-400 bg-red-500/10 border-red-500/30',
    Bone: 'text-zinc-300 bg-zinc-500/10 border-zinc-500/30',
    Codex: 'text-blue-400 bg-blue-500/10 border-blue-500/30',
    Grace: 'text-emerald-400 bg-emerald-500/10 border-emerald-500/30',
    Midnight: 'text-purple-400 bg-purple-500/10 border-purple-500/30',
    Sage: 'text-amber-400 bg-amber-500/10 border-amber-500/30',
    Splendor: 'text-yellow-300 bg-yellow-500/10 border-yellow-500/30',
    Valor: 'text-orange-400 bg-orange-500/10 border-orange-500/30',
    Arcana: 'text-indigo-400 bg-indigo-500/10 border-indigo-500/30',
};

// Selected objects for reactive display
const selectedClass = computed(() => {
    return props.classes.find(c => c.id === form.character_class_id);
});

const selectedSubclass = computed(() => {
    return selectedClass.value?.subclasses?.find(s => s.id === form.subclass_id);
});

const selectedAncestry = computed(() => {
    return props.ancestries.find(a => a.id === form.ancestry_id);
});

const selectedCommunity = computed(() => {
    return props.communities.find(c => c.id === form.community_id);
});

// Domain cards eligible for starting loadout (Level 1 cards matching selected class's primary domains)
const availableStartingCards = computed(() => {
    if (!selectedClass.value?.primary_domains) return [];
    return props.domain_cards.filter(card => 
        selectedClass.value.primary_domains.includes(card.domain)
    );
});

const selectClass = (charClass) => {
    form.character_class_id = charClass.id;
    form.subclass_id = charClass.subclasses?.[0]?.id || null;
    form.starting_card_ids = []; // reset card picks if class domains changed
};

const toggleCardSelection = (cardId) => {
    const idx = form.starting_card_ids.indexOf(cardId);
    if (idx > -1) {
        form.starting_card_ids.splice(idx, 1);
    } else {
        if (form.starting_card_ids.length < 2) {
            form.starting_card_ids.push(cardId);
        } else {
            // Replace second pick
            form.starting_card_ids[1] = cardId;
        }
    }
};

// Trait array validation: check if assigned values match the standard array exactly
const assignedTraitValues = computed(() => {
    return [
        form.agility,
        form.strength,
        form.finesse,
        form.instinct,
        form.presence,
        form.knowledge,
    ].sort((a, b) => b - a);
});

const isTraitArrayValid = computed(() => {
    const expected = [...standardArray].sort((a, b) => b - a);
    return JSON.stringify(assignedTraitValues.value) === JSON.stringify(expected);
});

// Navigation handlers
const canProceed = computed(() => {
    if (currentStep.value === 1) return !!form.character_class_id;
    if (currentStep.value === 2) return !!form.ancestry_id && !!form.community_id;
    if (currentStep.value === 3) return isTraitArrayValid.value;
    if (currentStep.value === 4) return form.starting_card_ids.length === 2;
    if (currentStep.value === 5) return !!form.name?.trim();
    return false;
});

const nextStep = () => {
    if (canProceed.value && currentStep.value < totalSteps) {
        currentStep.value++;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
};

const prevStep = () => {
    if (currentStep.value > 1) {
        currentStep.value--;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
};

const submit = () => {
    form.post('/characters');
};
</script>

<template>
    <AppLayout>
        <Head title="Create Character — Belati" />

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
            <!-- Breadcrumb / Header -->
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <Link href="/characters" class="text-xs text-slate-400 hover:text-amber-400 transition-colors flex items-center gap-1 mb-1">
                        <ChevronLeft class="w-3.5 h-3.5" />
                        <span>Back to Roster</span>
                    </Link>
                    <h1 class="font-serif text-2xl sm:text-3xl font-bold text-white uppercase tracking-wide">
                        Character Creator
                    </h1>
                </div>

                <div class="text-right">
                    <span class="text-xs font-mono font-bold text-amber-400 uppercase tracking-widest">
                        Step {{ currentStep }} of {{ totalSteps }}
                    </span>
                    <div class="text-xs text-slate-400 hidden sm:block">
                        <span v-if="currentStep === 1">Class & Subclass</span>
                        <span v-else-if="currentStep === 2">Ancestry & Community</span>
                        <span v-else-if="currentStep === 3">Assign Traits</span>
                        <span v-else-if="currentStep === 4">Starting Domain Cards</span>
                        <span v-else-if="currentStep === 5">Name & Background</span>
                    </div>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="w-full bg-slate-900 h-2 rounded-full overflow-hidden border border-slate-800 mb-8">
                <div 
                    class="h-full bg-gradient-to-r from-amber-500 to-amber-300 transition-all duration-300 rounded-full"
                    :style="{ width: `${(currentStep / totalSteps) * 100}%` }"
                ></div>
            </div>

            <form @submit.prevent="submit">

                <!-- ================= STEP 1: CLASS & SUBCLASS ================= -->
                <div v-show="currentStep === 1" class="space-y-6">
                    <div>
                        <h2 class="font-serif text-xl sm:text-2xl font-bold text-amber-100">
                            1. Select Your Class
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-400 mt-1">
                            Your class sets your starting Evasion, Hit Points, Damage Thresholds, and Primary Domains.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div
                            v-for="charClass in classes"
                            :key="charClass.id"
                            @click="selectClass(charClass)"
                            class="p-5 rounded-2xl border transition-all cursor-pointer flex flex-col justify-between"
                            :class="form.character_class_id === charClass.id
                                ? 'bg-amber-500/10 border-amber-500 shadow-lg shadow-amber-500/10 ring-1 ring-amber-500'
                                : 'bg-slate-900/60 border-slate-800 hover:border-slate-700'"
                        >
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="font-serif text-lg font-bold uppercase text-white">
                                        {{ charClass.name }}
                                    </h3>
                                    <div
                                        class="w-5 h-5 rounded-full border flex items-center justify-center transition-colors"
                                        :class="form.character_class_id === charClass.id
                                            ? 'bg-amber-500 border-amber-500 text-slate-950'
                                            : 'border-slate-700'"
                                    >
                                        <Check v-if="form.character_class_id === charClass.id" class="w-3.5 h-3.5 stroke-[3]" />
                                    </div>
                                </div>

                                <div class="flex flex-wrap gap-1.5 mb-3">
                                    <span
                                        v-for="domain in charClass.primary_domains"
                                        :key="domain"
                                        class="text-[11px] font-semibold px-2 py-0.5 rounded border"
                                        :class="domainColors[domain] || 'bg-slate-800 text-slate-300 border-slate-700'"
                                    >
                                        {{ domain }}
                                    </span>
                                </div>

                                <div class="grid grid-cols-3 gap-1 bg-slate-950/80 border border-slate-850 rounded-xl p-2 text-center text-xs">
                                    <div>
                                        <div class="text-[9px] text-slate-400 uppercase font-bold">Evasion</div>
                                        <div class="font-bold text-slate-200">{{ charClass.starting_evasion }}</div>
                                    </div>
                                    <div class="border-l border-slate-850">
                                        <div class="text-[9px] text-slate-400 uppercase font-bold">HP</div>
                                        <div class="font-bold text-emerald-400">{{ charClass.starting_hit_points }}</div>
                                    </div>
                                    <div class="border-l border-slate-850">
                                        <div class="text-[9px] text-slate-400 uppercase font-bold">Thresholds</div>
                                        <div class="font-bold text-amber-300 text-[11px]">
                                            {{ charClass.base_major_threshold }}/{{ charClass.base_severe_threshold }}+
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Subclass Selection -->
                    <div v-if="selectedClass?.subclasses?.length" class="mt-8 pt-6 border-t border-slate-800">
                        <h3 class="font-serif text-lg font-bold text-amber-200 mb-2">
                            Choose Your Subclass
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-400 mb-4">
                            Each subclass provides specialized starting abilities.
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div
                                v-for="sub in selectedClass.subclasses"
                                :key="sub.id"
                                @click="form.subclass_id = sub.id"
                                class="p-5 rounded-2xl border transition-all cursor-pointer"
                                :class="form.subclass_id === sub.id
                                    ? 'bg-amber-500/10 border-amber-500 ring-1 ring-amber-500'
                                    : 'bg-slate-900/60 border-slate-800 hover:border-slate-700'"
                            >
                                <div class="flex items-center justify-between mb-2">
                                    <div class="font-serif font-bold text-base text-white">
                                        {{ sub.name }}
                                    </div>
                                    <div
                                        class="w-5 h-5 rounded-full border flex items-center justify-center"
                                        :class="form.subclass_id === sub.id
                                            ? 'bg-amber-500 border-amber-500 text-slate-950'
                                            : 'border-slate-700'"
                                    >
                                        <Check v-if="form.subclass_id === sub.id" class="w-3.5 h-3.5 stroke-[3]" />
                                    </div>
                                </div>
                                <div class="text-xs font-semibold text-amber-400 mb-1">
                                    {{ sub.foundation_feature_name }}
                                </div>
                                <p class="text-xs text-slate-300 leading-relaxed">
                                    {{ sub.foundation_feature_description }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ================= STEP 2: ANCESTRY & COMMUNITY ================= -->
                <div v-show="currentStep === 2" class="space-y-8">
                    <!-- Ancestry -->
                    <div>
                        <h2 class="font-serif text-xl sm:text-2xl font-bold text-amber-100">
                            2. Choose Ancestry & Community
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-400 mt-1">
                            Your ancestry reflects your biological heritage, while your community reflects where and how you were raised.
                        </p>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <label class="font-serif text-base font-bold text-amber-300 uppercase tracking-wide">
                                Ancestry ({{ ancestries.length }} Options)
                            </label>
                            <span v-if="selectedAncestry" class="text-xs text-slate-400">
                                Selected: <strong class="text-white">{{ selectedAncestry.name }}</strong>
                            </span>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            <button
                                v-for="ancestry in ancestries"
                                :key="ancestry.id"
                                type="button"
                                @click="form.ancestry_id = ancestry.id"
                                class="p-3.5 rounded-xl border text-left transition-all"
                                :class="form.ancestry_id === ancestry.id
                                    ? 'bg-amber-500/15 border-amber-500 text-white font-bold ring-1 ring-amber-500'
                                    : 'bg-slate-900/60 border-slate-800 text-slate-300 hover:border-slate-700'"
                            >
                                <div class="text-sm font-semibold truncate">{{ ancestry.name }}</div>
                                <div class="text-[10px] text-amber-400 truncate mt-0.5" v-if="ancestry.features?.[0]">
                                    {{ ancestry.features[0].name }}
                                </div>
                            </button>
                        </div>

                        <!-- Active Ancestry Details Box -->
                        <div v-if="selectedAncestry" class="bg-slate-950 border border-slate-800 rounded-2xl p-5">
                            <div class="font-serif text-base font-bold text-white mb-1">
                                {{ selectedAncestry.name }} Ancestry Traits
                            </div>
                            <div v-for="feat in selectedAncestry.features" :key="feat.name" class="mt-2">
                                <span class="text-xs font-bold text-amber-400 uppercase tracking-wider">{{ feat.name }}: </span>
                                <span class="text-xs text-slate-300 leading-relaxed">{{ feat.description }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Community -->
                    <div class="space-y-4 pt-4 border-t border-slate-800">
                        <div class="flex items-center justify-between">
                            <label class="font-serif text-base font-bold text-cyan-300 uppercase tracking-wide">
                                Community ({{ communities.length }} Options)
                            </label>
                            <span v-if="selectedCommunity" class="text-xs text-slate-400">
                                Selected: <strong class="text-white">{{ selectedCommunity.name }}</strong>
                            </span>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            <button
                                v-for="community in communities"
                                :key="community.id"
                                type="button"
                                @click="form.community_id = community.id"
                                class="p-3.5 rounded-xl border text-left transition-all"
                                :class="form.community_id === community.id
                                    ? 'bg-cyan-500/15 border-cyan-500 text-white font-bold ring-1 ring-cyan-500'
                                    : 'bg-slate-900/60 border-slate-800 text-slate-300 hover:border-slate-700'"
                            >
                                <div class="text-sm font-semibold truncate">{{ community.name }}</div>
                                <div class="text-[10px] text-cyan-400 truncate mt-0.5" v-if="community.features?.[0]">
                                    {{ community.features[0].name }}
                                </div>
                            </button>
                        </div>

                        <!-- Active Community Details Box -->
                        <div v-if="selectedCommunity" class="bg-slate-950 border border-slate-800 rounded-2xl p-5">
                            <div class="font-serif text-base font-bold text-white mb-1">
                                {{ selectedCommunity.name }} Community Traits
                            </div>
                            <div v-for="feat in selectedCommunity.features" :key="feat.name" class="mt-2">
                                <span class="text-xs font-bold text-cyan-400 uppercase tracking-wider">{{ feat.name }}: </span>
                                <span class="text-xs text-slate-300 leading-relaxed">{{ feat.description }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ================= STEP 3: ASSIGN TRAITS ================= -->
                <div v-show="currentStep === 3" class="space-y-6">
                    <div>
                        <h2 class="font-serif text-xl sm:text-2xl font-bold text-amber-100">
                            3. Assign Starting Traits
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-400 mt-1">
                            Assign Daggerheart's Standard Array: <strong class="text-amber-400">+2, +1, +1, 0, 0, -1</strong> across your 6 core traits.
                        </p>
                    </div>

                    <!-- Validation Banner -->
                    <div
                        class="p-4 rounded-xl border text-xs sm:text-sm flex items-center justify-between"
                        :class="isTraitArrayValid
                            ? 'bg-emerald-500/10 border-emerald-500/30 text-emerald-300'
                            : 'bg-amber-500/10 border-amber-500/30 text-amber-300'"
                    >
                        <div class="flex items-center gap-2">
                            <Sparkles class="w-4 h-4 shrink-0" />
                            <span v-if="isTraitArrayValid">Standard array perfectly allocated!</span>
                            <span v-else>Array must include exactly: +2, +1, +1, 0, 0, -1</span>
                        </div>
                        <span class="font-mono text-xs font-bold">
                            Current: {{ assignedTraitValues.map(v => v > 0 ? `+${v}` : v).join(', ') }}
                        </span>
                    </div>

                    <!-- Traits Selector Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div
                            v-for="trait in traitNames"
                            :key="trait.key"
                            class="bg-slate-900/80 border border-slate-800 rounded-2xl p-5 flex flex-col justify-between"
                        >
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <h3 class="font-serif font-bold text-lg text-white">
                                        {{ trait.label }}
                                    </h3>
                                    <span class="font-serif font-black text-2xl text-amber-400">
                                        {{ form[trait.key] > 0 ? `+${form[trait.key]}` : form[trait.key] }}
                                    </span>
                                </div>
                                <p class="text-xs text-slate-400 mb-4">
                                    {{ trait.desc }}
                                </p>
                            </div>

                            <!-- Selector Buttons -->
                            <div class="grid grid-cols-6 gap-1 pt-3 border-t border-slate-800">
                                <button
                                    v-for="val in [2, 1, 0, -1]"
                                    :key="val"
                                    type="button"
                                    @click="form[trait.key] = val"
                                    class="py-1.5 rounded-lg text-xs font-bold font-mono transition-all"
                                    :class="form[trait.key] === val
                                        ? 'bg-amber-500 text-slate-950 font-black shadow-md shadow-amber-500/20'
                                        : 'bg-slate-950 border border-slate-800 text-slate-300 hover:bg-slate-800'"
                                >
                                    {{ val > 0 ? `+${val}` : val }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ================= STEP 4: STARTING DOMAIN CARDS ================= -->
                <div v-show="currentStep === 4" class="space-y-6">
                    <div>
                        <div class="flex items-center justify-between">
                            <h2 class="font-serif text-xl sm:text-2xl font-bold text-amber-100">
                                4. Select Starting Domain Cards
                            </h2>
                            <span class="text-xs font-mono font-bold px-3 py-1 rounded-full border"
                                :class="form.starting_card_ids.length === 2
                                    ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/30'
                                    : 'bg-amber-500/10 text-amber-400 border-amber-500/30'"
                            >
                                {{ form.starting_card_ids.length }} / 2 Selected
                            </span>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-400 mt-1">
                            Choose 2 Level 1 cards from your primary domains ({{ selectedClass?.primary_domains?.join(' & ') }}).
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div
                            v-for="card in availableStartingCards"
                            :key="card.id"
                            @click="toggleCardSelection(card.id)"
                            class="p-5 rounded-2xl border transition-all cursor-pointer flex flex-col justify-between"
                            :class="form.starting_card_ids.includes(card.id)
                                ? 'bg-amber-500/10 border-amber-500 shadow-lg shadow-amber-500/10 ring-1 ring-amber-500'
                                : 'bg-slate-900/60 border-slate-800 hover:border-slate-700'"
                        >
                            <div>
                                <div class="flex items-center justify-between gap-2 mb-2">
                                    <div class="text-xs font-semibold tracking-wider flex items-center gap-1.5">
                                        <span class="text-slate-400 uppercase">{{ card.type }}</span>
                                        <span class="text-slate-600 font-bold">•</span>
                                        <span :class="domainColors[card.domain] || 'text-amber-400'">{{ card.domain }}</span>
                                    </div>
                                    <div
                                        class="w-5 h-5 rounded-full border flex items-center justify-center shrink-0"
                                        :class="form.starting_card_ids.includes(card.id)
                                            ? 'bg-amber-500 border-amber-500 text-slate-950'
                                            : 'border-slate-700'"
                                    >
                                        <Check v-if="form.starting_card_ids.includes(card.id)" class="w-3.5 h-3.5 stroke-[3]" />
                                    </div>
                                </div>

                                <h3 class="font-serif text-lg font-bold text-white mb-2">
                                    {{ card.name }}
                                </h3>

                                <p class="text-xs text-slate-300 leading-relaxed bg-slate-950/70 p-3 rounded-xl border border-slate-850">
                                    {{ card.description }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ================= STEP 5: NAME & IDENTITY ================= -->
                <div v-show="currentStep === 5" class="space-y-6">
                    <div>
                        <h2 class="font-serif text-xl sm:text-2xl font-bold text-amber-100">
                            5. Identity & Background
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-400 mt-1">
                            Give your hero a name, pronouns, and an optional backstory before stepping into the world.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs uppercase font-bold text-slate-300 mb-1.5">
                                Character Name <span class="text-amber-400">*</span>
                            </label>
                            <input
                                v-model="form.name"
                                type="text"
                                placeholder="e.g. Vaelin Shadowstep, Lyra Thorn"
                                required
                                class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-sm text-white focus:border-amber-500 focus:ring-1 focus:ring-amber-500"
                            />
                        </div>

                        <div>
                            <label class="block text-xs uppercase font-bold text-slate-300 mb-1.5">
                                Pronouns (Optional)
                            </label>
                            <input
                                v-model="form.pronouns"
                                type="text"
                                placeholder="e.g. they/them, she/her, he/him"
                                class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-sm text-white focus:border-amber-500 focus:ring-1 focus:ring-amber-500"
                            />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs uppercase font-bold text-slate-300 mb-1.5">
                            Background & Story (Optional)
                        </label>
                        <textarea
                            v-model="form.background"
                            rows="4"
                            placeholder="What drives your adventurer? What oaths have they sworn or debts must they pay?"
                            class="w-full bg-slate-900 border border-slate-800 rounded-xl p-4 text-sm text-white focus:border-amber-500 focus:ring-1 focus:ring-amber-500"
                        ></textarea>
                    </div>

                    <!-- Summary Review Card -->
                    <div class="bg-slate-950 border border-slate-800 rounded-2xl p-6 space-y-4">
                        <h3 class="font-serif text-base font-bold text-amber-400 uppercase tracking-widest">
                            Hero Summary
                        </h3>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs">
                            <div>
                                <span class="text-slate-400 uppercase font-bold block mb-0.5">Class</span>
                                <span class="text-white font-serif font-bold text-sm">{{ selectedClass?.name }} ({{ selectedSubclass?.name }})</span>
                            </div>
                            <div>
                                <span class="text-slate-400 uppercase font-bold block mb-0.5">Ancestry</span>
                                <span class="text-white font-serif font-bold text-sm">{{ selectedAncestry?.name }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 uppercase font-bold block mb-0.5">Community</span>
                                <span class="text-white font-serif font-bold text-sm">{{ selectedCommunity?.name }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 uppercase font-bold block mb-0.5">Evasion / HP</span>
                                <span class="text-emerald-400 font-serif font-bold text-sm">
                                    {{ selectedClass?.starting_evasion }} Evasion / {{ selectedClass?.starting_hit_points }} HP
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Navigation Buttons -->
                <div class="mt-8 pt-5 border-t border-slate-800 flex items-center justify-between">
                    <button
                        v-if="currentStep > 1"
                        type="button"
                        @click="prevStep"
                        class="px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 border border-slate-800 text-slate-300 text-sm font-semibold flex items-center gap-1.5 transition-colors"
                    >
                        <ChevronLeft class="w-4 h-4" />
                        <span>Previous</span>
                    </button>
                    <div v-else></div>

                    <button
                        v-if="currentStep < totalSteps"
                        type="button"
                        @click="nextStep"
                        :disabled="!canProceed"
                        class="px-6 py-2.5 rounded-xl font-bold text-sm flex items-center gap-1.5 transition-all shadow-md shadow-amber-500/20"
                        :class="canProceed
                            ? 'bg-amber-500 hover:bg-amber-400 text-slate-950 cursor-pointer'
                            : 'bg-slate-800 text-slate-500 cursor-not-allowed'"
                    >
                        <span>Next Step</span>
                        <ChevronRight class="w-4 h-4" />
                    </button>

                    <button
                        v-else
                        type="submit"
                        :disabled="!canProceed || form.processing"
                        class="px-7 py-3 rounded-xl font-bold text-sm flex items-center gap-2 transition-all shadow-xl shadow-amber-500/25"
                        :class="canProceed && !form.processing
                            ? 'bg-amber-500 hover:bg-amber-400 text-slate-950 cursor-pointer hover:-translate-y-0.5'
                            : 'bg-slate-800 text-slate-500 cursor-not-allowed'"
                    >
                        <Sword class="w-4 h-4" />
                        <span>Forge Hero & View Sheet</span>
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

