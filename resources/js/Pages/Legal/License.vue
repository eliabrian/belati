<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Shield, BookOpen, ExternalLink, ArrowLeft, CheckCircle2 } from 'lucide-vue-next';
</script>

<template>
    <AppLayout>
        <Head title="License & Attribution — Darrington Press Community Gaming License" />

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16">
            <Link
                href="/"
                class="inline-flex items-center gap-2 text-xs sm:text-sm text-slate-400 hover:text-amber-400 transition-colors mb-6"
            >
                <ArrowLeft class="w-4 h-4" />
                <span>Back to Home</span>
            </Link>

            <div class="border-b border-slate-800 pb-6 mb-8">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs font-semibold mb-3">
                    <Shield class="w-3.5 h-3.5" />
                    <span>DPCGL Compliance & Legal Notices</span>
                </div>
                <h1 class="font-serif text-2xl sm:text-4xl font-bold text-white uppercase tracking-wide">
                    License & Attribution
                </h1>
                <p class="text-sm text-slate-400 mt-2">
                    Belati is an independent community application developed under the Darrington Press Community Gaming License.
                </p>
            </div>

            <div class="space-y-6 text-sm leading-relaxed text-slate-300">
                <!-- Primary Attribution Statement Card -->
                <div class="bg-slate-900/80 border border-amber-500/30 rounded-2xl p-6 sm:p-8 backdrop-blur shadow-xl">
                    <h2 class="font-serif text-lg font-bold text-amber-200 mb-3 flex items-center gap-2">
                        <CheckCircle2 class="w-5 h-5 text-amber-400" />
                        <span>System Reference Document (SRD) Attribution</span>
                    </h2>
                    <blockquote class="bg-slate-950/70 border-l-4 border-amber-500 pl-4 py-3 rounded-r-xl text-slate-200 italic font-medium my-4">
                        “This product includes materials from the Daggerheart System Reference Document, © Critical Role, LLC, under the terms of the Darrington Press Community Gaming License (DPCGL). More information can be found at <a href="https://darringtonpress.com/license" target="_blank" rel="noopener noreferrer" class="text-amber-400 underline hover:text-amber-300 inline-flex items-center gap-1">www.darringtonpress.com/license <ExternalLink class="w-3 h-3" /></a>.”
                    </blockquote>
                </div>

                <!-- Non-Endorsement & Trademark Card -->
                <div class="bg-slate-900/60 border border-slate-800 rounded-2xl p-6 sm:p-8">
                    <h2 class="font-serif text-base font-bold text-slate-200 mb-3">
                        Trademark & Non-Affiliation Disclaimer
                    </h2>
                    <blockquote class="bg-slate-950/60 border-l-4 border-slate-700 pl-4 py-3 rounded-r-xl text-slate-300 my-4">
                        “Darrington Press™ and the Darrington Press authorized work logo are trademarks of Critical Role, LLC and used with permission. Belati is not affiliated with, endorsed, or sponsored by Critical Role, LLC or Darrington Press.”
                    </blockquote>
                    <p class="text-xs text-slate-400 mt-4">
                        Daggerheart is a trademark of Critical Role, LLC. All official characters, storylines, and lore remain the sole intellectual property of their respective creators and copyright holders.
                    </p>
                </div>

                <!-- Open Gaming & Privacy Commitment -->
                <div class="bg-slate-900/60 border border-slate-800 rounded-2xl p-6 sm:p-8">
                    <h2 class="font-serif text-base font-bold text-slate-200 mb-2">
                        Open Community & Privacy Commitment
                    </h2>
                    <p class="text-slate-400 text-xs sm:text-sm">
                        Belati is built with zero surveillance, zero third-party advertising tracking, and full user data sovereignty. Any SRD game mechanics and SRD data provided in Belati are presented under the DPCGL for non-commercial community play, table management, and player character tracking.
                    </p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

