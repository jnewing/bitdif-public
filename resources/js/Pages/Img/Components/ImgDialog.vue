<script setup>
import { ref } from 'vue';
import { Dialog, DialogOverlay, DialogTitle, TransitionRoot, TransitionChild } from '@headlessui/vue';
import { ArrowRightCircleIcon, ArrowLeftCircleIcon } from '@heroicons/vue/24/outline';

import ImgDialogLinks from './ImgDialogLinks.vue';

const props = defineProps({
    open: {
        type: Boolean,
        required: true
    },

    image: {
        type: Object,
    },
});

const emit = defineEmits(['close', 'next', 'prev']);

const closeDialog = () => {
    emit('close');
};

const nextImage = () => {
    emit('next');
};

const previousImage = () => {
    emit('prev');
};

</script>

<template>
    <TransitionRoot as="template" :show="open" @close="closeDialog">
        <Dialog as="div" :open="open" class="fixed inset-0 z-10 overflow-y-auto" @close="closeDialog">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                    <DialogOverlay class="fixed inset-0 bg-bunker-950 bg-opacity-85 transition-opacity" />
                </TransitionChild>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div class="inline-block overflow-hidden text-left align-bottom border border-space-900 transition-all transform bg-space-950 rounded sm:my-8 sm:align-middle sm:w-full lg:max-w-4xl">
                        <div class="pr-4 pl-1 pt-4 pb-0 bg-space-950">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <DialogTitle as="h3" class="text-lg font-medium leading-6 text-white">
                                        Image Details
                                    </DialogTitle>

                                    <div class="flex">
                                        <div class="min-w-[37rem] max-w-[37rem] py-4 m-auto">
                                            <div class="relative group">
                                                <img :src="'\\' + image.img.public_path + '\\' + image.img.file_name" alt="Image" class="w-full h-full object-cover">
                                                <button @click="previousImage" class="absolute left-2 rounded top-1/2 transform -translate-y-1/2 bg-gray-800/20 text-white p-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                    <ArrowLeftCircleIcon class="h-8 w-8" />
                                                </button>
                                                <button @click="nextImage" class="absolute right-2 rounded top-1/2 transform -translate-y-1/2 bg-gray-800/20 text-white p-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                    <ArrowRightCircleIcon class="h-8 w-8" />
                                                </button>
                                            </div>
                                            <!-- <img :src="'\\' + image.public_path + '\\' + image.file_name" alt="maybe-origional-name-here" class="w-full h-auto object-cover rounded shadow"> -->
                                        </div>
                                        <div class="flex-1 py-4 pl-4">
                                            <ImgDialogLinks :imageLink="image.img" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 bg-space-950 sm:flex sm:flex-row-reverse">
                            <button type="button" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-elime-600 border border-transparent rounded hover:bg-elime-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-elime-500 sm:ml-3 sm:w-auto sm:text-sm" @click="closeDialog">
                                Close
                            </button>
                        </div>
                    </div>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
  </template>
