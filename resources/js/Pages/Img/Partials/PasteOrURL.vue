<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const pasteForm = useForm({
    images: [],
});

const handelPaste = (event) => {
    const clipboardData = event.clipboardData;

    if (clipboardData) {
        // check for pasted files
        for (let i = 0; i < clipboardData.items.length; i++) {
            if (clipboardData.items[i].kind === 'file') {
                uploadImage(clipboardData.items[i].getAsFile());
                return;
            }
        }

        // check for pasted text
        if (isValidImageUrl(clipboardData.getData('Text'))) {
            fetchImageFromUrl(clipboardData.getData('Text'));
            return;
        }
    }
};

const isValidImageUrl = (url) => {
    return url.match(/\.(jpeg|jpg|gif|png)$/) != null;
};

const fetchImageFromUrl = async(url) => {
    try {
        const resp = await fetch(`/proxy-img?url=${encodeURIComponent(url)}`);
        const blob = await resp.blob();

        // try and get filename
        let fileName = 'posted-image';

        const contentDisposition = resp.headers.get('Content-Disposition');
        if (contentDisposition) {
            const fileNameMatch = contentDisposition.match(/filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/);
            if (fileNameMatch != null && fileNameMatch[1]) {
                fileName = fileNameMatch[1].replace(/['"]/g, '');
            }
        }

        const file = new File([blob], fileName, { type: blob.type });

        console.log(file, blob, fileName, resp.headers);

        //uploadImage(file);
    } catch (error) {
        console.error('Failed to fetch image from URL:', error);
    }
};

const uploadImage = async(file) => {
    pasteForm.images.push(file);

    pasteForm.post(route('gallery.store'), {
        onFinish: () => {
            pasteForm.images = []
        }
    });
};

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

    <!-- paste upload -->
    <div class="bg-space-950 sm:rounded ">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-base font-semibold leading-6 text-gray-200">Paste image or URL.</h3>
            <form @submit.prevent="pasteForm.post(route('gallery.paste'))" class="mt-5 sm:flex sm:items-center">
                <div class="w-full">
                    <input @paste="handelPaste" class="block w-full rounded bg-space-900 border-0 py-1.5 text-gray-400 ring-1 ring-inset ring-space-800 focus:ring-2 focus:ring-inset focus:ring-elime-600 sm:text-sm sm:leading-6 file:mr-2 file:ml-2 file:px-2 file:py-0.5 file:bg-space-700 file:text-gray-200 file:hover:bg-space-600 file:rounded file:border-0 hover:file:cursor-pointer hover:file:bg-amber-50" />
                </div>
            </form>
        </div>
    </div>

</template>
