<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import article from '@/routes/article';
import type { Category } from '@/types/model/category';
import { columns } from './component/colummn';
import DataTable from './component/data-table.vue';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Article',
                href: article.index(),
            },
        ],
    },
});

const data = ref<Category[]>([]);
async function getData(): Promise<Category[]> {
    return [
        {
            id: 1,
            name: 'Politic',
            article_count: 0,
            created_at: '2025-01-02',
            updated_at: '2025-01-03',
        },
    ];
}

onMounted(async () => {
    data.value = await getData();
});
</script>

<template>
    <Head title="Dashboard" />

    <div
        class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
    >
        <div class="container mx-auto py-10">
            <DataTable :columns="columns" :data="data" />
        </div>
    </div>
</template>
