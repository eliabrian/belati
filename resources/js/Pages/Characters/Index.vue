<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { 
    Plus, 
    Shield, 
    Heart, 
    Sparkles, 
    Trash2, 
    User as UserIcon, 
    ChevronRight,
    Sword
} from 'lucide-vue-next';

defineProps({
    characters: {
        type: Array,
        default: () => [],
    },
});

const deleteCharacter = (character) => {
    if (confirm(`Are you sure you want to retire ${character.name}? This cannot be undone.`)) {
        router.delete(`/characters/${character.id}`);
    }
};
</script>

<template>
    <AppLayout>
        <Head title="Characters — Belati" />

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-800 pb-5">
                <div>
                    <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs font-semibold mb-2">
                        <Sword class="w-3.5 h-3.5" />
                        <span>Adventurer's Roster</span>
                    </div>
                    <h1 class="font-serif text-2xl sm:text-3xl font-bold text-white uppercase tracking-wide">
                        My Characters
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-400 mt-0.5">
                        Manage your Daggerheart heroes, track vitals, and roll duality dice.
                    </p>
                </div>

                <Link
                    href="/characters/create"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-sm transition-all shadow-lg shadow-amber-500/20 hover:-translate-y-0.5"
                >
                    <Plus class="w-4 h-4 stroke-[3]" />
                    <span>Create Character</span>
                </Link>
            </div>

            <!-- Empty State -->
            <div
                v-if="characters.length === 0"
                class="mt-12 text-center py-16 px-4 bg-slate-900/40 border border-dashed border-slate-800 rounded-3xl max-w-xl mx-auto"
            >
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400">
                    <UserIcon class="w-8 h-8" />
                </div>
                <h3 class="font-serif text-xl font-bold text-white mb-2">
                    No Characters Yet
                </h3>
                <p class="text-sm text-slate-400 mb-6 leading-relaxed max-w-md mx-auto">
                    Forge your first hero with our guided step-by-step creator. Choose your class, ancestry, community, and assign starting traits in minutes.
                </p>
                <Link
                    href="/characters/create"
                    class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-sm transition-all shadow-lg shadow-amber-500/25"
                >
                    <Plus class="w-4 h-4 stroke-[3]" />
                    <span>Begin Character Creation</span>
                </Link>
            </div>

            <!-- Characters Grid -->
            <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
                <div
                    v-for="character in characters"
                    :key="character.id"
                    class="bg-slate-900/80 border border-slate-800 hover:border-amber-500/50 rounded-2xl p-6 transition-all hover:shadow-xl hover:shadow-amber-500/5 flex flex-col justify-between group"
                >
                    <div>
                        <!-- Top Meta -->
                        <div class="flex items-start justify-between gap-2 mb-3">
                            <span class="text-xs font-mono font-semibold px-2.5 py-0.5 rounded-full bg-slate-800 text-slate-300 border border-slate-700">
                                Level {{ character.level }}
                            </span>
                            <button
                                @click="deleteCharacter(character)"
                                class="text-slate-500 hover:text-red-400 p-1 rounded-lg transition-colors"
                                title="Retire Character"
                            >
                                <Trash2 class="w-4 h-4" />
                            </button>
                        </div>

                        <!-- Name & Class -->
                        <h2 class="font-serif text-2xl font-bold text-white group-hover:text-amber-300 transition-colors mb-1">
                            {{ character.name }}
                        </h2>
                        <div class="text-xs text-amber-400 font-semibold tracking-wide uppercase mb-4 flex flex-wrap items-center gap-1.5">
                            <span>{{ character.character_class?.name }}</span>
                            <span v-if="character.subclass" class="text-slate-500">•</span>
                            <span v-if="character.subclass" class="text-slate-300">{{ character.subclass?.name }}</span>
                        </div>

                        <!-- Ancestry & Community Badges -->
                        <div class="flex flex-wrap gap-2 mb-5">
                            <span class="text-xs px-2.5 py-1 rounded-md bg-slate-950 border border-slate-800 text-slate-300">
                                {{ character.ancestry?.name }}
                            </span>
                            <span class="text-xs px-2.5 py-1 rounded-md bg-slate-950 border border-slate-800 text-slate-300">
                                {{ character.community?.name }}
                            </span>
                        </div>

                        <!-- Quick Vitals Snapshot -->
                        <div class="grid grid-cols-3 gap-2 bg-slate-950/80 border border-slate-850 rounded-xl p-3 text-center mb-5">
                            <div>
                                <div class="text-[10px] text-slate-400 uppercase font-bold tracking-wider mb-0.5">HP</div>
                                <div class="font-serif font-black text-emerald-400 text-lg">
                                    {{ character.hit_points_current }}/{{ character.hit_points_max }}
                                </div>
                            </div>
                            <div class="border-l border-slate-850">
                                <div class="text-[10px] text-slate-400 uppercase font-bold tracking-wider mb-0.5">Stress</div>
                                <div class="font-serif font-black text-purple-400 text-lg">
                                    {{ character.stress_current }}/{{ character.stress_max }}
                                </div>
                            </div>
                            <div class="border-l border-slate-850">
                                <div class="text-[10px] text-slate-400 uppercase font-bold tracking-wider mb-0.5">Evasion</div>
                                <div class="font-serif font-black text-slate-100 text-lg">
                                    {{ character.evasion }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Action -->
                    <Link
                        :href="`/characters/${character.id}`"
                        class="w-full inline-flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl bg-slate-800 hover:bg-amber-500 hover:text-slate-950 text-slate-200 text-xs sm:text-sm font-bold transition-all border border-slate-750 hover:border-amber-500"
                    >
                        <span>Open Character Sheet</span>
                        <ChevronRight class="w-4 h-4" />
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

