<script setup>
import { ref, watch, } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import { Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions } from '@headlessui/vue';
import { CheckIcon, ChevronUpDownIcon } from '@heroicons/vue/20/solid';

const props = defineProps({
    sortOptions: Object,
});

const { url } = usePage();

const sort = [
    { id: 'created_at', name: 'Date uploaded' },
    { id: 'original_name', name: 'Origional filename' },
];

const order = [
    { id: 'desc', name: 'Descending' },
    { id: 'asc', name: 'Ascending' },
];

const sortOptionSelected = ref(sort.filter((i) => i.id === props.sortOptions?.sort.id)[0]);
const orderOptionSelected = ref(order.filter((i) => i.id === props.sortOptions?.order.id)[0]);

watch([sortOptionSelected, orderOptionSelected], ([newSortOption, newSortOrder]) => {
    router.get(url, { sort: newSortOption.id , order: newSortOrder.id }, { preserveState: true });
});

</script>

<template>
    <!-- sorting options -->
    <div class="flex gap-4 pb-4">
        <Listbox as="div" class="w-48" v-model="sortOptionSelected">
            <ListboxLabel class="block text-sm font-medium leading-6 text-gray-900">Sorting</ListboxLabel>
            <div class="relative mt-2">
                <ListboxButton class="relative w-full cursor-default rounded bg-space-950 py-1.5 pl-3 pr-10 text-left text-gray-400 ring-1 ring-inset ring-space-900 focus:outline-none focus:ring-2 focus:ring-elime-600 sm:text-sm sm:leading-6">
                    <span class="block truncate">{{ sortOptionSelected.name }}</span>
                    <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                        <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                    </span>
                </ListboxButton>

                <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                    <ListboxOptions class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded bg-space-950 py-1 text-base ring-1 ring-space-900 ring-opacity-5 focus:outline-none sm:text-sm">
                        <ListboxOption as="template" v-for="opt in sort" :key="opt.id" :value="opt" v-slot="{ active, selected }">
                            <li :class="[active ? 'bg-elime-600 text-white' : 'text-gray-400', 'relative cursor-default select-none py-2 pl-8 pr-4']">
                                <span :class="[selected ? 'font-semibold' : 'font-normal', 'block truncate']">{{ opt.name }}</span>
                                <span v-if="selected" :class="[active ? 'text-white' : 'text-elime-600', 'absolute inset-y-0 left-0 flex items-center pl-1.5']">
                                    <CheckIcon class="h-5 w-5" aria-hidden="true" />
                                </span>
                            </li>
                        </ListboxOption>
                    </ListboxOptions>
                </transition>
            </div>
        </Listbox>

        <Listbox as="div" class="w-40" v-model="orderOptionSelected">
            <ListboxLabel class="block text-sm font-medium leading-6 text-gray-900">Order</ListboxLabel>
            <div class="relative mt-2">
                <ListboxButton class="relative w-full cursor-default rounded bg-space-950 py-1.5 pl-3 pr-10 text-left text-gray-400 ring-1 ring-inset ring-space-900 focus:outline-none focus:ring-2 focus:ring-elime-600 sm:text-sm sm:leading-6">
                    <span class="block truncate">{{ orderOptionSelected.name }}</span>
                    <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                        <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                    </span>
                </ListboxButton>

                <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                    <ListboxOptions class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded bg-space-950 py-1 text-base ring-1 ring-space-900 ring-opacity-5 focus:outline-none sm:text-sm">
                        <ListboxOption as="template" v-for="oopt in order" :key="oopt.id" :value="oopt" v-slot="{ active, selected }">
                            <li :class="[active ? 'bg-elime-600 text-white' : 'text-gray-400', 'relative cursor-default select-none py-2 pl-8 pr-4']">
                                <span :class="[selected ? 'font-semibold' : 'font-normal', 'block truncate']">{{ oopt.name }}</span>
                                <span v-if="selected" :class="[active ? 'text-white' : 'text-elime-600', 'absolute inset-y-0 left-0 flex items-center pl-1.5']">
                                    <CheckIcon class="h-5 w-5" aria-hidden="true" />
                                </span>
                            </li>
                        </ListboxOption>
                    </ListboxOptions>
                </transition>
            </div>
        </Listbox>
    </div>
</template>
