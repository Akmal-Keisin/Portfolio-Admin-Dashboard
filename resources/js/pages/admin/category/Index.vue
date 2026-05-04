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
import categoryRoute from '@/routes/category';
import type { PaginatedResource } from '@/types';
import type { Category } from '@/types/model/category';

defineProps<{
    categories: PaginatedResource<Category>;
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Category',
                href: categoryRoute.index(),
            },
        ],
    },
});

// Track which category is pending deletion — null means dialog is closed.
const pendingDelete = ref<Category | null>(null);

function confirmDelete() {
    if (!pendingDelete.value) {
        return;
    }
    // wire to your delete route/form here
    // e.g. router.delete(categoryRoute.destroy(pendingDelete.value.id))
    // pendingDelete.value = null;
}
</script>

<template>
    <Head title="Category" />

    <!-- Delete confirmation dialog — lives OUTSIDE the table, controlled by ref -->
    <AlertDialog :open="!!pendingDelete" @update:open="pendingDelete = null">
        <AlertDialogContent>
            <AlertDialogHeader>
                <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
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
                <AlertDialogAction @click="confirmDelete">
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
                <Link :href="categoryRoute.create()">
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
                    <TableHead>Name</TableHead>
                    <TableHead>Article Counts</TableHead>
                    <TableHead>Created At</TableHead>
                    <TableHead>Updated At</TableHead>
                    <TableHead>Action</TableHead>
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
                    <TableCell>
                        <DropdownMenu>
                            <DropdownMenuTrigger as-child>
                                <Button variant="secondary" size="icon">
                                    <EllipsisVertical />
                                </Button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent>
                                <DropdownMenuLabel>Actions</DropdownMenuLabel>

                                <DropdownMenuItem as-child>
                                    <Link
                                        :href="categoryRoute.edit(category.id)"
                                    >
                                        <SquarePen class="mr-2 size-4" />
                                        Edit
                                    </Link>
                                </DropdownMenuItem>

                                <!--
                                    No AlertDialogTrigger here.
                                    The item just sets the ref — the dialog
                                    is rendered outside this dropdown entirely.
                                -->
                                <DropdownMenuItem
                                    class="text-destructive focus:text-destructive"
                                    @click="pendingDelete = category"
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
</template>
