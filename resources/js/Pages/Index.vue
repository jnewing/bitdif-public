<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const form = useForm({
    images: [],
});

const hoveringDropzone = ref(false)

const dropFile = (event) => {
    form.images = [
        ...form.images,
        ...event.dataTransfer.files
    ];

    form.post('/img', {
        onFinish: () => {
            form.images = []
        }
    });
};

const selectFile = (event) => {
    form.images = [
        ...form.images,
        ...event.target.files
    ];

    form.post('/img', {
        onFinish: () => {
            form.images = []
        }
    });
};

// const pasteFile = (event) => {
//     form.images = [
//         ...form.images,
//         ...event.clipboardData.files
//     ]

//     form.post('upload', {
//         onFinish: () => {
//             form.images = []
//         }
//     })
// };

</script>

<template>
    <AuthenticatedLayout v-if="$page.props.auth.user">
        <div class="pt-10">

            <form v-if="!form.progress" @submit.prevent="submit" class="flex flex-col items-center space-y-8">
                <div class="flex items-center justify-center w-full">
                    <label
                        for="dropzone-file"
                        class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer dark:border-accent text-primary"
                        :class="{'dark:border-white': hoveringDropzone}"
                        @dragover.prevent="hoveringDropzone = true"
                        @dragleave.prevent="hoveringDropzone = false"
                        @drop.prevent="dropFile"
                        @change.prevent="selectFile">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 text-sm">
                                Drag & drop your image, or click to browse.
                            </p>
                        </div>
                        <input id="dropzone-file" type="file" class="hidden" />
                    </label>
                </div>

                <div class="w-full">
                    <!-- <Input placeholder="or paste shot" class="text-center" @paste.prevent="pasteFile"/> -->

                    <div v-if="form.errors" class="text-red-500">
                        {{ Object.values(form.errors)[0] }}
                    </div>
                </div>
            </form>

        </div>
    </AuthenticatedLayout>
</template>
