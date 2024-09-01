<script setup>
import { ref, onMounted, watch, onBeforeUnmount } from 'vue';
import { useForm, Link, usePage, router } from '@inertiajs/vue3';
import { Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions } from '@headlessui/vue';
import { ChevronLeftIcon, ChevronRightIcon, TrashIcon, CursorArrowRaysIcon, CheckIcon, ChevronUpDownIcon, ChevronDownIcon } from '@heroicons/vue/20/solid';
import confirmDialog from '@/confirmDialog';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ConfirmDialog from '@/Components/ConfirmationDialog.vue';
import ImgDialog from './Components/ImgDialog.vue';
import Sorting from './Components/Sorting.vue';

const props = defineProps({
    sortOptions: Object,
    images: Object,
});

const selected = ref([]);
const isDialogOpen = ref(false);
const selectedImage = ref(null);

const toggleSelect = (id) => {
    if (selected.value.includes(id)) {
        selected.value = selected.value.filter(item => item !== id);
    } else {
        selected.value.push(id);
    }
};

const isSelected = (id) => {
    return selected.value.includes(id);
};

const openDialog = (image, index) => {
    selectedImage.value = { img: image, i: index };
    isDialogOpen.value = true;
};

const closeDialog = () => {
    isDialogOpen.value = false;
    selectedImage.value = null;
};

const cancelBtn = () => {
    selected.value = [];
};

const delForm = useForm({});
const delSelectedForm = useForm({ ids: [] });

const delSingle = (id) => {
    confirmDialog.prompt({
        title: "Are you sure?",
        message: "If you delete this image you won't be able to revert this!"
    }).then((result) => {
        if (result === true) {
            delForm.delete(route('gallery.destroy', id));
        }
    });
};

const delSelected = () => {
    confirmDialog.prompt({
        title: "Are you sure?",
        message: "If you delete these images you won't be able to revert this!"
    }).then((result) => {
        if (result === true) {
            delSelectedForm.transform((data) => ({
                ...data,
                ids: selected.value,
            })).delete(route('gallery.sel.destroy'), {
                preserveScroll: true,
                onSuccess: () => selected.value = [],
            });
        }
    });
};

const handelNext = () => {
    if (selectedImage.value.i === props.images.data.length - 1) {
        selectedImage.value.i = 0;
        selectedImage.value.img = props.images.data[selectedImage.value.i];
        return;
    } else {
        selectedImage.value.i++;
        selectedImage.value.img = props.images.data[selectedImage.value.i];
    }
};

const handelPrev = () => {
    if (selectedImage.value.i === 0) {
        selectedImage.value.i = props.images.data.length - 1;
        selectedImage.value.img = props.images.data[selectedImage.value.i];
        return;
    } else {
        selectedImage.value.i--;
        selectedImage.value.img = props.images.data[selectedImage.value.i];
    }
};

const handleKeydown = (event) => {
    if (isDialogOpen.value === false) return;

    if (event.key === 'ArrowRight') {
        handelNext();
    } else if (event.key === 'ArrowLeft') {
        handelPrev();
    }
};

onMounted(() => {
  window.addEventListener('keydown', handleKeydown);
});

onBeforeUnmount(() => {
  window.removeEventListener('keydown', handleKeydown);
});


</script>

<template>
    <AuthenticatedLayout>

        <div class="pt-6">

            <!-- pagination top -->
            <div class="flex items-center justify-between">
                <div class="flex flex-1 justify-between sm:hidden">
                    <Link href="#" class="relative inline-flex items-center rounded border border-space-900 bg-space-950 px-4 py-2 text-sm font-medium text-gray-400 hover:bg-space-900">Previous</Link>
                    <Link href="#" class="relative ml-3 inline-flex items-center rounded border border-space-900 bg-space-950 px-4 py-2 text-sm font-medium text-gray-400 hover:bg-space-900">Next</Link>
                </div>
                <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                    <div class="">
                        <p class="text-sm text-gray-400">
                            <span class="font-medium">{{ images.total }}</span>
                            {{ ' ' }} Images
                        </p>
                    </div>
                    <div class="">
                        <nav class="isolate inline-flex -space-x-px rounded" aria-label="Pagination">
                            <Link :href="images.prev_page_url" class="relative inline-flex items-center rounded-l-md px-1 py-2 text-gray-400 bg-space-950 hover:bg-space-800 focus:z-20 focus:outline-offset-0">
                                <span class="sr-only">Previous</span>
                                <ChevronLeftIcon class="h-5 w-5" aria-hidden="true" />
                            </Link>
                            <Link v-for="page in images.links.slice(1, -1)" :href="page.url" class="relative inline-flex items-center px-2.5 py-2 text-sm font-semibold text-gray-500 bg-space-950 hover:bg-space-800 focus:z-20 focus:outline-offset-0" :class="{'z-10 bg-indigo-600 text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600': page.active }">{{ page.label }}</Link>
                            <Link :href="images.next_page_url" class="relative inline-flex items-center rounded-r-md px-1 py-2 text-gray-400 bg-space-950 hover:bg-space-800 focus:z-20 focus:outline-offset-0">
                                <span class="sr-only">Next</span>
                                <ChevronRightIcon class="h-5 w-5" aria-hidden="true" />
                            </Link>
                        </nav>
                    </div>
                </div>
            </div>

            <Sorting :sortOptions="sortOptions" />

            <div class="grid grid-cols-5 gap-2">
                <div v-for="(img, i) in images.data" :key="img.id" class="image-container relative rounded" :class="{'ring-2 ring-elime-400': isSelected(img.id)}">
                    <a href="#" @click.prevent="openDialog(img, i)" class="block overflow-hidden">
                        <img v-if="img.thumbnail_name" :src="'\\' + img.public_path + '\\' + img.thumbnail_name" alt="Image 1" class="w-full h-auto rounded">
                        <img v-else :src="'\\' + img.public_path + '\\' + img.file_name" alt="Image 1" class="w-full h-[127px] rounded">
                    </a>
                    <div class="image-menu absolute bottom-2 left-0 right-0 text-center opacity-0 transition-opacity duration-300">
                        <span class="isolate inline-flex rounded-md">
                            <button type="button" @click.prevent="toggleSelect(img.id)" class="relative inline-flex items-center rounded-l-md bg-black bg-opacity-90 px-2 py-2 text-gray-500 hover:text-gray-200 focus:z-10">
                                <span class="sr-only">Select</span>
                                <CursorArrowRaysIcon class="h-5 w-5" aria-hidden="true" />
                            </button>
                            <button type="button" @click.prevent="delSingle(img.id)" class="relative -ml-px inline-flex items-center rounded-r-md bg-black bg-opacity-90 px-2 py-2 text-gray-500 hover:text-gray-200 focus:z-10">
                                <span class="sr-only">Delete</span>
                                <TrashIcon class="h-5 w-5" aria-hidden="true" />
                            </button>
                        </span>
                    </div>
                </div>
            </div>

            <!-- selected items options -->
            <div class="py-2 min-h-16 pt-6">
                <div v-if="selected.length > 0">
                    <span v-if="selected.length == 1" class="text-sm text-white">With {{ selected.length }} item: </span>
                    <span v-else class="text-sm text-white">With {{ selected.length }} items: </span>
                    <span class="isolate inline-flex rounded pl-4">
                        <button type="button" @click.prevent="cancelBtn()" class="relative inline-flex items-center rounded-l-sm bg-space-950 px-3 py-1 text-sm text-gray-300 ring-1 ring-inset ring-space-800 hover:bg-gray-50 focus:z-10">
                            Cancel
                        </button>
                        <button type="button" class="relative -ml-px inline-flex items-center bg-space-950 px-3 py-1 text-sm text-gray-300 ring-1 ring-inset ring-space-800 hover:bg-gray-50 focus:z-10">
                            Download
                        </button>
                        <button type="button" @click.prevent="delSelected()" class="relative -ml-px inline-flex items-center rounded-r-sm bg-space-950 px-3 py-1 text-sm font-semibold text-red-600 ring-1 ring-inset ring-space-800 hover:bg-gray-50 focus:z-10">
                            Delete
                        </button>
                    </span>
                </div>
            </div>

            <!-- pagination bottom -->
            <div class="flex items-center justify-between">
                <div class="flex flex-1 justify-between sm:hidden">
                    <Link href="#" class="relative inline-flex items-center rounded border border-space-900 bg-space-950 px-4 py-2 text-sm font-medium text-gray-400 hover:bg-space-900">Previous</Link>
                    <Link href="#" class="relative ml-3 inline-flex items-center rounded border border-space-900 bg-space-950 px-4 py-2 text-sm font-medium text-gray-400 hover:bg-space-900">Next</Link>
                </div>
                <div class="hidden sm:flex sm:flex-1 sm:flex-row-reverse sm:items-center sm:justify-between">
                    <div class="">
                        <nav class="isolate inline-flex -space-x-px rounded" aria-label="Pagination">
                            <Link :href="images.prev_page_url" class="relative inline-flex items-center rounded-l-md px-1 py-2 text-gray-400 bg-space-950 hover:bg-space-800 focus:z-20 focus:outline-offset-0">
                                <span class="sr-only">Previous</span>
                                <ChevronLeftIcon class="h-5 w-5" aria-hidden="true" />
                            </Link>
                            <Link v-for="page in images.links.slice(1, -1)" :href="page.url" class="relative inline-flex items-center px-2.5 py-2 text-sm font-semibold text-gray-500 bg-space-950 hover:bg-space-800 focus:z-20 focus:outline-offset-0" :class="{'z-10 bg-indigo-600 text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600': page.active }">{{ page.label }}</Link>
                            <Link :href="images.next_page_url" class="relative inline-flex items-center rounded-r-md px-1 py-2 text-gray-400 bg-space-950 hover:bg-space-800 focus:z-20 focus:outline-offset-0">
                                <span class="sr-only">Next</span>
                                <ChevronRightIcon class="h-5 w-5" aria-hidden="true" />
                            </Link>
                        </nav>
                    </div>
                </div>
            </div>

        </div>

        <ImgDialog
            :open="isDialogOpen"
            :image="selectedImage"
            @next="handelNext"
            @prev="handelPrev"
            @close="closeDialog"
        />

        <ConfirmDialog />
    </AuthenticatedLayout>
</template>
