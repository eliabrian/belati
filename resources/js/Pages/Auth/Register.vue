<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Shield, Sparkles, User, Lock, Mail, ArrowRight } from 'lucide-vue-next';

const form = useForm({
    username: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post('/register', {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <AppLayout>
        <Head title="Create Privacy-First Account" />

        <div class="max-w-md mx-auto px-4 py-12 sm:py-16">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-400 mb-3 shadow-inner">
                    <Shield class="w-6 h-6" />
                </div>
                <h1 class="font-serif text-2xl sm:text-3xl font-bold text-amber-100 tracking-wide">
                    Create Account
                </h1>
                <p class="text-xs sm:text-sm text-slate-400 mt-2">
                    Privacy-first gaming. We don't ask for your name or track your sessions.
                </p>
            </div>

            <div class="bg-slate-900/70 border border-slate-800 rounded-2xl p-6 sm:p-8 backdrop-blur shadow-2xl shadow-black/50">
                <form @submit.prevent="submit" class="space-y-4">
                    <!-- Username -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">
                            Username <span class="text-amber-400">*</span>
                        </label>
                        <div class="relative">
                            <User class="w-4 h-4 text-slate-500 absolute left-3.5 top-1/2 -translate-y-1/2" />
                            <input
                                v-model="form.username"
                                type="text"
                                required
                                autocomplete="username"
                                placeholder="e.g. BladeWeaver"
                                class="w-full bg-slate-950 border border-slate-800 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 rounded-xl pl-10 pr-3.5 py-2.5 text-sm text-slate-100 placeholder-slate-600 transition-colors"
                            />
                        </div>
                        <p v-if="form.errors.username" class="text-rose-400 text-xs mt-1.5">
                            {{ form.errors.username }}
                        </p>
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">
                            Password <span class="text-amber-400">*</span>
                        </label>
                        <div class="relative">
                            <Lock class="w-4 h-4 text-slate-500 absolute left-3.5 top-1/2 -translate-y-1/2" />
                            <input
                                v-model="form.password"
                                type="password"
                                required
                                autocomplete="new-password"
                                placeholder="••••••••"
                                class="w-full bg-slate-950 border border-slate-800 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 rounded-xl pl-10 pr-3.5 py-2.5 text-sm text-slate-100 placeholder-slate-600 transition-colors"
                            />
                        </div>
                        <p v-if="form.errors.password" class="text-rose-400 text-xs mt-1.5">
                            {{ form.errors.password }}
                        </p>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">
                            Confirm Password <span class="text-amber-400">*</span>
                        </label>
                        <div class="relative">
                            <Lock class="w-4 h-4 text-slate-500 absolute left-3.5 top-1/2 -translate-y-1/2" />
                            <input
                                v-model="form.password_confirmation"
                                type="password"
                                required
                                autocomplete="new-password"
                                placeholder="••••••••"
                                class="w-full bg-slate-950 border border-slate-800 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 rounded-xl pl-10 pr-3.5 py-2.5 text-sm text-slate-100 placeholder-slate-600 transition-colors"
                            />
                        </div>
                    </div>

                    <!-- Optional Email -->
                    <div class="pt-2 border-t border-slate-800/80">
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="text-xs font-semibold text-slate-300 uppercase tracking-wider">
                                Recovery Email
                            </label>
                            <span class="text-[10px] text-amber-400/90 font-medium bg-amber-500/10 px-2 py-0.5 rounded-full border border-amber-500/20">
                                Optional / Burner friendly
                            </span>
                        </div>
                        <div class="relative">
                            <Mail class="w-4 h-4 text-slate-500 absolute left-3.5 top-1/2 -translate-y-1/2" />
                            <input
                                v-model="form.email"
                                type="email"
                                autocomplete="email"
                                placeholder="Optional (for password reset only)"
                                class="w-full bg-slate-950 border border-slate-800 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 rounded-xl pl-10 pr-3.5 py-2.5 text-sm text-slate-100 placeholder-slate-600 transition-colors"
                            />
                        </div>
                        <p class="text-[11px] text-slate-500 mt-1">
                            Only used if you need to recover a lost password. Never shared or marketed.
                        </p>
                        <p v-if="form.errors.email" class="text-rose-400 text-xs mt-1">
                            {{ form.errors.email }}
                        </p>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full mt-2 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-bold py-3 px-4 rounded-xl shadow-lg shadow-amber-500/20 flex items-center justify-center gap-2 transition-all hover:scale-[1.01] active:scale-[0.99] disabled:opacity-50"
                    >
                        <span>Create Account</span>
                        <ArrowRight class="w-4 h-4" />
                    </button>
                </form>

                <div class="mt-6 text-center text-xs text-slate-400">
                    Already have an account?
                    <Link href="/login" class="text-amber-400 hover:underline font-medium ml-1">
                        Log in here
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

