<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import moment from 'moment';
import { ClipboardIcon, CheckCircleIcon } from '@heroicons/vue/24/outline';

import InputError from '@/Components/InputError.vue';

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
    hasKey: {
        type: Boolean,
        required: true,
    },
});

const emit = defineEmits(['token']);

const icon = ref(ClipboardIcon);
const iconColour = ref('text-gray-400');

const form = useForm({
    apikey: '',
});

const updateAPIKey = () => {
    form.put(route('settings.apikey'), {
        preserveScroll: true,
        onSuccess: (data) => {
            // if we have reset show them the new key only ONCE
            form.reset()
            emit('token');
        },
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

const copyToClipboard = async (i) => {
    try {
        await navigator.clipboard.writeText(i);
        icon.value = CheckCircleIcon;
        iconColour.value = 'text-green-400';
        setTimeout(() => {
            icon.value = ClipboardIcon;
            iconColour.value = 'text-gray-400';
        }, 2000);   // change back to ClipboardIcon after 2 seconds
    } catch (err) {
        console.error('Failed to copy: ', err);
    }
};

</script>

<template>
    <section>
        <div class="grid grid-cols-1 gap-x-8 gap-y-8 pt-10 md:grid-cols-3">
            <div class="px-4 sm:px-0">
                <h2 class="text-base font-semibold leading-7 text-gray-200">Update API Key</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">Update or set your API Key. After the key is set you will be shown the key only once.</p>
            </div>

            <form @submit.prevent="updateAPIKey" class="bg-space-950 ring-1 ring-gray-900/5 rounded md:col-span-2">
                <div class="px-4 py-6 sm:p-8">
                    <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div v-if="$page.props.flash.message" class="sm:col-span-10">
                            <div class="mt-2 flex rounded-md shadow-sm">
                                <div class="relative flex flex-grow items-stretch focus-within:z-10">
                                    <input type="text" id="apikey" class="block w-full rounded-none rounded-l border-0 py-1.5 pl-2 text-sm bg-space-900 text-gray-200 focus:ring-elime-600 focus:border-elime-600" readonly :value="$page.props.flash.message" />
                                </div>
                                <button type="button" @click.prevent="copyToClipboard($page.props.flash.message)" class="relative -ml-px inline-flex items-center gap-x-1.5 rounded-r-md px-3 py-2 text-sm font-semibold text-gray-400 ring-1 ring-inset ring-space-900 hover:bg-space-800">
                                    <component :is="icon" :class="['-ml-0.5 h-5 w-5', iconColour]" aria-hidden="true" />
                                </button>
                            </div>
                        </div>

                        <div class="sm:col-span-10">
                            <p v-if="$page.props.flash.message" class="text-yellow-600 text-sm">
                                You API key has now been set and is displayed above. Remember to copy it as it will not be retrieveable after you navigate away from this page.
                            </p>
                            <p v-else-if="hasKey" class="text-gray-400 text-sm">
                                API Key was last set <span class="font-semibold text-gray-200">{{ moment(user.token_set_at).fromNow() }}</span>
                            </p>
                            <p v-else class="text-gray-400 text-sm">
                                Your API Key is not set. Click the button below to set it.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-x-6 border-t border-gray-600/10 px-4 py-3 bg-black/5  sm:px-8">
                    <button type="submit" class="rounded-md bg-elime-600 px-3 py-2 text-sm font-semibold text-white hover:bg-elime-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-elime-600">
                        <span v-if="hasKey">Reset API Key</span>
                        <span v-else>Set API Key</span>
                    </button>
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
