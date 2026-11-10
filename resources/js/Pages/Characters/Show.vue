<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { 
    ChevronLeft, 
    Heart, 
    Flame, 
    Shield, 
    Sparkles, 
    Dices, 
    Plus, 
    Minus, 
    Check, 
    RefreshCw,
    X,
    Save
} from 'lucide-vue-next';

const props = defineProps({
    character: {
        type: Object,
        required: true,
    },
});

// Local reactive vitals for instant UI response before server sync
const localHp = ref(props.character.hit_points_current);
const localStress = ref(props.character.stress_current);
const localHope = ref(props.character.hope_current);
const localArmor = ref(props.character.armor_slots_current);
const localNotes = ref(props.character.notes || '');
const notesSaved = ref(false);

const updateVitalsOnServer = () => {
    router.patch(`/characters/${props.character.id}/vitals`, {
        hit_points_current: localHp.value,
        stress_current: localStress.value,
        hope_current: localHope.value,
        armor_slots_current: localArmor.value,
    }, {
        preserveScroll: true,
        preserveState: true,
    });
};

const adjustHp = (delta) => {
    const next = Math.max(0, Math.min(props.character.hit_points_max, localHp.value + delta));
    localHp.value = next;
    updateVitalsOnServer();
};

const setHp = (val) => {
    localHp.value = Math.max(0, Math.min(props.character.hit_points_max, val));
    updateVitalsOnServer();
};

const adjustStress = (delta) => {
    const next = Math.max(0, Math.min(props.character.stress_max, localStress.value + delta));
    localStress.value = next;
    updateVitalsOnServer();
};

const setStress = (val) => {
    localStress.value = Math.max(0, Math.min(props.character.stress_max, val));
    updateVitalsOnServer();
};

const adjustHope = (delta) => {
    const next = Math.max(0, Math.min(props.character.hope_max, localHope.value + delta));
    localHope.value = next;
    updateVitalsOnServer();
};

const setHope = (val) => {
    localHope.value = Math.max(0, Math.min(props.character.hope_max, val));
    updateVitalsOnServer();
};

const adjustArmor = (delta) => {
    const next = Math.max(0, Math.min(props.character.armor_slots_max, localArmor.value + delta));
    localArmor.value = next;
    updateVitalsOnServer();
};

const setArmor = (val) => {
    localArmor.value = Math.max(0, Math.min(props.character.armor_slots_max, val));
    updateVitalsOnServer();
};

const saveNotes = () => {
    router.patch(`/characters/${props.character.id}/vitals`, {
        notes: localNotes.value,
    }, {
        preserveScroll: true,
        onSuccess: () => {
            notesSaved.value = true;
            setTimeout(() => { notesSaved.value = false; }, 2000);
        },
    });
};

// Duality Dice Roller State
const activeRoll = ref(null); // { traitName, mod, hopeDie, fearDie, total, outcome, isCrit }
const isRolling = ref(false);

const rollTrait = (traitName, mod) => {
    isRolling.value = true;
    activeRoll.value = null;

    setTimeout(() => {
        const hopeDie = Math.floor(Math.random() * 12) + 1;
        const fearDie = Math.floor(Math.random() * 12) + 1;
        const isCrit = hopeDie === fearDie;
        const total = hopeDie + fearDie + mod;

        let outcome = 'fear';
        if (isCrit) {
            outcome = 'critical';
        } else if (hopeDie > fearDie) {
            outcome = 'hope';
        }

        activeRoll.value = {
            traitName,
            mod,
            hopeDie,
            fearDie,
            total,
            outcome,
            isCrit,
        };
        isRolling.value = false;
    }, 350);
};

// Domain Colors Map
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

const traitsList = [
    { key: 'agility', label: 'Agility' },
    { key: 'strength', label: 'Strength' },
    { key: 'finesse', label: 'Finesse' },
    { key: 'instinct', label: 'Instinct' },
    { key: 'presence', label: 'Presence' },
    { key: 'knowledge', label: 'Knowledge' },
];
</script>

<template>
    <AppLayout>
        <Head :title="`${character.name} — Belati Sheet`" />

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 space-y-6">

            <!-- Sheet Header -->
            <div class="bg-slate-900/80 border border-slate-800 rounded-3xl p-6 sm:p-7 relative overflow-hidden shadow-xl">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <Link href="/characters" class="text-xs text-slate-400 hover:text-amber-400 transition-colors flex items-center gap-1 mb-2">
                            <ChevronLeft class="w-3.5 h-3.5" />
                            <span>Return to Roster</span>
                        </Link>
                        
                        <div class="flex flex-wrap items-baseline gap-3">
                            <h1 class="font-serif text-3xl sm:text-4xl font-extrabold text-white tracking-wide">
                                {{ character.name }}
                            </h1>
                            <span v-if="character.pronouns" class="text-xs text-slate-400 font-mono">
                                ({{ character.pronouns }})
                            </span>
                            <span class="text-xs font-mono font-bold px-2.5 py-0.5 rounded-full bg-amber-500/15 text-amber-400 border border-amber-500/30">
                                Level {{ character.level }}
                            </span>
                        </div>

                        <!-- Class, Ancestry, Community line -->
                        <div class="flex flex-wrap items-center gap-2 mt-3 text-xs sm:text-sm">
                            <span class="font-serif font-bold text-amber-400 uppercase tracking-wide">
                                {{ character.character_class?.name }}
                            </span>
                            <span v-if="character.subclass" class="text-slate-500">•</span>
                            <span v-if="character.subclass" class="text-slate-300 font-medium">
                                {{ character.subclass?.name }}
                            </span>
                            <span class="text-slate-500">•</span>
                            <span class="text-slate-300">
                                {{ character.ancestry?.name }} Ancestry
                            </span>
                            <span class="text-slate-500">•</span>
                            <span class="text-slate-300">
                                {{ character.community?.name }} Community
                            </span>
                        </div>
                    </div>

                    <!-- Domains -->
                    <div class="flex flex-wrap gap-2">
                        <span
                            v-for="domain in character.character_class?.primary_domains"
                            :key="domain"
                            class="text-xs font-semibold px-3 py-1 rounded-full border uppercase tracking-wider"
                            :class="domainColors[domain] || 'bg-slate-800 text-slate-300 border-slate-700'"
                        >
                            {{ domain }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- ================= DUALITY DICE ROLLER POPUP / BANNER ================= -->
            <div
                v-if="activeRoll"
                class="bg-slate-900 border-2 rounded-3xl p-6 sm:p-7 shadow-2xl relative transition-all animate-fade-in"
                :class="activeRoll.outcome === 'hope' 
                    ? 'border-amber-500/80 shadow-amber-500/15' 
                    : activeRoll.outcome === 'critical' 
                        ? 'border-emerald-400 shadow-emerald-500/20' 
                        : 'border-purple-500/80 shadow-purple-500/15'"
            >
                <button
                    @click="activeRoll = null"
                    class="absolute right-4 top-4 text-slate-500 hover:text-white p-1 rounded-lg"
                >
                    <X class="w-5 h-5" />
                </button>

                <div class="text-center max-w-md mx-auto">
                    <div class="text-xs uppercase font-bold tracking-widest text-slate-400 mb-2">
                        Duality Roll: {{ activeRoll.traitName }} ({{ activeRoll.mod > 0 ? `+${activeRoll.mod}` : activeRoll.mod }})
                    </div>

                    <div class="flex items-center justify-center gap-6 my-4">
                        <!-- Hope Die -->
                        <div class="text-center">
                            <div class="w-16 h-16 rounded-2xl bg-amber-500/15 border-2 border-amber-500 flex items-center justify-center font-serif text-3xl font-black text-amber-300 shadow-lg shadow-amber-500/20">
                                {{ activeRoll.hopeDie }}
                            </div>
                            <div class="text-[11px] uppercase font-bold text-amber-400 mt-1">Hope (d12)</div>
                        </div>

                        <div class="font-serif font-black text-2xl text-slate-600">vs</div>

                        <!-- Fear Die -->
                        <div class="text-center">
                            <div class="w-16 h-16 rounded-2xl bg-purple-500/15 border-2 border-purple-500 flex items-center justify-center font-serif text-3xl font-black text-purple-300 shadow-lg shadow-purple-500/20">
                                {{ activeRoll.fearDie }}
                            </div>
                            <div class="text-[11px] uppercase font-bold text-purple-400 mt-1">Fear (d12)</div>
                        </div>
                    </div>

                    <!-- Total Score -->
                    <div class="font-serif text-4xl font-extrabold text-white mb-2">
                        Total: {{ activeRoll.total }}
                    </div>

                    <!-- Outcome Message -->
                    <div
                        v-if="activeRoll.outcome === 'critical'"
                        class="p-3 rounded-xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-300 text-xs sm:text-sm font-bold"
                    >
                        ✨ CRITICAL SUCCESS! Both dice matched! Clear 1 Stress and gain 1 Hope!
                    </div>
                    <div
                        v-else-if="activeRoll.outcome === 'hope'"
                        class="p-3 rounded-xl bg-amber-500/15 border border-amber-500/30 text-amber-300 text-xs sm:text-sm font-bold"
                    >
                        ☀️ SUCCESS WITH HOPE! Gain 1 Hope or help an ally.
                    </div>
                    <div
                        v-else
                        class="p-3 rounded-xl bg-purple-500/15 border border-purple-500/30 text-purple-300 text-xs sm:text-sm font-bold"
                    >
                        🌑 SUCCESS WITH FEAR! The GM gains 1 Fear token or introduces a complication.
                    </div>
                </div>
            </div>

            <!-- ================= VITALS PIP TRACKERS ================= -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                <!-- HIT POINTS -->
                <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-5 flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2">
                            <Heart class="w-4 h-4 text-emerald-400" />
                            <span class="font-serif text-sm font-bold uppercase tracking-wider text-white">Hit Points</span>
                        </div>
                        <span class="font-mono text-xs font-bold text-emerald-400">
                            {{ localHp }} / {{ character.hit_points_max }}
                        </span>
                    </div>

                    <!-- Pips -->
                    <div class="flex flex-wrap gap-1.5 my-3">
                        <button
                            v-for="i in character.hit_points_max"
                            :key="i"
                            type="button"
                            @click="setHp(i === localHp ? i - 1 : i)"
                            class="w-6 h-6 rounded-lg border transition-all flex items-center justify-center"
                            :class="i <= localHp 
                                ? 'bg-emerald-500 border-emerald-400 text-slate-950 shadow-sm shadow-emerald-500/30' 
                                : 'bg-slate-950 border-slate-800 hover:border-slate-700'"
                        >
                            <span v-if="i <= localHp" class="text-[10px] font-bold">✓</span>
                        </button>
                    </div>

                    <div class="flex items-center justify-between pt-3 border-t border-slate-850">
                        <span class="text-[11px] text-slate-400">Damage Tracker</span>
                        <div class="flex items-center gap-1.5">
                            <button
                                @click="adjustHp(-1)"
                                class="w-7 h-7 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 flex items-center justify-center"
                            >
                                <Minus class="w-3.5 h-3.5" />
                            </button>
                            <button
                                @click="adjustHp(1)"
                                class="w-7 h-7 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 flex items-center justify-center"
                            >
                                <Plus class="w-3.5 h-3.5" />
                            </button>
                        </div>
                    </div>
                </div>

                <!-- STRESS -->
                <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-5 flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2">
                            <Sparkles class="w-4 h-4 text-purple-400" />
                            <span class="font-serif text-sm font-bold uppercase tracking-wider text-white">Stress</span>
                        </div>
                        <span class="font-mono text-xs font-bold text-purple-400">
                            {{ localStress }} / {{ character.stress_max }}
                        </span>
                    </div>

                    <!-- Pips -->
                    <div class="flex flex-wrap gap-1.5 my-3">
                        <button
                            v-for="i in character.stress_max"
                            :key="i"
                            type="button"
                            @click="setStress(i === localStress ? i - 1 : i)"
                            class="w-6 h-6 rounded-lg border transition-all flex items-center justify-center"
                            :class="i <= localStress 
                                ? 'bg-purple-500 border-purple-400 text-slate-950 shadow-sm shadow-purple-500/30' 
                                : 'bg-slate-950 border-slate-800 hover:border-slate-700'"
                        >
                            <span v-if="i <= localStress" class="text-[10px] font-bold">✕</span>
                        </button>
                    </div>

                    <div class="flex items-center justify-between pt-3 border-t border-slate-850">
                        <span class="text-[11px] text-slate-400">Push & Strain</span>
                        <div class="flex items-center gap-1.5">
                            <button
                                @click="adjustStress(-1)"
                                class="w-7 h-7 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 flex items-center justify-center"
                            >
                                <Minus class="w-3.5 h-3.5" />
                            </button>
                            <button
                                @click="adjustStress(1)"
                                class="w-7 h-7 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 flex items-center justify-center"
                            >
                                <Plus class="w-3.5 h-3.5" />
                            </button>
                        </div>
                    </div>
                </div>

                <!-- HOPE -->
                <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-5 flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2">
                            <Flame class="w-4 h-4 text-amber-400" />
                            <span class="font-serif text-sm font-bold uppercase tracking-wider text-white">Hope</span>
                        </div>
                        <span class="font-mono text-xs font-bold text-amber-400">
                            {{ localHope }} / {{ character.hope_max }}
                        </span>
                    </div>

                    <!-- Pips -->
                    <div class="flex flex-wrap gap-1.5 my-3">
                        <button
                            v-for="i in character.hope_max"
                            :key="i"
                            type="button"
                            @click="setHope(i === localHope ? i - 1 : i)"
                            class="w-6 h-6 rounded-lg border transition-all flex items-center justify-center"
                            :class="i <= localHope 
                                ? 'bg-amber-400 border-amber-300 text-slate-950 shadow-sm shadow-amber-400/30' 
                                : 'bg-slate-950 border-slate-800 hover:border-slate-700'"
                        >
                            <span v-if="i <= localHope" class="text-[10px] font-bold">★</span>
                        </button>
                    </div>

                    <div class="flex items-center justify-between pt-3 border-t border-slate-850">
                        <span class="text-[11px] text-slate-400">Class Fuel</span>
                        <div class="flex items-center gap-1.5">
                            <button
                                @click="adjustHope(-1)"
                                class="w-7 h-7 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 flex items-center justify-center"
                            >
                                <Minus class="w-3.5 h-3.5" />
                            </button>
                            <button
                                @click="adjustHope(1)"
                                class="w-7 h-7 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 flex items-center justify-center"
                            >
                                <Plus class="w-3.5 h-3.5" />
                            </button>
                        </div>
                    </div>
                </div>

                <!-- ARMOR SLOTS -->
                <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-5 flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2">
                            <Shield class="w-4 h-4 text-blue-400" />
                            <span class="font-serif text-sm font-bold uppercase tracking-wider text-white">Armor Slots</span>
                        </div>
                        <span class="font-mono text-xs font-bold text-blue-400">
                            {{ localArmor }} / {{ character.armor_slots_max }}
                        </span>
                    </div>

                    <!-- Pips -->
                    <div class="flex flex-wrap gap-1.5 my-3">
                        <button
                            v-for="i in character.armor_slots_max"
                            :key="i"
                            type="button"
                            @click="setArmor(i === localArmor ? i - 1 : i)"
                            class="w-6 h-6 rounded-lg border transition-all flex items-center justify-center"
                            :class="i <= localArmor 
                                ? 'bg-blue-500 border-blue-400 text-slate-950 shadow-sm shadow-blue-500/30' 
                                : 'bg-slate-950 border-slate-800 hover:border-slate-700'"
                        >
                            <span v-if="i <= localArmor" class="text-[10px] font-bold">🛡</span>
                        </button>
                    </div>

                    <div class="flex items-center justify-between pt-3 border-t border-slate-850">
                        <span class="text-[11px] text-slate-400">Mitigate Hits</span>
                        <div class="flex items-center gap-1.5">
                            <button
                                @click="adjustArmor(-1)"
                                class="w-7 h-7 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 flex items-center justify-center"
                            >
                                <Minus class="w-3.5 h-3.5" />
                            </button>
                            <button
                                @click="adjustArmor(1)"
                                class="w-7 h-7 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 flex items-center justify-center"
                            >
                                <Plus class="w-3.5 h-3.5" />
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ================= COMBAT THRESHOLDS & 6 TRAIT ROLLERS ================= -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Left: Evasion & Damage Thresholds Card -->
                <div class="bg-slate-900/80 border border-slate-800 rounded-3xl p-6 flex flex-col justify-between">
                    <div>
                        <h2 class="font-serif text-lg font-bold text-white uppercase tracking-wider mb-4 flex items-center gap-2">
                            <Shield class="w-4 h-4 text-amber-400" />
                            <span>Defense & Thresholds</span>
                        </h2>

                        <!-- Evasion -->
                        <div class="bg-slate-950 border border-slate-850 rounded-2xl p-4 text-center mb-4">
                            <div class="text-xs uppercase font-bold text-slate-400 tracking-widest mb-1">Evasion Score</div>
                            <div class="font-serif text-3xl font-black text-white">{{ character.evasion }}</div>
                            <div class="text-[11px] text-slate-500 mt-1">Difficulty for adversaries to hit you</div>
                        </div>

                        <!-- Damage Thresholds -->
                        <div class="space-y-2.5">
                            <div class="bg-slate-950/80 border border-slate-850 rounded-xl p-3 flex items-center justify-between">
                                <div>
                                    <div class="text-xs font-bold text-slate-200">Minor Damage</div>
                                    <div class="text-[10px] text-slate-400">&lt; {{ character.major_threshold }} dmg</div>
                                </div>
                                <span class="text-xs font-mono font-bold text-emerald-400 bg-emerald-500/10 px-2.5 py-1 rounded-lg border border-emerald-500/20">
                                    Mark 1 HP
                                </span>
                            </div>

                            <div class="bg-slate-950/80 border border-slate-850 rounded-xl p-3 flex items-center justify-between">
                                <div>
                                    <div class="text-xs font-bold text-amber-300">Major Damage</div>
                                    <div class="text-[10px] text-slate-400">{{ character.major_threshold }} – {{ character.severe_threshold - 1 }} dmg</div>
                                </div>
                                <span class="text-xs font-mono font-bold text-amber-300 bg-amber-500/10 px-2.5 py-1 rounded-lg border border-amber-500/20">
                                    Mark 2 HP
                                </span>
                            </div>

                            <div class="bg-slate-950/80 border border-slate-850 rounded-xl p-3 flex items-center justify-between">
                                <div>
                                    <div class="text-xs font-bold text-red-400">Severe Damage</div>
                                    <div class="text-[10px] text-slate-400">{{ character.severe_threshold }}+ dmg</div>
                                </div>
                                <span class="text-xs font-mono font-bold text-red-400 bg-red-500/10 px-2.5 py-1 rounded-lg border border-red-500/20">
                                    Mark 3 HP
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right 2 Cols: 6 Core Trait Dice Rollers -->
                <div class="lg:col-span-2 bg-slate-900/80 border border-slate-800 rounded-3xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="font-serif text-lg font-bold text-white uppercase tracking-wider flex items-center gap-2">
                                <Dices class="w-4 h-4 text-amber-400" />
                                <span>Core Traits & Duality Roller</span>
                            </h2>
                            <p class="text-xs text-slate-400 mt-0.5">
                                Tap any trait to roll 2d12 (Hope vs Fear) + your modifier.
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        <button
                            v-for="trait in traitsList"
                            :key="trait.key"
                            type="button"
                            @click="rollTrait(trait.label, character[trait.key])"
                            class="bg-slate-950/90 border border-slate-800 hover:border-amber-500/60 rounded-2xl p-4 text-left transition-all hover:-translate-y-1 hover:shadow-lg hover:shadow-amber-500/10 group cursor-pointer"
                        >
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-serif text-xs uppercase font-bold text-slate-400 group-hover:text-amber-300">
                                    {{ trait.label }}
                                </span>
                                <Dices class="w-3.5 h-3.5 text-slate-600 group-hover:text-amber-400 transition-colors" />
                            </div>
                            <div class="font-serif text-2xl sm:text-3xl font-black text-white group-hover:text-amber-400 transition-colors">
                                {{ character[trait.key] > 0 ? `+${character[trait.key]}` : character[trait.key] }}
                            </div>
                            <div class="text-[10px] text-amber-500/70 font-semibold mt-1">
                                Click to Roll 2d12
                            </div>
                        </button>
                    </div>
                </div>

            </div>

            <!-- ================= EQUIPPED DOMAIN CARDS LOADOUT ================= -->
            <div class="bg-slate-900/80 border border-slate-800 rounded-3xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="font-serif text-lg font-bold text-white uppercase tracking-wider flex items-center gap-2">
                            <Sparkles class="w-4 h-4 text-amber-400" />
                            <span>Equipped Domain Loadout ({{ character.equipped_domain_cards?.length || 0 }} Cards)</span>
                        </h2>
                        <p class="text-xs text-slate-400 mt-0.5">
                            Active abilities and spells currently prepared for encounters.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div
                        v-for="card in character.equipped_domain_cards"
                        :key="card.id"
                        class="bg-slate-950/90 border border-slate-800 rounded-2xl p-5 flex flex-col justify-between"
                    >
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-2">
                                <div class="text-xs font-semibold tracking-wider flex items-center gap-1.5">
                                    <span class="text-slate-400 uppercase">{{ card.type }}</span>
                                    <span class="text-slate-600 font-bold">•</span>
                                    <span :class="domainColors[card.domain] || 'text-amber-400'">{{ card.domain }}</span>
                                </div>
                                <span class="text-xs text-slate-400 font-mono">
                                    Level {{ card.level }}
                                </span>
                            </div>

                            <h3 class="font-serif text-xl font-bold text-white mb-2">
                                {{ card.name }}
                            </h3>

                            <p class="text-xs text-slate-300 leading-relaxed bg-slate-900/60 p-3.5 rounded-xl border border-slate-850">
                                {{ card.description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================= FEATURES, TRAITS & NOTES ================= -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <!-- Class & Subclass Features -->
                <div class="bg-slate-900/80 border border-slate-800 rounded-3xl p-6 space-y-4">
                    <h2 class="font-serif text-lg font-bold text-white uppercase tracking-wider flex items-center gap-2">
                        <Flame class="w-4 h-4 text-amber-400" />
                        <span>Class & Subclass Features</span>
                    </h2>

                    <!-- Class Feature -->
                    <div class="bg-slate-950/80 border border-slate-850 rounded-2xl p-4">
                        <div class="font-serif text-sm font-bold text-amber-300 mb-1">
                            {{ character.character_class?.class_feature_name }}
                        </div>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            {{ character.character_class?.class_feature_description }}
                        </p>
                    </div>

                    <!-- Hope Feature -->
                    <div class="bg-slate-950/80 border border-slate-850 rounded-2xl p-4">
                        <div class="font-serif text-sm font-bold text-amber-300 mb-1">
                            Hope Feature: {{ character.character_class?.hope_feature_name }}
                        </div>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            {{ character.character_class?.hope_feature_description }}
                        </p>
                    </div>

                    <!-- Subclass Foundation Feature -->
                    <div v-if="character.subclass" class="bg-slate-950/80 border border-slate-850 rounded-2xl p-4">
                        <div class="font-serif text-sm font-bold text-amber-300 mb-1">
                            Subclass: {{ character.subclass?.foundation_feature_name }}
                        </div>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            {{ character.subclass?.foundation_feature_description }}
                        </p>
                    </div>
                </div>

                <!-- Notes & Journal -->
                <div class="bg-slate-900/80 border border-slate-800 rounded-3xl p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <h2 class="font-serif text-lg font-bold text-white uppercase tracking-wider flex items-center gap-2">
                                <Sparkles class="w-4 h-4 text-amber-400" />
                                <span>Adventurer's Journal & Notes</span>
                            </h2>
                            <span v-if="notesSaved" class="text-xs text-emerald-400 font-bold flex items-center gap-1">
                                <Check class="w-3.5 h-3.5" />
                                <span>Saved</span>
                            </span>
                        </div>

                        <textarea
                            v-model="localNotes"
                            rows="8"
                            placeholder="Record quests, bonds, inventory items, campaign clues, or secrets..."
                            class="w-full bg-slate-950 border border-slate-800 rounded-2xl p-4 text-xs sm:text-sm text-slate-200 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 leading-relaxed resize-none"
                        ></textarea>
                    </div>

                    <div class="mt-4 flex justify-end">
                        <button
                            type="button"
                            @click="saveNotes"
                            class="px-5 py-2 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 text-xs font-bold transition-all flex items-center gap-1.5"
                        >
                            <Save class="w-3.5 h-3.5" />
                            <span>Save Notes</span>
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </AppLayout>
</template>

