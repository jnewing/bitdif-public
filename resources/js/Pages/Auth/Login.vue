<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { Bars3Icon, BellIcon, XMarkIcon, ExclamationTriangleIcon } from '@heroicons/vue/24/outline';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    canRegister: {
        type: Boolean,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

</script>

<template>
    <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <a href="/"><img src="/logo/logo.svg" class="mx-auto h-20 w-auto" alt="bitdif.com" /></a>
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-white">Sign in to your account
            </h2>
        </div>

        <div v-if="form.errors.email || form.errors.password" class="mt-5 sm:mx-auto sm:w-full sm:max-w-sm">
            <div class="border-l-4 border-red-400 bg-red-50/10 p-4 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <ExclamationTriangleIcon class="h-5 w-5 text-red-400" aria-hidden="true" />
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">
                            Invalid email or password.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" @submit.prevent="submit">
                <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-white">Email address</label>
                    <div class="mt-2">
                        <input v-model="form.email" type="email" autocomplete="email" required=""
                            class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white ring-1 ring-inset ring-white/10 focus:ring-1 focus:ring-inset focus:ring-elime-500 sm:text-sm sm:leading-6" />
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium leading-6 text-white">Password</label>
                        <div class="text-sm">
                            <a :href="route('password.request')"
                                class="font-semibold text-elime-400 hover:text-elime-300">Forgot password?</a>
                        </div>
                    </div>
                    <div class="mt-2">
                        <input v-model="form.password" type="password" autocomplete="current-password" required=""
                            class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-1 focus:ring-inset focus:ring-elime-500 sm:text-sm sm:leading-6" />
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-md bg-elime-600 px-3 py-1.5 text-sm font-semibold leading-6 text-space-950 hover:bg-elime-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500"
                        :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Sign in
                    </button>
                </div>
            </form>

            <p v-if="canRegister" class="mt-10 text-center text-sm text-gray-400">
                Not a member?
                {{ ' ' }}
                <a :href="route('register')"
                    class="font-semibold leading-6 text-elime-400 hover:text-elime-300">Register an account.</a>
            </p>
        </div>
    </div>
</template>
