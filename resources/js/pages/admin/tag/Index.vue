<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    EllipsisVertical,
    FilePlusIcon,
    SearchIcon,
    SquarePen,
    Trash2Icon,
} from 'lucide-vue-next';
import { ref } from 'vue';
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from '@/components/ui/alert-dialog';
import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
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
import AppLayout from '@/layouts/AppLayout.vue';
import tagRoute from '@/routes/tag';
import type { PaginatedResource } from '@/types';
import type { Tag } from '@/types/model/tag';

// Props
defineProps<{
    tags: PaginatedResource<Tag>;
}>();

// Refs
const breadcrumbs = ref([
    {
        title: 'Tag',
        href: tagRoute.index(),
    },
]);

const pendingDelete = ref<Tag | null>(null);

// Functions
function confirmDelete() {
    if (!pendingDelete.value) {
        return;
    }
}
</script>

<template>
    <Head title="Tag" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <!-- Delete confirmation dialog — lives OUTSIDE the table, controlled by ref -->
        <AlertDialog
            :open="!!pendingDelete"
            @update:open="pendingDelete = null"
        >
            <AlertDialogContent>
                <AlertDialogHeader>
                    <AlertDialogTitle
                        >Are you absolutely sure?</AlertDialogTitle
                    >
                    <AlertDialogDescription>
                        This will permanently delete
                        <strong>{{ pendingDelete?.name }}</strong
                        >. This action cannot be undone.
                    </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                    <AlertDialogCancel @click="pendingDelete = null">
                        Cancel
                    </AlertDialogCancel>
                    <AlertDialogAction
                        @click="confirmDelete"
                        class="bg-destructive"
                    >
                        <Trash2Icon />
                        Delete
                    </AlertDialogAction>
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>

        <!-- Page Action Section -->
        <section class="mb-2 flex items-center justify-between">
            <div>
                <InputGroup>
                    <InputGroupInput placeholder="Press enter to search..." />
                    <InputGroupAddon>
                        <SearchIcon />
                    </InputGroupAddon>
                </InputGroup>
            </div>
            <div>
                <Button as-child>
                    <Link :href="tagRoute.create()">
                        Create
                        <FilePlusIcon />
                    </Link>
                </Button>
            </div>
        </section>

        <!-- Page Content Section -->
        <section class="overflow-hidden rounded-sm border">
            <Table>
                <TableCaption>List of my tags.</TableCaption>
                <TableHeader class="sticky top-0 z-10 bg-muted">
                    <TableRow>
                        <TableHead class="w-10">No</TableHead>
                        <TableHead>Name</TableHead>
                        <TableHead>Article Counts</TableHead>
                        <TableHead>Created At</TableHead>
                        <TableHead>Updated At</TableHead>
                        <TableHead class="w-10">Action</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody class="**:data-[slot=table-cell]:first:w-8">
                    <TableRow v-for="(tag, index) in tags.data" :key="tag.id">
                        <TableCell class="font-medium">{{
                            index + 1
                        }}</TableCell>
                        <TableCell>{{ tag.name }}</TableCell>
                        <TableCell>{{ tag.articleCount }}</TableCell>
                        <TableCell>{{ tag.createdAt }}</TableCell>
                        <TableCell>{{ tag.updatedAt }}</TableCell>
                        <TableCell>
                            <DropdownMenu>
                                <DropdownMenuTrigger as-child>
                                    <Button variant="secondary" size="icon">
                                        <EllipsisVertical />
                                    </Button>
                                </DropdownMenuTrigger>
                                <DropdownMenuContent>
                                    <DropdownMenuLabel
                                        >Actions</DropdownMenuLabel
                                    >

                                    <DropdownMenuItem as-child>
                                        <Link :href="tagRoute.edit(tag.id)">
                                            <SquarePen class="mr-2 size-4" />
                                            Edit
                                        </Link>
                                    </DropdownMenuItem>

                                    <DropdownMenuItem
                                        class="text-destructive focus:text-destructive"
                                        @click="pendingDelete = tag"
                                    >
                                        <Trash2Icon class="mr-2 size-4" />
                                        Delete
                                    </DropdownMenuItem>
                                </DropdownMenuContent>
                            </DropdownMenu>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </section>
    </AppLayout>
</template>
