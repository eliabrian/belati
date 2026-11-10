<script setup>
import { computed } from 'vue';
import { usePage, Link } from '@inertiajs/vue3';
import { Shield, BookOpen, User, LogOut, Dices, Users } from 'lucide-vue-next';

const page = usePage();
const user = computed(() => page.props.auth?.user);

const scrollToDice = (e) => {
    if (window.location.pathname === '/' || window.location.pathname === '') {
        const el = document.getElementById('dice-demo');
        if (el) {
            e.preventDefault();
            el.scrollIntoView({ behavior: 'smooth', block: 'center' });
            history.pushState(null, '', '#dice-demo');
        }
    }
};
</script>

<template>
    <div class="min-h-screen bg-slate-950 text-slate-100 flex flex-col font-sans selection:bg-amber-500 selection:text-slate-950">
        <!-- Top Navigation -->
        <header class="border-b border-slate-800/80 bg-slate-900/60 backdrop-blur sticky top-0 z-40">
            <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 h-14 sm:h-16 flex items-center justify-between gap-2">
                <Link href="/" class="group shrink-0 flex items-center">
                    <span class="font-serif text-lg sm:text-xl font-extrabold tracking-wider text-amber-100 group-hover:text-amber-400 transition-colors uppercase whitespace-nowrap">
                        Belati
                    </span>
                </Link>

                <nav class="hidden md:flex items-center gap-6 text-sm">
                    <Link href="/compendium" class="text-slate-300 hover:text-amber-400 transition-colors flex items-center gap-1.5">
                        <BookOpen class="w-4 h-4 text-amber-500" />
                        <span>Compendium</span>
                    </Link>
                    <Link href="/characters" class="text-slate-300 hover:text-amber-400 transition-colors flex items-center gap-1.5">
                        <Users class="w-4 h-4 text-amber-500" />
                        <span>Characters</span>
                    </Link>
                    <a href="/#dice-demo" @click="scrollToDice" class="text-slate-300 hover:text-amber-400 transition-colors flex items-center gap-1.5 cursor-pointer">
                        <Dices class="w-4 h-4 text-amber-500" />
                        <span>Dice Roller</span>
                    </a>
                </nav>

                <div class="flex items-center gap-1.5 sm:gap-3 shrink-0">
                    <template v-if="user">
                        <div class="flex items-center gap-1.5 sm:gap-2 bg-slate-800/60 border border-slate-700/60 px-2.5 sm:px-3 py-1.5 rounded-full text-xs">
                            <User class="w-3.5 h-3.5 text-amber-400" />
                            <span class="font-medium text-slate-200 truncate max-w-[100px] sm:max-w-none">{{ user.username }}</span>
                        </div>
                        <Link
                            href="/logout"
                            method="post"
                            as="button"
                            class="text-xs text-slate-400 hover:text-rose-400 transition-colors p-1.5 sm:p-2 rounded-lg hover:bg-slate-800/50"
                            title="Log out"
                        >
                            <LogOut class="w-4 h-4" />
                        </Link>
                    </template>
                    <template v-else>
                        <Link
                            href="/login"
                            class="whitespace-nowrap text-xs sm:text-sm font-medium text-slate-300 hover:text-white px-2.5 sm:px-3 py-1.5 rounded-lg hover:bg-slate-800 transition-colors"
                        >
                            Log In
                        </Link>
                        <Link
                            href="/register"
                            class="whitespace-nowrap text-xs sm:text-sm font-semibold bg-amber-500 hover:bg-amber-400 text-slate-950 px-2.5 sm:px-3.5 py-1.5 rounded-lg shadow-md shadow-amber-500/20 transition-all hover:scale-105"
                        >
                            <span class="hidden sm:inline">Create Account</span>
                            <span class="sm:hidden">Join</span>
                        </Link>
                    </template>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 pb-8">
            <slot />
        </main>

        <!-- Mobile Bottom Navigation Bar -->
        <nav class="md:hidden fixed bottom-0 left-0 right-0 z-40 bg-slate-900/95 backdrop-blur-md border-t border-slate-800/80 px-1 pt-1.5 pb-[max(0.5rem,env(safe-area-inset-bottom))] grid grid-cols-4 items-center">
            <Link href="/compendium" class="flex flex-col items-center justify-center gap-1 text-slate-400 hover:text-amber-400 text-[11px] py-1 transition-colors w-full rounded-lg active:bg-slate-800/50">
                <BookOpen class="w-5 h-5 text-amber-500" />
                <span class="truncate max-w-full font-medium">Compendium</span>
            </Link>
            <Link href="/characters" class="flex flex-col items-center justify-center gap-1 text-slate-400 hover:text-amber-400 text-[11px] py-1 transition-colors w-full rounded-lg active:bg-slate-800/50">
                <Users class="w-5 h-5" />
                <span class="truncate max-w-full font-medium">Characters</span>
            </Link>
            <a href="/#dice-demo" @click="scrollToDice" class="flex flex-col items-center justify-center gap-1 text-slate-400 hover:text-amber-400 text-[11px] py-1 transition-colors w-full rounded-lg active:bg-slate-800/50 cursor-pointer">
                <Dices class="w-5 h-5" />
                <span class="truncate max-w-full font-medium">Dice</span>
            </a>
            <Link :href="user ? '/logout' : '/login'" :method="user ? 'post' : 'get'" as="button" class="flex flex-col items-center justify-center gap-1 text-slate-400 hover:text-amber-400 text-[11px] py-1 transition-colors w-full rounded-lg active:bg-slate-800/50">
                <User class="w-5 h-5" />
                <span class="truncate max-w-full font-medium">{{ user ? user.username : 'Account' }}</span>
            </Link>
        </nav>

        <!-- Footer -->
        <footer class="border-t border-slate-900/80 bg-slate-950 pt-6 pb-28 md:pb-8 text-center text-xs text-slate-500">
            <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row items-center justify-between gap-3 text-center md:text-left">
                <div class="space-y-1">
                    <p class="text-slate-400 font-medium">
                        Belati is an independent companion compatible with Daggerheart™.
                    </p>
                    <p class="text-[11px] text-slate-500 max-w-2xl leading-normal">
                        This product includes materials from the Daggerheart System Reference Document, © Critical Role, LLC, under the terms of the Darrington Press Community Gaming License (DPCGL). Belati is not affiliated with, endorsed, or sponsored by Critical Role, LLC or Darrington Press.
                    </p>
                </div>
                <div class="flex items-center gap-4 text-xs shrink-0">
                    <Link href="/license" class="text-amber-500 hover:text-amber-400 underline font-medium">
                        License & Attribution
                    </Link>
                    <span class="text-slate-700">•</span>
                    <span class="flex items-center gap-1 text-slate-400">
                        <Shield class="w-3.5 h-3.5 text-emerald-400" /> Zero tracking
                    </span>
                </div>
            </div>
        </footer>
    </div>
</template>

