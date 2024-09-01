<script setup>
import { ref, watch, computed } from 'vue';
import { ClipboardIcon, CheckCircleIcon } from '@heroicons/vue/20/solid';

const props = defineProps({
    imageLink: Object,
});

const imageLinks = ref([]);
const icons = ref([]);
const iconColours = ref([]);

const updateLinks = () => {
    imageLinks.value = [
        { name: 'ImgLink', link: route('img', props.imageLink.oid) },
        { name: 'DirectLink', link: route('img', props.imageLink.oid + '.' + props.imageLink.original_extension) },
        { name: 'MarkdownLink', link: '[bitdif](' + route('img', props.imageLink.oid + '.' + props.imageLink.original_extension) + ')' },
        { name: 'HTML', link: '<a href="' + route('img', props.imageLink.oid) + '"><img src="' + route('img', props.imageLink.oid + '.' + props.imageLink.original_extension) + '" title="source: bitdif.com" /></a>' },
        { name: 'BBCode', link: '[img]' + route('img', props.imageLink.oid + '.' + props.imageLink.original_extension) + '[/img]' },
    ];
    icons.value = imageLinks.value.map(() => ClipboardIcon);
    iconColours.value = imageLinks.value.map(() => 'text-gray-400');
};

watch(() => props.imageLink, updateLinks, { immediate: true });

const copyToClipboard = async (i) => {
    try {
        await navigator.clipboard.writeText(imageLinks.value[i].link);
        icons.value[i] = CheckCircleIcon;
        iconColours.value[i] = 'text-green-400';
        setTimeout(() => {
            icons.value[i] = ClipboardIcon;
            iconColours.value[i] = 'text-gray-400';
        }, 2000);   // change back to ClipboardIcon after 2 seconds
    } catch (err) {
        console.error('Failed to copy: ', err);
    }
};

console.log(imageLinks.value);

</script>

<template>
    <div class="space-y-12">
        <div class="">
            <div v-for="(ILink, i) in imageLinks" class="grid grid-cols-1 gap-x-1 gap-y-1">
                <div class="sm:col-span-4 pb-2">
                    <label for="username" class="block text-sm font-medium leading-6 text-white">{{ ILink.name }}</label>
                    <div class="flex rounded">
                        <div class="relative flex flex-grow items-stretch focus-within:z-10">
                            <input type="text" v-model="imageLinks[i].link" class="block w-full rounded-none rounded-l border-0 py-1.5 text-gray-200 bg-space-950 ring-1 ring-inset ring-space-700 focus:ing-1 focus:ring-inset focus:ring-space-600 sm:text-sm sm:leading-6" />
                        </div>
                        <button type="button" @click="copyToClipboard(i)" class="relative -ml-px inline-flex items-center gap-x-1.5 rounded-r px-3 py-2 text-sm font-semibold text-gray-400 ring-1 ring-inset ring-space-700 bg-space-800 hover:bg-space-600 transition-all">
                            <component :is="icons[i]" :class="['-ml-0.5', 'h-5', 'w-5', iconColours[i], 'transition-transform', 'duration-500', 'ease-in-out']" aria-hidden="true" />
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
