<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

import InputError from '@/Components/InputError.vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <section>
        <div class="grid grid-cols-1 gap-x-8 gap-y-8 pt-10 md:grid-cols-3">
            <div class="px-4 sm:px-0">
                <h2 class="text-base font-semibold leading-7 text-gray-200">Update Password</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">Ensure your account is using a long, random password to stay secure.</p>
            </div>

            <form @submit.prevent="updatePassword" class="bg-space-950 ring-1 ring-gray-900/5 rounded md:col-span-2">
                <div class="px-4 py-6 sm:p-8">
                    <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="sm:col-span-10">
                            <label for="first-name" class="block text-sm font-medium leading-6 text-gray-400">Current Password</label>
                            <div class="mt-2">
                                <input type="password" v-model="form.current_password" id="current-password" class="block w-full rounded border-0 py-1.5 bg-space-900 text-gray-200 ring-1 ring-inset ring-space-800 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-elime-600 sm:text-sm sm:leading-6" />
                            </div>
                            <InputError :message="form.errors.current_password" class="mt-2" />
                        </div>

                        <div class="sm:col-span-10">
                            <label for="last-name" class="block text-sm font-medium leading-6 text-gray-400">New Password</label>
                            <div class="mt-2">
                                <input type="password" v-model="form.password" id="new-password" class="block w-full rounded border-0 py-1.5 bg-space-900 text-gray-200 ring-1 ring-inset ring-space-800 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-elime-600 sm:text-sm sm:leading-6" />
                            </div>
                            <InputError :message="form.errors.password" class="mt-2" />
                        </div>

                        <div class="sm:col-span-10">
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-400">Confirm Password</label>
                            <div class="mt-2">
                                <input id="password-confirmation" v-model="form.password_confirmation" type="password" class="block w-full rounded border-0 py-1.5 bg-space-900 text-gray-200 ring-1 ring-inset ring-space-800 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-elime-600 sm:text-sm sm:leading-6" />
                            </div>
                            <InputError :message="form.errors.password_confirmation" class="mt-2" />
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-x-6 border-t border-gray-600/10 px-4 py-3 bg-black/5  sm:px-8">
                    <button type="submit" class="rounded-md bg-elime-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-elime-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-elime-600">Update Password</button>
                    <Transition
                        enter-active-class="transition ease-in-out"
                        enter-from-class="opacity-0"
                        leave-active-class="transition ease-in-out"
                        leave-to-class="opacity-0"
                    >
                        <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">Saved.</p>
                    </Transition>
                </div>
            </form>
        </div>
    </section>
</template>
