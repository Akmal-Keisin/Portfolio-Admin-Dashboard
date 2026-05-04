<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { FilePlusIcon, SearchIcon } from 'lucide-vue-next';
import { ref } from 'vue';
import { Button } from '@/components/ui/button';
import {
    InputGroup,
    InputGroupAddon,
    InputGroupInput,
} from '@/components/ui/input-group';
import Table from '@/components/ui/table/Table.vue';
import TableBody from '@/components/ui/table/TableBody.vue';
import TableCaption from '@/components/ui/table/TableCaption.vue';
import TableHead from '@/components/ui/table/TableHead.vue';
import TableHeader from '@/components/ui/table/TableHeader.vue';
import TableRow from '@/components/ui/table/TableRow.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import articleRoute from '@/routes/article';

// Props

// Refs
const breadcrumbs = ref([
    {
        title: 'Article',
        href: articleRoute.index(),
    },
]);

// const pendingDelete = ref<Category | null>(null);
const searchQuery = ref<string>('');

// Functions
</script>

<template>
    <Head title="Article" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <!-- Page Action Section -->
        <section class="mb-2 flex items-center justify-between">
            <div>
                <InputGroup>
                    <InputGroupInput
                        placeholder="Press enter to search..."
                        v-model="searchQuery"
                    />
                    <InputGroupAddon>
                        <SearchIcon />
                    </InputGroupAddon>
                </InputGroup>
            </div>
            <div>
                <Button as-child>
                    <Link :href="articleRoute.create()">
                        Create
                        <FilePlusIcon />
                    </Link>
                </Button>
            </div>
        </section>

        <!-- Page Content Section -->
        <section class="overflow-hidden rounded-sm border">
            <Table>
                <TableCaption>List of my categories.</TableCaption>
                <TableHeader class="sticky top-0 z-10 bg-muted">
                    <TableRow>
                        <TableHead class="w-10">No</TableHead>
                        <TableHead>Title</TableHead>
                        <TableHead>Article Counts</TableHead>
                        <TableHead>Created At</TableHead>
                        <TableHead>Updated At</TableHead>
                        <TableHead class="w-10">Action</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody class="**:data-[slot=table-cell]:first:w-8">
                </TableBody>
            </Table>
        </section>
    </AppLayout>
</template>
