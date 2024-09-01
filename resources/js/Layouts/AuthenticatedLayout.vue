<script setup>
import { ref } from 'vue';
import { useDark, useToggle } from '@vueuse/core';

import Nav from '@/Components/Nav.vue';
import Header from '@/Components/Header.vue';
import Footer from '@/Components/Footer.vue';

import { PlusIcon, MinusIcon, EyeSlashIcon } from '@heroicons/vue/20/solid';
import { XCircleIcon, RocketLaunchIcon } from '@heroicons/vue/24/solid';

const isDark = useDark();
const toggleDark = useToggle(isDark);

</script>

<template>
    <div class="container max-w-2xl mx-auto px-2 sm:px-0">
        <div class="flex flex-col h-screen justify-between">

            <Nav />

            <!-- <Header /> -->

            <main class="mb-auto h-auto">
                <slot />
            </main>

            <div class="h-auto py-2">
                &nbsp;
            </div>
            <!-- <div class="h-auto">
                <Footer />
            </div> -->

        </div>
    </div>
</template>
