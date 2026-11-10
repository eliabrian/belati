<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Shield, User, Lock, ArrowRight } from 'lucide-vue-next';

const form = useForm({
    username: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post('/login', {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <AppLayout>
        <Head title="Log In" />

        <div class="max-w-md mx-auto px-4 py-12 sm:py-16">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-400 mb-3 shadow-inner">
                    <Shield class="w-6 h-6" />
                </div>
                <h1 class="font-serif text-2xl sm:text-3xl font-bold text-amber-100 tracking-wide">
                    Welcome Back
                </h1>
                <p class="text-xs sm:text-sm text-slate-400 mt-2">
                    Enter your username and password to access your character sheets.
                </p>
            </div>

            <div class="bg-slate-900/70 border border-slate-800 rounded-2xl p-6 sm:p-8 backdrop-blur shadow-2xl shadow-black/50">
                <form @submit.prevent="submit" class="space-y-4">
                    <!-- Username -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">
                            Username
                        </label>
                        <div class="relative">
                            <User class="w-4 h-4 text-slate-500 absolute left-3.5 top-1/2 -translate-y-1/2" />
                            <input
                                v-model="form.username"
                                type="text"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="Your username"
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
                            Password
                        </label>
                        <div class="relative">
                            <Lock class="w-4 h-4 text-slate-500 absolute left-3.5 top-1/2 -translate-y-1/2" />
                            <input
                                v-model="form.password"
                                type="password"
                                required
                                autocomplete="current-password"
                                placeholder="••••••••"
                                class="w-full bg-slate-950 border border-slate-800 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 rounded-xl pl-10 pr-3.5 py-2.5 text-sm text-slate-100 placeholder-slate-600 transition-colors"
                            />
                        </div>
                        <p v-if="form.errors.password" class="text-rose-400 text-xs mt-1.5">
                            {{ form.errors.password }}
                        </p>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between text-xs pt-1">
                        <label class="flex items-center gap-2 cursor-pointer text-slate-300">
                            <input
                                v-model="form.remember"
                                type="checkbox"
                                class="rounded border-slate-800 bg-slate-950 text-amber-500 focus:ring-amber-500 focus:ring-offset-slate-900"
                            />
                            <span>Stay logged in</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full mt-2 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-bold py-3 px-4 rounded-xl shadow-lg shadow-amber-500/20 flex items-center justify-center gap-2 transition-all hover:scale-[1.01] active:scale-[0.99] disabled:opacity-50"
                    >
                        <span>Log In</span>
                        <ArrowRight class="w-4 h-4" />
                    </button>
                </form>

                <div class="mt-6 text-center text-xs text-slate-400">
                    Need an account?
                    <Link href="/register" class="text-amber-400 hover:underline font-medium ml-1">
                        Create one now
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

