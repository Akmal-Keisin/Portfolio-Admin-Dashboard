<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
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
import techStackRoute from '@/routes/tech-stack';
import type { PaginatedResource } from '@/types';
import type { TechStack } from '@/types/model/tech-stack';

// Props
defineProps<{
    techStacks: PaginatedResource<TechStack>;
}>();

// Refs
const breadcrumbs = ref([
    {
        title: 'Tech Stack',
        href: techStackRoute.index().url,
    },
]);

const pendingDelete = ref<TechStack | null>(null);

// Functions
function confirmDelete() {
    if (!pendingDelete.value) {
        return;
    }

    router.delete(techStackRoute.destroy(pendingDelete.value.id).url, {
        onFinish: () => {
            pendingDelete.value = null;
        },
    });
}
</script>

<template>
    <Head title="Tech Stack" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <!-- Delete confirmation dialog -->
        <AlertDialog :open="!!pendingDelete">
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
                    <Link :href="techStackRoute.create().url">
                        Create
                        <FilePlusIcon />
                    </Link>
                </Button>
            </div>
        </section>

        <!-- Page Content Section -->
        <section class="overflow-hidden rounded-sm border">
            <Table>
                <TableCaption>List of my tech stacks.</TableCaption>
                <TableHeader class="sticky top-0 z-10 bg-muted">
                    <TableRow>
                        <TableHead class="w-10">No</TableHead>
                        <TableHead>Name</TableHead>
                        <TableHead>Project Counts</TableHead>
                        <TableHead>Created At</TableHead>
                        <TableHead>Updated At</TableHead>
                        <TableHead class="w-10">Action</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody class="**:data-[slot=table-cell]:first:w-8">
                    <TableRow
                        v-for="(techStack, index) in techStacks.data"
                        :key="techStack.id"
                    >
                        <TableCell class="font-medium">{{
                            (techStacks.meta.from ?? 0) + index
                        }}</TableCell>
                        <TableCell>{{ techStack.name }}</TableCell>
                        <TableCell>{{ techStack.projectCount }}</TableCell>
                        <TableCell>{{ techStack.createdAt }}</TableCell>
                        <TableCell>{{ techStack.updatedAt }}</TableCell>
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
                                        <Link
                                            :href="
                                                techStackRoute.edit(
                                                    techStack.id,
                                                ).url
                                            "
                                        >
                                            <SquarePen class="mr-2 size-4" />
                                            Edit
                                        </Link>
                                    </DropdownMenuItem>

                                    <DropdownMenuItem
                                        class="text-destructive focus:text-destructive"
                                        @click="pendingDelete = techStack"
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
