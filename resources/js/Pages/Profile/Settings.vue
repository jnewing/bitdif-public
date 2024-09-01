<script setup>
import { ref } from 'vue';
import { usePage, Link } from '@inertiajs/vue3';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import UpdatePasswordForm from '@/Pages/Profile/Partials/UpdatePasswordForm.vue';
import UpdateAPIKeyForm from '@/Pages/Profile/Partials/UpdateAPIKeyForm.vue';
import ShareXConfig from '@/Pages/Profile/Partials/ShareXConfig.vue';

const user = usePage().props.auth.user;
const api_key_set = ref(user.token_set_at ? true : false);

const handelTokenUpdate = () => {
    api_key_set.value = true;
};

</script>

<template>
    <AuthenticatedLayout v-if="$page.props.auth.user">
        <div class="pt-10">
            <UpdatePasswordForm />
        </div>

        <div class="pt-4">
            <UpdateAPIKeyForm
                :user="user"
                :hasKey="api_key_set"
                @token="handelTokenUpdate"
            />
        </div>

        <div class="pt-4">
            <ShareXConfig
                :hasKey="api_key_set"
            />
        </div>
    </AuthenticatedLayout>
</template>
