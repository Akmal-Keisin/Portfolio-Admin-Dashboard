<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import {
    EllipsisVertical,
    FilePlusIcon,
    SearchIcon,
    SquarePen,
    Trash2Icon,
    ExternalLink,
    Github,
    CheckCircle2,
    Clock,
    Star
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
import { Badge } from '@/components/ui/badge';
import Table from '@/components/ui/table/Table.vue';
import TableBody from '@/components/ui/table/TableBody.vue';
import TableCaption from '@/components/ui/table/TableCaption.vue';
import TableCell from '@/components/ui/table/TableCell.vue';
import TableHead from '@/components/ui/table/TableHead.vue';
import TableHeader from '@/components/ui/table/TableHeader.vue';
import TableRow from '@/components/ui/table/TableRow.vue';
import AppLayout from '@/layouts/AppLayout.vue';
// @ts-ignore - generated route
import projectRoute from '@/routes/project';
import type { PaginatedResource } from '@/types';
import type { Project } from '@/types/model/project';

// Props
defineProps<{
    projects: PaginatedResource<Project>;
}>();

// Refs
const breadcrumbs = ref([
    {
        title: 'Project',
        href: projectRoute.index(),
    },
]);

const pendingDelete = ref<Project | null>(null);
const searchQuery = ref<string>('');

// Functions
function handleSearch() {
    // Do some search
}

function confirmDelete() {
    if (!pendingDelete.value) {
        return;
    }

    router.delete(projectRoute.destroy(pendingDelete.value.slug), {
        onFinish: () => {
            pendingDelete.value = null;
        },
    });
}
</script>

<template>
    <Head title="Project" />
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
                        <strong>{{ pendingDelete?.title }}</strong
                        >. This action cannot be undone.
                    </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                    <AlertDialogCancel @click="pendingDelete = null">
                        Cancel
                    </AlertDialogCancel>
                    <AlertDialogAction
                        @click="confirmDelete"
                        class="bg-destructive hover:bg-destructive/70"
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
                    <InputGroupInput
                        placeholder="Press enter to search..."
                        v-model="searchQuery"
                        @enter="handleSearch"
                    />
                    <InputGroupAddon>
                        <SearchIcon />
                    </InputGroupAddon>
                </InputGroup>
            </div>
            <div>
                <Button as-child>
                    <Link :href="projectRoute.create()">
                        Create
                        <FilePlusIcon />
                    </Link>
                </Button>
            </div>
        </section>

        <!-- Page Content Section -->
        <section class="overflow-hidden rounded-sm border">
            <Table>
                <TableCaption>A list of your projects.</TableCaption>
                <TableHeader class="sticky top-0 z-10 bg-muted">
                    <TableRow>
                        <TableHead class="w-10">No</TableHead>
                        <TableHead>Thumbnail</TableHead>
                        <TableHead>Title</TableHead>
                        <TableHead>Status</TableHead>
                        <TableHead>Featured</TableHead>
                        <TableHead>Links</TableHead>
                        <TableHead class="w-10">Action</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody class="**:data-[slot=table-cell]:first:w-8">
                    <TableRow
                        v-for="(project, index) in projects.data"
                        :key="project.id"
                    >
                        <TableCell class="font-medium">{{
                            (projects.meta.from ?? 0) + index
                        }}</TableCell>
                        <TableCell>
                            <img 
                                v-if="project.thumbnail" 
                                :src="project.thumbnail" 
                                class="h-10 w-16 object-cover rounded border" 
                                alt="thumbnail"
                            />
                            <div v-else class="h-10 w-16 bg-muted rounded border flex items-center justify-center text-[10px] text-muted-foreground">
                                No Image
                            </div>
                        </TableCell>
                        <TableCell class="font-semibold">{{ project.title }}</TableCell>
                        <TableCell>
                            <Badge :variant="project.status === 'completed' ? 'default' : 'secondary'">
                                <component :is="project.status === 'completed' ? CheckCircle2 : Clock" class="mr-1 size-3" />
                                {{ project.status }}
                            </Badge>
                        </TableCell>
                        <TableCell>
                            <Star v-if="project.featured" class="size-4 text-yellow-500 fill-yellow-500" />
                            <Star v-else class="size-4 text-muted" />
                        </TableCell>
                        <TableCell>
                            <div class="flex space-x-2">
                                <a v-if="project.live_url" :href="project.live_url" target="_blank" class="text-primary hover:underline">
                                    <ExternalLink class="size-4" />
                                </a>
                                <a v-if="project.repo_url" :href="project.repo_url" target="_blank" class="text-primary hover:underline">
                                    <Github class="size-4" />
                                </a>
                            </div>
                        </TableCell>
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
                                                projectRoute.edit(project.slug)
                                            "
                                        >
                                            <SquarePen class="mr-2 size-4" />
                                            Edit
                                        </Link>
                                    </DropdownMenuItem>

                                    <DropdownMenuItem
                                        class="text-destructive focus:text-destructive"
                                        @click="pendingDelete = project"
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
