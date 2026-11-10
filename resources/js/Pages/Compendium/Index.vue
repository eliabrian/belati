<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { 
    BookOpen, 
    Search, 
    Sparkles, 
    Flame, 
    Shield, 
    Layers, 
    Users, 
    Compass, 
    X, 
    ChevronRight,
    ArrowUpRight
} from 'lucide-vue-next';

const props = defineProps({
    ancestries: {
        type: Array,
        required: true,
    },
    communities: {
        type: Array,
        required: true,
    },
    classes: {
        type: Array,
        required: true,
    },
    domain_cards: {
        type: Array,
        default: () => [],
    },
});

const activeTab = ref('classes'); // 'classes' | 'ancestries' | 'communities' | 'cards'
const searchQuery = ref('');
const selectedDomainFilter = ref('All');

// Drawer State
const activeDrawerItem = ref(null); // { type: 'class' | 'ancestry' | 'community' | 'card', data: Object }

const domainsList = ['All', 'Blade', 'Bone', 'Codex', 'Grace', 'Midnight', 'Sage', 'Splendor', 'Valor', 'Arcana'];

// Domain Badge & Border Colors
const domainColors = {
    Blade: {
        text: 'text-red-400',
        badge: 'bg-red-500/10 text-red-400 border-red-500/30',
        border: 'border-red-500/40 hover:border-red-500/80',
        glow: 'group-hover:shadow-red-500/10',
    },
    Bone: {
        text: 'text-zinc-300',
        badge: 'bg-zinc-500/10 text-zinc-300 border-zinc-500/30',
        border: 'border-zinc-500/40 hover:border-zinc-400',
        glow: 'group-hover:shadow-zinc-500/10',
    },
    Codex: {
        text: 'text-blue-400',
        badge: 'bg-blue-500/10 text-blue-400 border-blue-500/30',
        border: 'border-blue-500/40 hover:border-blue-400',
        glow: 'group-hover:shadow-blue-500/10',
    },
    Grace: {
        text: 'text-emerald-400',
        badge: 'bg-emerald-500/10 text-emerald-400 border-emerald-500/30',
        border: 'border-emerald-500/40 hover:border-emerald-400',
        glow: 'group-hover:shadow-emerald-500/10',
    },
    Midnight: {
        text: 'text-purple-400',
        badge: 'bg-purple-500/10 text-purple-400 border-purple-500/30',
        border: 'border-purple-500/40 hover:border-purple-400',
        glow: 'group-hover:shadow-purple-500/10',
    },
    Sage: {
        text: 'text-amber-400',
        badge: 'bg-amber-500/10 text-amber-400 border-amber-500/30',
        border: 'border-amber-500/40 hover:border-amber-400',
        glow: 'group-hover:shadow-amber-500/10',
    },
    Splendor: {
        text: 'text-yellow-300',
        badge: 'bg-yellow-500/10 text-yellow-300 border-yellow-500/30',
        border: 'border-yellow-500/40 hover:border-yellow-400',
        glow: 'group-hover:shadow-yellow-500/10',
    },
    Valor: {
        text: 'text-orange-400',
        badge: 'bg-orange-500/10 text-orange-400 border-orange-500/30',
        border: 'border-orange-500/40 hover:border-orange-400',
        glow: 'group-hover:shadow-orange-500/10',
    },
    Arcana: {
        text: 'text-indigo-400',
        badge: 'bg-indigo-500/10 text-indigo-400 border-indigo-500/30',
        border: 'border-indigo-500/40 hover:border-indigo-400',
        glow: 'group-hover:shadow-indigo-500/10',
    },
};

// Filtered Lists
const filteredClasses = computed(() => {
    if (!searchQuery.value) return props.classes;
    const q = searchQuery.value.toLowerCase();
    return props.classes.filter(c => 
        c.name.toLowerCase().includes(q) ||
        c.description.toLowerCase().includes(q) ||
        c.primary_domains?.some(d => d.toLowerCase().includes(q)) ||
        c.subclasses?.some(s => s.name.toLowerCase().includes(q))
    );
});

const filteredAncestries = computed(() => {
    if (!searchQuery.value) return props.ancestries;
    const q = searchQuery.value.toLowerCase();
    return props.ancestries.filter(a => 
        a.name.toLowerCase().includes(q) ||
        a.description.toLowerCase().includes(q) ||
        a.features?.some(f => f.name.toLowerCase().includes(q) || f.description.toLowerCase().includes(q))
    );
});

const filteredCommunities = computed(() => {
    if (!searchQuery.value) return props.communities;
    const q = searchQuery.value.toLowerCase();
    return props.communities.filter(c => 
        c.name.toLowerCase().includes(q) ||
        c.description.toLowerCase().includes(q) ||
        c.features?.some(f => f.name.toLowerCase().includes(q) || f.description.toLowerCase().includes(q))
    );
});

const filteredDomainCards = computed(() => {
    let cards = props.domain_cards || [];
    if (selectedDomainFilter.value !== 'All') {
        cards = cards.filter(c => c.domain === selectedDomainFilter.value);
    }
    if (!searchQuery.value) return cards;
    const q = searchQuery.value.toLowerCase();
    return cards.filter(c => 
        c.name.toLowerCase().includes(q) ||
        c.description.toLowerCase().includes(q) ||
        c.domain.toLowerCase().includes(q) ||
        c.type.toLowerCase().includes(q)
    );
});

const openDrawer = (type, data) => {
    activeDrawerItem.value = { type, data };
    document.body.style.overflow = 'hidden';
};

const closeDrawer = () => {
    activeDrawerItem.value = null;
    document.body.style.overflow = '';
};

// Handle Escape Key to close drawer
const onKeyDown = (e) => {
    if (e.key === 'Escape') closeDrawer();
};

onMounted(() => window.addEventListener('keydown', onKeyDown));
onUnmounted(() => {
    window.removeEventListener('keydown', onKeyDown);
    document.body.style.overflow = '';
});
</script>

<template>
    <AppLayout>
        <Head title="Daggerheart SRD Compendium — Belati" />

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-slate-800 pb-5">
                <div>
                    <h1 class="font-serif text-2xl sm:text-3xl font-bold text-white uppercase tracking-wide">
                        Compendium
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-400 mt-0.5">
                        Rules, classes, ancestries, communities, and domain cards for Daggerheart.
                    </p>
                </div>

                <!-- Search Input -->
                <div class="relative w-full md:w-80">
                    <Search class="w-4 h-4 text-slate-500 absolute left-3.5 top-1/2 -translate-y-1/2" />
                    <input
                        v-model="searchQuery"
                        type="text"
                        placeholder="Search rules, traits, features..."
                        class="w-full bg-slate-900 border border-slate-800 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 rounded-xl pl-10 pr-4 py-2.5 text-xs sm:text-sm text-slate-100 placeholder-slate-500 transition-colors"
                    />
                    <button
                        v-if="searchQuery"
                        @click="searchQuery = ''"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-300 p-1"
                    >
                        <X class="w-3.5 h-3.5" />
                    </button>
                </div>
            </div>

            <!-- Categories Tabs -->
            <div class="flex items-center gap-2 overflow-x-auto py-3 border-b border-slate-800/80 no-scrollbar">
                <button
                    @click="activeTab = 'classes'"
                    class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all whitespace-nowrap"
                    :class="activeTab === 'classes' 
                        ? 'bg-amber-500 text-slate-950 shadow-md shadow-amber-500/20' 
                        : 'bg-slate-900/60 text-slate-300 hover:bg-slate-800 border border-slate-800'"
                >
                    Classes ({{ classes.length }})
                </button>

                <button
                    @click="activeTab = 'ancestries'"
                    class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all whitespace-nowrap"
                    :class="activeTab === 'ancestries' 
                        ? 'bg-amber-500 text-slate-950 shadow-md shadow-amber-500/20' 
                        : 'bg-slate-900/60 text-slate-300 hover:bg-slate-800 border border-slate-800'"
                >
                    Ancestries ({{ ancestries.length }})
                </button>

                <button
                    @click="activeTab = 'communities'"
                    class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all whitespace-nowrap"
                    :class="activeTab === 'communities' 
                        ? 'bg-amber-500 text-slate-950 shadow-md shadow-amber-500/20' 
                        : 'bg-slate-900/60 text-slate-300 hover:bg-slate-800 border border-slate-800'"
                >
                    Communities ({{ communities.length }})
                </button>

                <button
                    @click="activeTab = 'cards'"
                    class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all whitespace-nowrap"
                    :class="activeTab === 'cards' 
                        ? 'bg-amber-500 text-slate-950 shadow-md shadow-amber-500/20' 
                        : 'bg-slate-900/60 text-slate-300 hover:bg-slate-800 border border-slate-800'"
                >
                    Domain Cards ({{ (domain_cards || []).length }})
                </button>
            </div>

            <!-- ================= GALLERY VIEW: CLASSES ================= -->
            <div v-if="activeTab === 'classes'" class="mt-6">
                <div v-if="filteredClasses.length === 0" class="py-12 text-center text-slate-500 text-sm">
                    No classes match your search query.
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div
                        v-for="charClass in filteredClasses"
                        :key="charClass.id"
                        @click="openDrawer('class', charClass)"
                        class="bg-slate-900/70 border border-slate-800 hover:border-amber-500/60 rounded-2xl p-6 sm:p-7 flex flex-col justify-between transition-all hover:shadow-xl hover:shadow-amber-500/10 hover:-translate-y-1 cursor-pointer group"
                    >
                        <div>
                            <div class="flex items-start justify-between gap-2 mb-2.5">
                                <h3 class="font-serif text-2xl font-extrabold text-amber-100 group-hover:text-amber-400 transition-colors uppercase tracking-wide">
                                    {{ charClass.name }}
                                </h3>
                                <ArrowUpRight class="w-5 h-5 text-slate-500 group-hover:text-amber-400 transition-colors shrink-0" />
                            </div>

                            <!-- Primary Domains -->
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span
                                    v-for="domain in charClass.primary_domains"
                                    :key="domain"
                                    class="text-xs font-semibold px-2.5 py-1 rounded-md border"
                                    :class="domainColors[domain]?.badge || 'bg-slate-800 text-slate-300 border-slate-700'"
                                >
                                    {{ domain }}
                                </span>
                            </div>

                            <!-- Stat Pills -->
                            <div class="grid grid-cols-3 gap-2 bg-slate-950/90 border border-slate-800 rounded-xl p-3.5 mb-2 text-center shadow-inner">
                                <div>
                                    <div class="text-xs text-slate-400 uppercase font-bold tracking-wider mb-0.5">Evasion</div>
                                    <div class="font-serif font-black text-xl text-slate-100">{{ charClass.starting_evasion }}</div>
                                </div>
                                <div class="border-l border-slate-800">
                                    <div class="text-xs text-slate-400 uppercase font-bold tracking-wider mb-0.5">HP</div>
                                    <div class="font-serif font-black text-xl text-emerald-400">{{ charClass.starting_hit_points }}</div>
                                </div>
                                <div class="border-l border-slate-800">
                                    <div class="text-xs text-slate-400 uppercase font-bold tracking-wider mb-0.5">Thresholds</div>
                                    <div class="font-serif font-bold text-sm sm:text-base text-amber-300 mt-0.5">
                                        {{ charClass.base_major_threshold }} / {{ charClass.base_severe_threshold }}+
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="pt-4 border-t border-slate-800/80 flex items-center justify-between text-xs sm:text-sm mt-4">
                            <span class="text-slate-400 font-medium">
                                {{ charClass.subclasses?.length }} Subclasses
                            </span>
                            <span class="text-amber-400 group-hover:underline font-bold flex items-center gap-1">
                                <span>Inspect Sheet</span>
                                <ChevronRight class="w-4 h-4" />
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================= GALLERY VIEW: ANCESTRIES ================= -->
            <div v-if="activeTab === 'ancestries'" class="mt-6">
                <div v-if="filteredAncestries.length === 0" class="py-12 text-center text-slate-500 text-sm">
                    No ancestries match your search query.
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div
                        v-for="ancestry in filteredAncestries"
                        :key="ancestry.id"
                        @click="openDrawer('ancestry', ancestry)"
                        class="bg-slate-900/70 border border-slate-800 hover:border-amber-500/60 rounded-2xl p-6 sm:p-7 flex flex-col justify-between transition-all hover:shadow-xl hover:shadow-amber-500/10 hover:-translate-y-1 cursor-pointer group"
                    >
                        <div>
                            <div class="flex items-start justify-between gap-2 mb-2.5">
                                <h3 class="font-serif text-xl sm:text-2xl font-bold text-amber-100 group-hover:text-amber-400 transition-colors uppercase tracking-wide">
                                    {{ ancestry.name }}
                                </h3>
                                <ArrowUpRight class="w-5 h-5 text-slate-500 group-hover:text-amber-400 transition-colors shrink-0" />
                            </div>

                            <div v-if="ancestry.features?.length" class="flex flex-wrap gap-2 mt-3">
                                <span
                                    v-for="feature in ancestry.features"
                                    :key="feature.name"
                                    class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-lg bg-amber-500/10 text-amber-300 border border-amber-500/20"
                                >
                                    <Sparkles class="w-3 h-3 text-amber-400" />
                                    <span>{{ feature.name }}</span>
                                </span>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-800/80 flex items-center justify-between text-xs sm:text-sm mt-5">
                            <span class="text-slate-400 font-medium">Ancestry Traits</span>
                            <span class="text-amber-400 group-hover:underline font-bold flex items-center gap-1">
                                <span>Read Traits</span>
                                <ChevronRight class="w-4 h-4" />
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================= GALLERY VIEW: COMMUNITIES ================= -->
            <div v-if="activeTab === 'communities'" class="mt-6">
                <div v-if="filteredCommunities.length === 0" class="py-12 text-center text-slate-500 text-sm">
                    No communities match your search query.
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div
                        v-for="community in filteredCommunities"
                        :key="community.id"
                        @click="openDrawer('community', community)"
                        class="bg-slate-900/70 border border-slate-800 hover:border-amber-500/60 rounded-2xl p-6 sm:p-7 flex flex-col justify-between transition-all hover:shadow-xl hover:shadow-amber-500/10 hover:-translate-y-1 cursor-pointer group"
                    >
                        <div>
                            <div class="flex items-start justify-between gap-2 mb-2.5">
                                <h3 class="font-serif text-xl sm:text-2xl font-bold text-amber-100 group-hover:text-amber-400 transition-colors uppercase tracking-wide">
                                    {{ community.name }}
                                </h3>
                                <ArrowUpRight class="w-5 h-5 text-slate-500 group-hover:text-amber-400 transition-colors shrink-0" />
                            </div>

                            <div v-if="community.features?.length" class="flex flex-wrap gap-2 mt-3">
                                <span
                                    v-for="feature in community.features"
                                    :key="feature.name"
                                    class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-lg bg-amber-500/10 text-amber-300 border border-amber-500/20"
                                >
                                    <Sparkles class="w-3 h-3 text-amber-400" />
                                    <span>{{ feature.name }}</span>
                                </span>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-800/80 flex items-center justify-between text-xs sm:text-sm mt-5">
                            <span class="text-slate-400 font-medium">Community Traits</span>
                            <span class="text-amber-400 group-hover:underline font-bold flex items-center gap-1">
                                <span>Read Traits</span>
                                <ChevronRight class="w-4 h-4" />
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================= GALLERY VIEW: DOMAIN CARDS ================= -->
            <div v-if="activeTab === 'cards'" class="mt-6">
                <!-- Domain Filter Chips -->
                <div class="flex items-center gap-1.5 overflow-x-auto pb-4 no-scrollbar">
                    <button
                        v-for="domain in domainsList"
                        :key="domain"
                        @click="selectedDomainFilter = domain"
                        class="text-xs px-3 py-1.5 rounded-xl font-medium transition-all whitespace-nowrap"
                        :class="selectedDomainFilter === domain
                            ? 'bg-amber-500 text-slate-950 font-bold shadow-md shadow-amber-500/20'
                            : 'bg-slate-900 border border-slate-800 text-slate-400 hover:text-white hover:bg-slate-800'"
                    >
                        {{ domain }}
                    </button>
                </div>

                <div v-if="filteredDomainCards.length === 0" class="py-12 text-center text-slate-500 text-sm">
                    No domain cards match your search or filter.
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div
                        v-for="card in filteredDomainCards"
                        :key="card.id"
                        @click="openDrawer('card', card)"
                        class="bg-slate-900/80 border rounded-2xl p-6 sm:p-7 flex flex-col justify-between transition-all hover:shadow-xl hover:-translate-y-1 cursor-pointer group"
                        :class="domainColors[card.domain]?.border || 'border-slate-800 hover:border-slate-700'"
                    >
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <span class="text-xs font-mono font-medium px-2.5 py-0.5 rounded-md bg-slate-800/80 border border-slate-700/60 text-slate-300">
                                    Level {{ card.level }}
                                </span>
                                <ArrowUpRight class="w-5 h-5 text-slate-500 group-hover:text-amber-400 transition-colors shrink-0" />
                            </div>

                            <h3 class="font-serif text-xl sm:text-2xl font-bold text-white group-hover:text-amber-300 transition-colors mb-1.5">
                                {{ card.name }}
                            </h3>

                            <div class="text-xs font-semibold tracking-wider flex items-center gap-1.5">
                                <span class="text-slate-400 uppercase">{{ card.type }}</span>
                                <span class="text-slate-600 font-bold">•</span>
                                <span :class="domainColors[card.domain]?.text || 'text-amber-400'">{{ card.domain }}</span>
                            </div>
                        </div>

                        <div class="mt-5 pt-4 border-t border-slate-800/80 flex items-center justify-between text-xs sm:text-sm">
                            <span class="text-slate-400 font-medium">Core Deck</span>
                            <span class="text-amber-400 font-bold group-hover:underline flex items-center gap-1">
                                <span>Inspect Card</span>
                                <ChevronRight class="w-4 h-4" />
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================= SLIDE-OVER SHEET DRAWER ================= -->
            <Teleport to="body">
                <div
                    v-show="activeDrawerItem"
                    class="fixed inset-0 z-50 overflow-hidden"
                    role="dialog"
                    aria-modal="true"
                >
                    <!-- Backdrop with smooth fade transition -->
                    <Transition
                        enter-active-class="transition-opacity ease-out duration-300"
                        enter-from-class="opacity-0"
                        enter-to-class="opacity-100"
                        leave-active-class="transition-opacity ease-in duration-200"
                        leave-from-class="opacity-100"
                        leave-to-class="opacity-0"
                    >
                        <div
                            v-if="activeDrawerItem"
                            @click="closeDrawer"
                            class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm"
                        ></div>
                    </Transition>

                    <!-- Slide-Over Container with smooth slide-in transition -->
                    <div class="fixed inset-y-0 right-0 max-w-full flex pl-0 sm:pl-10 pointer-events-none">
                        <Transition
                            enter-active-class="transform transition ease-out duration-300 sm:duration-400"
                            enter-from-class="translate-x-full"
                            enter-to-class="translate-x-0"
                            leave-active-class="transform transition ease-in duration-200 sm:duration-300"
                            leave-from-class="translate-x-0"
                            leave-to-class="translate-x-full"
                        >
                            <div
                                v-if="activeDrawerItem"
                                class="w-screen max-w-2xl bg-slate-900 border-l border-slate-800 shadow-2xl flex flex-col h-full overflow-hidden pointer-events-auto"
                            >
                                <!-- Drawer Header -->
                                <div class="px-6 py-5 border-b border-slate-800/80 flex items-center justify-between bg-slate-900/90 backdrop-blur sticky top-0 z-10">
                                    <div>
                                        <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                            Daggerheart SRD
                                        </span>
                                        <h2 class="font-serif text-xl sm:text-2xl font-bold text-white uppercase mt-1">
                                            {{ activeDrawerItem.data.name }}
                                        </h2>
                                    </div>
                                    <button
                                        @click="closeDrawer"
                                        class="text-slate-400 hover:text-white p-2 rounded-xl hover:bg-slate-800 transition-colors"
                                        title="Close (Esc)"
                                    >
                                        <X class="w-5 h-5" />
                                    </button>
                                </div>

                            <!-- Drawer Scrollable Content -->
                            <div class="flex-1 overflow-y-auto p-6 sm:p-8 space-y-7 max-w-prose mx-auto w-full">

                                <!-- CLASS DETAILS -->
                                <template v-if="activeDrawerItem.type === 'class'">
                                    <!-- Domains -->
                                    <div class="flex flex-wrap gap-2">
                                        <span
                                            v-for="d in activeDrawerItem.data.primary_domains"
                                            :key="d"
                                            class="text-xs font-semibold px-3 py-1 rounded-full border tracking-wide"
                                            :class="domainColors[d]?.badge || 'bg-slate-800 text-slate-300 border-slate-700'"
                                        >
                                            Primary Domain: {{ d }}
                                        </span>
                                    </div>

                                    <!-- Lore & Overview -->
                                    <p class="text-sm sm:text-base text-slate-200 leading-relaxed font-normal">
                                        {{ activeDrawerItem.data.description }}
                                    </p>

                                    <!-- Vitals Grid -->
                                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 sm:gap-3">
                                        <div class="bg-slate-950/90 border border-slate-800/90 rounded-xl p-3 text-center flex flex-col justify-between shadow-inner">
                                            <div class="text-[11px] text-slate-400 uppercase font-semibold tracking-wider whitespace-nowrap">Evasion</div>
                                            <div class="font-serif font-black text-xl sm:text-2xl text-slate-100 mt-1">{{ activeDrawerItem.data.starting_evasion }}</div>
                                        </div>
                                        <div class="bg-slate-950/90 border border-slate-800/90 rounded-xl p-3 text-center flex flex-col justify-between shadow-inner">
                                            <div class="text-[11px] text-slate-400 uppercase font-semibold tracking-wider whitespace-nowrap">
                                                <span class="sm:hidden">HP</span>
                                                <span class="hidden sm:inline">Hit Points</span>
                                            </div>
                                            <div class="font-serif font-black text-xl sm:text-2xl text-emerald-400 mt-1">{{ activeDrawerItem.data.starting_hit_points }}</div>
                                        </div>
                                        <div class="bg-slate-950/90 border border-slate-800/90 rounded-xl p-3 text-center flex flex-col justify-between shadow-inner">
                                            <div class="text-[11px] text-slate-400 uppercase font-semibold tracking-wider whitespace-nowrap">Stress</div>
                                            <div class="font-serif font-black text-xl sm:text-2xl text-purple-400 mt-1">{{ activeDrawerItem.data.starting_stress }}</div>
                                        </div>
                                        <div class="bg-slate-950/90 border border-slate-800/90 rounded-xl p-3 text-center flex flex-col justify-between shadow-inner">
                                            <div class="text-[11px] text-slate-400 uppercase font-semibold tracking-wider whitespace-nowrap">Thresholds</div>
                                            <div class="font-serif font-bold text-sm sm:text-base text-amber-300 mt-1.5 whitespace-nowrap">
                                                {{ activeDrawerItem.data.base_major_threshold }} / {{ activeDrawerItem.data.base_severe_threshold }}+
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Class Features -->
                                    <div class="space-y-5">
                                        <h3 class="font-serif text-sm font-bold text-slate-400 uppercase tracking-widest">
                                            Core Class Abilities
                                        </h3>

                                        <div class="bg-slate-950/80 border border-slate-800 rounded-2xl p-5 sm:p-6 shadow-sm">
                                            <div class="font-serif text-base font-bold text-amber-300 mb-2 flex items-center gap-2">
                                                <Sparkles class="w-4 h-4 text-amber-400 shrink-0" />
                                                <span>{{ activeDrawerItem.data.class_feature_name }}</span>
                                            </div>
                                            <p class="text-sm text-slate-200 leading-relaxed">
                                                {{ activeDrawerItem.data.class_feature_description }}
                                            </p>
                                        </div>

                                        <div class="bg-slate-950/80 border border-slate-800 rounded-2xl p-5 sm:p-6 shadow-sm">
                                            <div class="font-serif text-base font-bold text-amber-300 mb-2 flex items-center gap-2">
                                                <Flame class="w-4 h-4 text-amber-400 shrink-0" />
                                                <span>Hope Feature: {{ activeDrawerItem.data.hope_feature_name }}</span>
                                            </div>
                                            <p class="text-sm text-slate-200 leading-relaxed">
                                                {{ activeDrawerItem.data.hope_feature_description }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Subclasses -->
                                    <div v-if="activeDrawerItem.data.subclasses?.length" class="space-y-4 pt-2">
                                        <h3 class="font-serif text-base font-bold text-white uppercase tracking-wide flex items-center gap-2">
                                            <Shield class="w-4 h-4 text-amber-400" />
                                            <span>Subclasses</span>
                                        </h3>
                                        <div class="space-y-4">
                                            <div
                                                v-for="sub in activeDrawerItem.data.subclasses"
                                                :key="sub.id"
                                                class="bg-slate-950/70 border border-slate-800/90 rounded-2xl p-5 sm:p-6"
                                            >
                                                <div class="flex flex-wrap items-center justify-between gap-2 mb-2 pb-2 border-b border-slate-800/80">
                                                    <div class="font-serif text-lg font-bold text-amber-200 uppercase tracking-wide">
                                                        {{ sub.name }}
                                                    </div>
                                                    <span v-if="sub.spellcast_trait" class="text-xs text-amber-400/90 font-mono bg-amber-500/10 border border-amber-500/20 px-2 py-0.5 rounded">
                                                        Spellcast Trait: {{ sub.spellcast_trait }}
                                                    </span>
                                                </div>
                                                <p class="text-sm text-slate-300 leading-relaxed mb-4">{{ sub.description }}</p>

                                                <div class="space-y-3.5 text-sm">
                                                    <div class="bg-slate-900/60 border border-slate-850 p-3.5 rounded-xl">
                                                        <div class="text-xs font-bold text-amber-400 uppercase tracking-wider mb-1">
                                                            Foundation: <span class="text-slate-100 font-serif normal-case text-sm">{{ sub.foundation_feature_name }}</span>
                                                        </div>
                                                        <p class="text-sm text-slate-300 leading-relaxed">{{ sub.foundation_feature_description }}</p>
                                                    </div>
                                                    <div v-if="sub.specialization_feature_name" class="bg-slate-900/60 border border-slate-850 p-3.5 rounded-xl">
                                                        <div class="text-xs font-bold text-amber-400 uppercase tracking-wider mb-1">
                                                            Specialization: <span class="text-slate-100 font-serif normal-case text-sm">{{ sub.specialization_feature_name }}</span>
                                                        </div>
                                                        <p class="text-sm text-slate-300 leading-relaxed">{{ sub.specialization_feature_description }}</p>
                                                    </div>
                                                    <div v-if="sub.mastery_feature_name" class="bg-slate-900/60 border border-slate-850 p-3.5 rounded-xl">
                                                        <div class="text-xs font-bold text-amber-400 uppercase tracking-wider mb-1">
                                                            Mastery: <span class="text-slate-100 font-serif normal-case text-sm">{{ sub.mastery_feature_name }}</span>
                                                        </div>
                                                        <p class="text-sm text-slate-300 leading-relaxed">{{ sub.mastery_feature_description }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <!-- ANCESTRY DETAILS -->
                                <template v-if="activeDrawerItem.type === 'ancestry'">
                                    <p class="text-sm sm:text-base text-slate-200 leading-relaxed font-normal">
                                        {{ activeDrawerItem.data.description }}
                                    </p>

                                    <div class="space-y-4 pt-2">
                                        <h3 class="font-serif text-sm font-bold text-slate-400 uppercase tracking-widest">
                                            Ancestral Features
                                        </h3>
                                        <div
                                            v-for="(feat, idx) in activeDrawerItem.data.features"
                                            :key="idx"
                                            class="bg-slate-950/80 border border-slate-800 rounded-2xl p-5 sm:p-6"
                                        >
                                            <div class="font-serif text-base font-bold text-amber-300 mb-2 flex items-center gap-2">
                                                <Sparkles class="w-4 h-4 text-amber-400 shrink-0" />
                                                <span>{{ feat.name }}</span>
                                            </div>
                                            <p class="text-sm text-slate-200 leading-relaxed">
                                                {{ feat.description }}
                                            </p>
                                        </div>
                                    </div>
                                </template>

                                <!-- COMMUNITY DETAILS -->
                                <template v-if="activeDrawerItem.type === 'community'">
                                    <p class="text-sm sm:text-base text-slate-200 leading-relaxed font-normal">
                                        {{ activeDrawerItem.data.description }}
                                    </p>

                                    <div class="space-y-4 pt-2">
                                        <h3 class="font-serif text-sm font-bold text-slate-400 uppercase tracking-widest">
                                            Community Features
                                        </h3>
                                        <div
                                            v-for="(feat, idx) in activeDrawerItem.data.features"
                                            :key="idx"
                                            class="bg-slate-950/80 border border-slate-800 rounded-2xl p-5 sm:p-6"
                                        >
                                            <div class="font-serif text-base font-bold text-amber-300 mb-2 flex items-center gap-2">
                                                <Compass class="w-4 h-4 text-amber-400 shrink-0" />
                                                <span>{{ feat.name }}</span>
                                            </div>
                                            <p class="text-sm text-slate-200 leading-relaxed">
                                                {{ feat.description }}
                                            </p>
                                        </div>
                                    </div>
                                </template>

                                <!-- DOMAIN CARD DETAILS -->
                                <template v-if="activeDrawerItem.type === 'card'">
                                    <div class="flex items-center justify-between gap-2">
                                        <div class="text-xs uppercase tracking-wider font-semibold flex items-center gap-1.5">
                                            <span class="text-slate-400">{{ activeDrawerItem.data.type }}</span>
                                            <span class="text-slate-600 font-bold">•</span>
                                            <span :class="domainColors[activeDrawerItem.data.domain]?.text || 'text-amber-400'">
                                                {{ activeDrawerItem.data.domain }} Domain
                                            </span>
                                        </div>
                                        <span class="text-xs text-slate-400 font-mono">
                                            Level {{ activeDrawerItem.data.level }}
                                        </span>
                                    </div>

                                    <div class="bg-slate-950/90 border border-slate-800 rounded-2xl p-6 sm:p-7 shadow-inner">
                                        <div class="text-xs font-bold text-amber-400 uppercase tracking-widest mb-3">
                                            Ability Text & Rules
                                        </div>
                                        <p class="text-sm sm:text-base text-slate-100 leading-relaxed font-normal">
                                            {{ activeDrawerItem.data.description }}
                                        </p>
                                    </div>

                                    <div class="text-xs text-slate-400 flex items-center justify-between pt-4 border-t border-slate-800">
                                        <span>Type: <strong class="text-slate-200">{{ activeDrawerItem.data.type }}</strong></span>
                                        <span class="text-slate-500">System Reference Document (SRD)</span>
                                    </div>
                                </template>

                            </div>

                            <!-- Drawer Footer -->
                            <div class="p-4 border-t border-slate-800 bg-slate-950 flex items-center justify-between text-xs text-slate-500">
                                <span>Darrington Press DPCGL SRD</span>
                                <button
                                    @click="closeDrawer"
                                    class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold transition-colors"
                                >
                                    Close
                                </button>
                            </div>

                        </div>
                    </Transition>
                </div>
            </div>
        </Teleport>
        </div>
    </AppLayout>
</template>
