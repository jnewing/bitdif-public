<script setup>

const props = defineProps({
    hasKey: {
        type: Boolean,
        required: true,
    },
});

</script>

<template>
    <section>
        <div class="grid grid-cols-1 gap-x-8 gap-y-8 pt-10 md:grid-cols-3">
            <div class="px-4 sm:px-0">
                <h2 class="text-base font-semibold leading-7 text-gray-200">ShareX Config</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">Download ShareX Config (.sxcu)</p>
            </div>

            <div class="bg-space-950 ring-1 ring-gray-900/5 rounded md:col-span-2">
                <div class="px-4 py-6 sm:p-8">
                    <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="sm:col-span-10">
                            <p class="mt-1 text-sm leading-6 text-gray-400">Because we love ShareX here at bitdif, we wanted to provide you with a quick and easy way to integrate with them.</p>
                        </div>
                    </div>
                </div>
                <div v-if="hasKey" class="flex items-center justify-end gap-x-6 border-t border-gray-600/10 px-4 py-3 bg-black/5  sm:px-8">
                    <a :href="route('settings.sharex')" class="col-span-1 px-4 py-2 text-sm font-medium text-white bg-elime-600 border border-transparent rounded-md hover:bg-elime-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Download
                    </a>
                </div>
                <div v-else class="flex items-center justify-end gap-x-6 border-t border-gray-600/10 px-4 py-3 bg-black/5  sm:px-8">
                    <span class="text-red-600">API token not set.</span>
                </div>
            </div>
        </div>
    </section>
</template>
