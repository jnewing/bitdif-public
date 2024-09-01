<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { Bars3Icon, BellIcon, XMarkIcon, ExclamationTriangleIcon } from '@heroicons/vue/24/outline';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};

</script>

<template>
    <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <a href="/"><img src="/logo/logo.svg" class="mx-auto h-20 w-auto" alt="bitdif.com" /></a>
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-white">Forgot your password?
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
            <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                No problem. Just let us know your email address and we will email you a password
                reset
                link that will allow you to choose a new one.
            </div>

            <div v-if="status" class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                {{ status }}
            </div>

            <form class="space-y-6" @submit.prevent="submit">
                <div>
                    <div>
                        <label for="email" class="block text-sm font-medium leading-6 text-white">Email address</label>
                        <div class="mt-2">
                            <input v-model="form.email" type="email" autocomplete="email" required=""
                                class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white ring-1 ring-inset ring-white/10 focus:ring-1 focus:ring-inset focus:ring-elime-500 sm:text-sm sm:leading-6" />
                        </div>
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-md bg-elime-600 px-3 py-1.5 text-sm font-semibold leading-6 text-space-950 hover:bg-elime-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500"
                        :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Email Password Reset Link
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
