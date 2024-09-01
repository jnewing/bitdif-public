<script setup>
import { ref, computed } from 'vue';
import { useDark, useToggle } from '@vueuse/core';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
import moment from 'moment';

import { EllipsisHorizontalIcon, CodeBracketIcon, LinkIcon, CloudArrowDownIcon, PhotoIcon } from '@heroicons/vue/20/solid';

const props = defineProps({
    image: {
        type: Object,
        required: true,
    },
    views: {
        type: Number,
        required: true,
    },
    size: {
        type: Number,
        required: true,
    }
});

const isDark = useDark();
const toggleDark = useToggle(isDark);

const formatBytes = (bytes, decimals) => {
   if(bytes == 0) return '0 bytes';
   var k = 1024, dm = decimals || 2, sizes = ['bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'], i = Math.floor(Math.log(bytes) / Math.log(k));
   return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}

const bandwidth = computed(() => {
    return formatBytes(props.size * props.views, 3);
});

</script>

<style scoped>
    .dropdown-arrow::before,
    .dropdown-arrow::after {
      content: "";
      position: absolute;
      top: -1.45rem;
      right: 0.4rem;
      border-style: solid;
    }

    .dropdown-arrow::before {
      border-width: 0.7rem;
      border-color: transparent transparent #343a40 transparent;
    }

    .dropdown-arrow::after {
      top: -1.4rem;
      right: 0.33rem;
      border-width: 0.77rem;
      border-color: transparent transparent #21262b transparent;
    }
</style>

<template>
    <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-6">
        <div class="mt-5 sm:mx-auto sm:w-full sm:max-w-3xl">

            <!-- image header -->
            <div class="flex justify-between items-end">
                <div class="grid grid-cols-1 gap-2 sm:grid-cols-1">
                    <div class="relative flex items-center space-x-3 py-5">
                        <div class="flex-shrink-0">
                            <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-elime-500">
                                <span class="text-xs font-medium leading-none text-white">bitdif</span>
                            </span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <span class="absolute inset-0" aria-hidden="true" />
                            <p class="text-sm font-medium text-gray-200">{{ moment(image.created_at).fromNow() }}</p>
                            <p class="truncate text-sm text-gray-400">
                                <span>{{ views }} views</span>
                                <span class="delimiter"> • </span>
                                <span title="Tue May 28 2024 09:00:19 GMT-0400 (Eastern Daylight Time)">{{ formatBytes(size, 3) }}</span>
                                <span class="delimiter"> • </span>
                                <span title="bandwidth">wasted {{ bandwidth }} of bandwidth.</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- menu options -->
                <!-- <Menu as="div" class="relative inline-block text-left pb-5">
                    <div>
                        <MenuButton class="flex items-center text-gray-200 hover:text-gray-400 focus:outline-none pr-[0.5rem]">
                            <span class="sr-only">Open options</span>
                            <EllipsisHorizontalIcon class="h-5 w-5" aria-hidden="true" />
                        </MenuButton>
                    </div>

                    <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                        <MenuItems class="absolute right-0 z-10 mt-2 w-44 origin-top-right rounded bg-space-950 ring-1 ring-space-900 focus:outline-none">
                            <div class="py-1">
                                <MenuItem v-slot="{ active }">
                                    <a href="#" :class="[active ? 'bg-space-900 text-gray-200' : 'text-gray-400', 'group flex items-center px-4 py-2 text-sm']">
                                        <LinkIcon class="mr-3 h-5 w-5 text-gray-400 group-hover:text-elime-500" aria-hidden="true" />
                                        Link
                                    </a>
                                </MenuItem>
                                <MenuItem v-slot="{ active }">
                                    <a href="#" :class="[active ? 'bg-space-900 text-gray-200' : 'text-gray-400', 'group flex items-center px-4 py-2 text-sm']">
                                        <CloudArrowDownIcon class="mr-3 h-5 w-5 text-gray-400 group-hover:text-elime-500" aria-hidden="true" />
                                        Download
                                    </a>
                                </MenuItem>
                                <MenuItem v-slot="{ active }">
                                    <a href="#" :class="[active ? 'bg-space-900 text-gray-200' : 'text-gray-400', 'group flex items-center px-4 py-2 text-sm']">
                                        <PhotoIcon class="mr-3 h-5 w-5 text-gray-400 group-hover:text-elime-500" aria-hidden="true" />
                                        Direct
                                    </a>
                                </MenuItem>
                            </div>
                        </MenuItems>
                    </transition>
                </Menu> -->
            </div>

            <!-- image -->
            <div class="w-full rounded">
                <img :src="image.public_path + '/' + image.file_name" class="rounded w-full h-auto" alt="image.original_name - bitdif" />
            </div>
        </div>
  </div>
</template>
