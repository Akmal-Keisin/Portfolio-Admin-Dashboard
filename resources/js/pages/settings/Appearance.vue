<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { AppearanceTabs } from '@/components/settings';
import { Heading } from '@/components/shared';
import SettingsLayout from '@/layouts/settings/Layout.vue';
</script>

<template>
    <Head title="Appearance settings" />

    <SettingsLayout>
        <h1 class="sr-only">Appearance settings</h1>

        <div class="space-y-6">
            <Heading
                variant="small"
                title="Appearance settings"
                description="Update your account's appearance settings"
            />
            <AppearanceTabs />
        </div>
    </SettingsLayout>
</template>
