<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { FilePlusIcon, SearchIcon } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import {
    InputGroup,
    InputGroupAddon,
    InputGroupInput,
} from '@/components/ui/input-group';
import Table from '@/components/ui/table/Table.vue';
import TableBody from '@/components/ui/table/TableBody.vue';
import TableCaption from '@/components/ui/table/TableCaption.vue';
import TableCell from '@/components/ui/table/TableCell.vue';
import TableHead from '@/components/ui/table/TableHead.vue';
import TableHeader from '@/components/ui/table/TableHeader.vue';
import TableRow from '@/components/ui/table/TableRow.vue';
import category from '@/routes/category';
import type { PaginatedResource } from '@/types';
import type { Category } from '@/types/model/category';

// Props
defineProps<{
    categories: PaginatedResource<Category>;
}>();

// Options
defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Category',
                href: category.index(),
            },
        ],
    },
});
</script>

<template>
    <Head title="Category" />

    <!-- Page Action Section -->
    <section class="mb-2 flex items-center justify-between">
        <!-- Search Bar -->
        <div>
            <InputGroup>
                <InputGroupInput placeholder="Press enter to search..." />
                <InputGroupAddon>
                    <SearchIcon />
                </InputGroupAddon>
            </InputGroup>
        </div>

        <!-- Create Button -->
        <div>
            <Button as-child>
                <Link :href="category.create()">
                    Create
                    <FilePlusIcon />
                </Link>
            </Button>
        </div>
    </section>

    <!-- Page Content Section -->
    <section class="overflow-hidden rounded-sm border">
        <!-- Category List Table -->
        <Table>
            <TableCaption>List of my categories.</TableCaption>
            <TableHeader class="sticky top-0 z-10 bg-muted">
                <TableRow>
                    <TableHead class="w-10"> No </TableHead>
                    <TableHead>Name</TableHead>
                    <TableHead>Article Counts</TableHead>
                    <TableHead> Created At </TableHead>
                    <TableHead> Updated At </TableHead>
                </TableRow>
            </TableHeader>
            <TableBody class="**:data-[slot=table-cell]:first:w-8">
                <TableRow
                    v-for="(category, index) in categories.data"
                    :key="category.id"
                >
                    <TableCell class="font-medium">{{ index + 1 }}</TableCell>
                    <TableCell>{{ category.name }}</TableCell>
                    <TableCell>{{ category.articleCount }}</TableCell>
                    <TableCell>{{ category.createdAt }}</TableCell>
                    <TableCell>{{ category.updatedAt }}</TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </section>
</template>
