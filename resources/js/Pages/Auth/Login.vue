<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: true,
});

const showErrorToast = ref(false);
const errorMessage = ref('');
const isPasswordVisible = ref(false);
const passwordInput = ref(null);

const togglePasswordVisibility = () => {
    // Sync browser autofill value before toggling type, otherwise Vue clears it
    if (passwordInput.value && passwordInput.value.value) {
        form.password = passwordInput.value.value;
    }
    isPasswordVisible.value = !isPasswordVisible.value;
};

const page = usePage();

onMounted(() => {
    if (!page.props.auth?.user) {
        localStorage.removeItem('duc_user_email');
        localStorage.removeItem('duc_user_logged_in');
    }
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
        onSuccess: () => {
            localStorage.setItem('duc_user_email', form.email);
            localStorage.setItem('duc_user_logged_in', 'true');
        },
        onError: (errors) => {
            errorMessage.value = Object.values(errors).join('\n') || 'Please check your credentials and try again.';
            showErrorToast.value = true;
            setTimeout(() => {
                showErrorToast.value = false;
            }, 4000);
        }
    });
};
</script>

<template>
    <GuestLayout noCard>
        <Head title="Log in" />

        <!-- Custom Sleek Toast Alert -->
        <Teleport to="body">
            <Transition
                enter-active-class="transform ease-out duration-300 transition"
                enter-from-class="translate-y-[-100%] opacity-0 sm:translate-y-0 sm:translate-x-full"
                enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
                leave-active-class="transition ease-in duration-200"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0 translate-y-[-100%] sm:translate-y-0 sm:translate-x-full"
            >
                <div v-if="showErrorToast" class="fixed top-5 right-5 z-[150] flex items-start w-full max-w-sm p-4 overflow-hidden bg-slate-900/90 backdrop-blur-xl border border-red-500/30 rounded-2xl shadow-[0_8px_30px_rgb(220,38,38,0.2)] pointer-events-auto">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center w-10 h-10 bg-red-500/10 rounded-full border border-red-500/20">
                            <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 w-0 ml-4 pt-0.5">
                        <p class="text-sm font-bold text-white">Login Failed</p>
                        <p class="mt-1 text-xs text-slate-400 font-medium">{{ errorMessage }}</p>
                    </div>
                    <div class="flex-shrink-0 ml-4 flex">
                        <button @click="showErrorToast = false" class="inline-flex text-slate-400 bg-white/0 rounded-md hover:text-slate-350 focus:outline-none transition-colors">
                            <span class="sr-only">Close</span>
                            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </Transition>
        </Teleport>

        <!-- Premium Double-Panel Split Layout Card with Blue Glowing Shadow -->
        <div class="z-10 relative w-full max-w-4xl mx-4 overflow-hidden rounded-3xl bg-[#090d16] border border-blue-500/20 shadow-[0_0_50px_rgba(37,99,235,0.15)] flex flex-col md:flex-row min-h-[520px]">
            
            <!-- Left Column: Gradient Banner Panel with Logo and Title -->
            <div class="w-full md:w-[42%] bg-gradient-to-br from-blue-600 via-indigo-650 to-indigo-900 flex flex-col items-center justify-center p-8 text-center relative overflow-hidden md:clip-polygon">
                <!-- Subtle geometric overlay for design depth -->
                <div class="absolute inset-0 opacity-10 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-white via-transparent to-transparent"></div>
                
                <div class="relative z-10 flex flex-col items-center">
                    <div class="mb-5 p-4 rounded-3xl bg-black/10 backdrop-blur-md border border-white/10 shadow-lg">
                        <ApplicationLogo class="h-20 w-auto object-contain drop-shadow-2xl hover:scale-105 transition-transform duration-300" />
                    </div>
                    
                    <h1 class="text-xl md:text-2xl font-black text-white tracking-wider uppercase leading-snug">
                        Digital University <br class="hidden md:inline"/> of Cambodia
                    </h1>
                    
                    <p class="mt-4 text-xs font-semibold text-blue-100 max-w-xs leading-relaxed opacity-95">
                        Welcome! We hope you and your family have a wonderful day.
                    </p>
                </div>
            </div>

            <!-- Right Column: Minimalist Dark Login Form Panel -->
            <div class="w-full md:w-[58%] bg-[#0c101b] p-8 md:p-12 flex flex-col justify-center">
                <div class="mb-8">
                    <h2 class="text-2xl font-extrabold text-white tracking-tight">Sign In</h2>
                    <p class="mt-1.5 text-xs font-semibold text-slate-400">Access the administrator panel and site settings.</p>
                </div>

                <div v-if="status" class="mb-4 text-xs font-medium text-emerald-400 bg-emerald-500/10 p-4 rounded-xl border border-emerald-500/20">
                    {{ status }}
                </div>

                <form @submit.prevent="submit" class="space-y-6">
                    <div>
                        <InputLabel for="email" value="Email Address" class="font-bold text-[10px] text-slate-400 uppercase tracking-widest mb-2" />

                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                                </svg>
                            </div>
                            <input
                                id="email"
                                type="email"
                                class="block w-full pl-10 pr-4 py-2.5 bg-transparent border-b-2 border-slate-700 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-0 transition duration-300"
                                v-model="form.email"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="name@duc.edu.kh"
                            />
                        </div>

                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div>
                        <InputLabel for="password" value="Password" class="font-bold text-[10px] text-slate-400 uppercase tracking-widest mb-2" />

                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input
                                id="password"
                                ref="passwordInput"
                                :type="isPasswordVisible ? 'text' : 'password'"
                                class="block w-full pl-10 pr-10 py-2.5 bg-transparent border-b-2 border-slate-700 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-0 transition duration-300"
                                v-model="form.password"
                                required
                                autocomplete="current-password"
                                placeholder="••••••••"
                            />
                            <button
                                type="button"
                                @click="togglePasswordVisibility"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-500 hover:text-blue-400 transition-colors focus:outline-none"
                            >
                                <svg v-if="!isPasswordVisible" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>

                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <label class="flex items-center cursor-pointer select-none">
                            <Checkbox name="remember" v-model:checked="form.remember" class="rounded border-slate-700 bg-slate-800 text-blue-500 focus:ring-blue-500/20" />
                            <span class="ms-2 text-xs text-slate-400 font-semibold">Remember me</span>
                        </label>

                        <Link
                            v-if="canResetPassword"
                            :href="route('password.request')"
                            class="text-xs font-bold text-blue-500 hover:text-blue-400 transition-colors"
                        >
                            Forgot password?
                        </Link>
                    </div>

                    <div class="pt-4">
                        <button
                            type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-full shadow-[0_4px_20px_rgba(37,99,235,0.35)] text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 transition-all duration-300 transform hover:-translate-y-0.5 active:translate-y-0"
                            :class="{ 'opacity-70 cursor-not-allowed': form.processing }"
                            :disabled="form.processing"
                        >
                            Sign In
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>

<style scoped>
@media (min-width: 768px) {
    .clip-polygon {
        clip-path: polygon(0 0, 100% 0, 90% 100%, 0% 100%);
    }
}

input[type="email"],
input[type="password"],
input[type="text"] {
    background-color: transparent !important;
    border-radius: 0px !important;
    border-top: none !important;
    border-left: none !important;
    border-right: none !important;
    box-shadow: none !important;
}

/* Clear autofill styles from browser */
input[type="email"]:-webkit-autofill,
input[type="email"]:-webkit-autofill:hover, 
input[type="email"]:-webkit-autofill:focus, 
input[type="email"]:-webkit-autofill:active,
input[type="password"]:-webkit-autofill,
input[type="password"]:-webkit-autofill:hover, 
input[type="password"]:-webkit-autofill:focus, 
input[type="password"]:-webkit-autofill:active,
input[type="text"]:-webkit-autofill,
input[type="text"]:-webkit-autofill:hover, 
input[type="text"]:-webkit-autofill:focus, 
input[type="text"]:-webkit-autofill:active {
    -webkit-box-shadow: 0 0 0 30px #0c101b inset !important;
    -webkit-text-fill-color: white !important;
    transition: background-color 5000s ease-in-out 0s;
}
</style>
