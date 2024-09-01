<script setup>
import { ref } from 'vue';
import { usePage, Link } from '@inertiajs/vue3';
import { CloudArrowUpIcon, PhotoIcon } from '@heroicons/vue/20/solid';

import Logo from '@/Components/Logo.vue';

const page = usePage();

const tabs = [
    // { name: 'About', href: route('about'), current: (page.url == '/about') },
    // { name: 'Home', href: route('index'), current: (page.url == '/') },
    { name: 'Logout', href: route('login'), current: (page.url == '/logout') },
    { name: 'Home', href: "/", current: (page.url == '/') },
];

</script>

<template>

    <div class="container mx-auto flex justify-between items-center py-4">
        <!-- Logo -->
        <div class="text-lg font-bold">
            <Logo />
        </div>

        <!-- Navigation Items -->
        <div>
            <div class="flex mx-auto justify-between gap-2">

                <div v-if="!route().current('gallery.create')">
                    <Link :href="route('gallery.create')" as="button" type="button" class="inline-flex items-center gap-x-1.5 rounded bg-elime-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-elime-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-elime-600">
                        <CloudArrowUpIcon class="-ml-0.5 h-5 w-5" aria-hidden="true" />
                        <span class="hidden sm:inline">Upload Images</span>
                    </Link>
                </div>

                <nav>
                    <ul class="flex space-x-6 bg-space-950 rounded px-5 py-1.5 text-white text-sm">
                        <li>
                            <Link :href="route('gallery.index')" class="hover:text-gray-400">Gallery</Link>
                        </li>
                        <li>
                            <Link :href="route('settings')" class="hover:text-gray-400">Settings</Link>
                        </li>
                        <li>
                            <Link :href="route('logout')" method="post" as="button" class="hover:text-yellow-400" type="button">Logout</Link>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

</template>
