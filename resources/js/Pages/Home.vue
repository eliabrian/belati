<script setup>
import { ref, onMounted } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { 
    Dices, 
    BookOpen, 
    Flame, 
    Sparkles, 
    Shield, 
    Heart, 
    Skull, 
    Compass, 
    Plus, 
    ChevronRight 
} from 'lucide-vue-next';

const page = usePage();

// Quick Interactive Duality Dice Demo (Hope vs Fear)
const hopeRoll = ref(null);
const fearRoll = ref(null);
const modifier = ref(2);
const isRolling = ref(false);

const rollDualityDice = () => {
    isRolling.value = true;
    setTimeout(() => {
        hopeRoll.value = Math.floor(Math.random() * 12) + 1;
        fearRoll.value = Math.floor(Math.random() * 12) + 1;
        isRolling.value = false;
    }, 250);
};

// Auto roll once on load
rollDualityDice();

onMounted(() => {
    if (window.location.hash === '#dice-demo') {
        setTimeout(() => {
            document.getElementById('dice-demo')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 150);
    }
});
</script>

<template>
    <AppLayout>
        <Head title="Belati — Companion Compatible with Daggerheart™" />

        <!-- Hero Section -->
        <div class="relative overflow-hidden pt-8 pb-14 sm:py-16">
            <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-[700px] h-[500px] bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
                <div class="text-center max-w-3xl mx-auto">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-900/80 border border-amber-500/30 text-amber-300 text-xs font-medium mb-6 backdrop-blur">
                        <Sparkles class="w-3.5 h-3.5 text-amber-400" />
                        <span>Designed for Mobile, Tablets & Desktop</span>
                    </div>

                    <h1 class="font-serif text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white uppercase leading-tight">
                        Your Story, <br class="hidden sm:inline" />
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-300 via-amber-400 to-amber-600">
                            Forged in Hope & Fear
                        </span>
                    </h1>

                    <p class="mt-4 sm:mt-6 text-sm sm:text-base text-slate-300 max-w-2xl mx-auto leading-relaxed">
                        Belati is an automated character sheet, real-time live DM tracker, duality dice roller, and full SRD compendium compatible with Daggerheart™.
                    </p>

                    <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
                        <Link
                            href="/register"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-bold px-6 py-3.5 rounded-xl shadow-xl shadow-amber-500/20 text-sm transition-all hover:scale-105"
                        >
                            <Plus class="w-4 h-4 stroke-[2.5]" />
                            <span>Create Character</span>
                        </Link>
                        <a
                            href="#dice-demo"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-slate-900/80 hover:bg-slate-800 border border-slate-700/80 text-slate-200 font-semibold px-6 py-3.5 rounded-xl text-sm transition-colors"
                        >
                            <Dices class="w-4 h-4 text-amber-400" />
                            <span>Try Dice Roller</span>
                        </a>
                    </div>
                </div>

                <!-- Live Duality Dice Playground Card -->
                <div id="dice-demo" class="mt-12 sm:mt-16 max-w-xl mx-auto bg-slate-900/80 border border-slate-800 rounded-2xl p-6 backdrop-blur shadow-2xl scroll-mt-20 sm:scroll-mt-24">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-800">
                        <div class="flex items-center gap-2">
                            <Dices class="w-5 h-5 text-amber-400" />
                            <h2 class="font-serif font-bold text-sm sm:text-base text-slate-100 tracking-wide">
                                Duality Dice System (2d12)
                            </h2>
                        </div>
                        <span class="text-[11px] text-slate-400 font-mono">Mod: +{{ modifier }}</span>
                    </div>

                    <div class="grid grid-cols-2 gap-4 my-6">
                        <!-- Hope Die -->
                        <div class="bg-gradient-to-br from-amber-500/10 to-amber-950/30 border border-amber-500/40 rounded-xl p-4 text-center">
                            <div class="text-[11px] font-bold text-amber-400 uppercase tracking-widest flex items-center justify-center gap-1">
                                <Sparkles class="w-3.5 h-3.5" /> Hope Die
                            </div>
                            <div class="font-serif text-4xl sm:text-5xl font-black text-amber-200 mt-2 transition-transform" :class="{ 'scale-110': isRolling }">
                                {{ hopeRoll ?? '—' }}
                            </div>
                        </div>

                        <!-- Fear Die -->
                        <div class="bg-gradient-to-br from-purple-950/30 to-slate-950/40 border border-purple-500/40 rounded-xl p-4 text-center">
                            <div class="text-[11px] font-bold text-purple-400 uppercase tracking-widest flex items-center justify-center gap-1">
                                <Skull class="w-3.5 h-3.5" /> Fear Die
                            </div>
                            <div class="font-serif text-4xl sm:text-5xl font-black text-purple-200 mt-2 transition-transform" :class="{ 'scale-110': isRolling }">
                                {{ fearRoll ?? '—' }}
                            </div>
                        </div>
                    </div>

                    <!-- Result Banner -->
                    <div v-if="hopeRoll && fearRoll" class="bg-slate-950/80 border border-slate-800/80 rounded-xl p-3 text-center mb-4">
                        <div class="text-xs text-slate-400">
                            Total: <span class="font-bold text-white text-sm">{{ hopeRoll + fearRoll + modifier }}</span> ({{ hopeRoll }} + {{ fearRoll }} + {{ modifier }})
                        </div>
                        <div class="text-xs font-semibold mt-1">
                            <span v-if="hopeRoll === fearRoll" class="text-amber-300 font-bold">
                                ✨ CRITICAL SUCCESS! Gain 1 Hope & Clear 1 Stress
                            </span>
                            <span v-else-if="hopeRoll > fearRoll" class="text-amber-400">
                                Rolled with <strong class="underline">HOPE</strong> (Gain 1 Hope token)
                            </span>
                            <span v-else class="text-purple-400">
                                Rolled with <strong class="underline">FEAR</strong> (GM gains 1 Fear token)
                            </span>
                        </div>
                    </div>

                    <button
                        @click="rollDualityDice"
                        :disabled="isRolling"
                        class="w-full bg-slate-800 hover:bg-slate-700 active:scale-[0.99] text-amber-400 font-semibold py-2.5 px-4 rounded-xl text-xs sm:text-sm border border-amber-500/30 flex items-center justify-center gap-2 transition-all"
                    >
                        <Dices class="w-4 h-4" />
                        <span>Roll Duality Dice</span>
                    </button>
                </div>

                <!-- Feature Grid -->
                <div class="mt-16 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Feature 1 -->
                    <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-6 backdrop-blur">
                        <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-center justify-center mb-4">
                            <BookOpen class="w-5 h-5" />
                        </div>
                        <h3 class="font-serif font-bold text-lg text-slate-100">SRD Compendium</h3>
                        <p class="text-xs sm:text-sm text-slate-400 mt-2 leading-relaxed">
                            Full database of Ancestries, Communities, Classes, Subclasses, Domain decks, and equipment right at your fingertips.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-6 backdrop-blur">
                        <div class="w-10 h-10 rounded-xl bg-purple-500/10 border border-purple-500/20 text-purple-400 flex items-center justify-center mb-4">
                            <Flame class="w-5 h-5" />
                        </div>
                        <h3 class="font-serif font-bold text-lg text-slate-100">Live DM Tracker</h3>
                        <p class="text-xs sm:text-sm text-slate-400 mt-2 leading-relaxed">
                            DM Fear counters, player health, stress pips, and party action tracker sync instantly in real-time across all devices.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-6 backdrop-blur">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center mb-4">
                            <Shield class="w-5 h-5" />
                        </div>
                        <h3 class="font-serif font-bold text-lg text-slate-100">Privacy by Default</h3>
                        <p class="text-xs sm:text-sm text-slate-400 mt-2 leading-relaxed">
                            No full names, no third-party tracking or advertising scripts. Burner-friendly accounts or guest table sessions.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

