<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    max_size: Number,
});

const bulkUpload = useForm({
    zipfile: null,
});

</script>

<template>
    
    <div class="relative mb-8">
        <div class="absolute inset-0 flex items-center" aria-hidden="true">
            <div class="w-full border-t border-space-900" />
        </div>
        <div class="relative flex justify-center">
            <span class="bg-bunker-950 px-3 text-base font-semibold leading-6 text-gray-200">OR</span>
        </div>
    </div>

    <!-- bulk upload -->
    <div class="bg-space-950 sm:rounded ">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-base font-semibold leading-6 text-gray-200">Bulk Upload</h3>
            <div class="mt-2 max-w-xl text-sm text-gray-400">
                <p>You may also bulk upload images to your account by uploading a <em>.zip</em> file. The zip file will be processed however only .png and .jpg files will be processed from within the zip.</p>
                <p>MAx upload size: {{ max_size }}</p>
            </div>
            <form @submit.prevent="bulkUpload.post(route('gallery.bulk'))" class="mt-5 sm:flex sm:items-center">
                <div class="w-full">
                    <input type="file" @input="bulkUpload.zipfile = $event.target.files[0]" id="zipfile" class="block w-full rounded bg-space-900 border-0 py-1.5 text-gray-400 ring-1 ring-inset ring-space-800 focus:ring-2 focus:ring-inset focus:ring-elime-600 sm:text-sm sm:leading-6 file:mr-2 file:ml-2 file:px-2 file:py-0.5 file:bg-space-700 file:text-gray-200 file:hover:bg-space-600 file:rounded file:border-0 hover:file:cursor-pointer hover:file:bg-amber-50" />
                </div>
                <button type="submit" :disabled="bulkUpload.processing" class="mt-3 inline-flex w-full items-center justify-center rounded-md bg-elime-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-elime-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 sm:ml-3 sm:mt-0 sm:w-auto">Process</button>
            </form>
        </div>
    </div>

</template>
