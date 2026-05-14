<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import {
    ArchiveIcon,
    ArchiveRestoreIcon,
    EllipsisVertical,
    MailIcon,
    MailOpenIcon,
    StarIcon,
    Trash2Icon,
    EyeIcon
} from 'lucide-vue-next';
import { ref, computed } from 'vue';
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
import Table from '@/components/ui/table/Table.vue';
import TableBody from '@/components/ui/table/TableBody.vue';
import TableCaption from '@/components/ui/table/TableCaption.vue';
import TableCell from '@/components/ui/table/TableCell.vue';
import TableHead from '@/components/ui/table/TableHead.vue';
import TableHeader from '@/components/ui/table/TableHeader.vue';
import TableRow from '@/components/ui/table/TableRow.vue';
import { Badge } from '@/components/ui/badge';
import AppLayout from '@/layouts/AppLayout.vue';
import messageRoute from '@/routes/messages';
import type { PaginatedResource } from '@/types';
import type { Message } from '@/types/model/message';

// Props
const props = defineProps<{
    messages: PaginatedResource<Message>;
    filters: {
        status: 'inbox' | 'archived';
    };
}>();

// Refs
const breadcrumbs = ref([
    {
        title: 'Messages',
        href: messageRoute.index(),
    },
]);

const pendingDelete = ref<Message | null>(null);

// Functions
function confirmDelete() {
    if (!pendingDelete.value) {
        return;
    }

    router.delete(messageRoute.destroy(pendingDelete.value.id), {
        onFinish: () => {
            pendingDelete.value = null;
        },
    });
}

function toggleRead(message: Message) {
    router.patch(messageRoute.toggleRead(message.id), {}, { preserveScroll: true });
}

function toggleImportant(message: Message) {
    router.patch(messageRoute.toggleImportant(message.id), {}, { preserveScroll: true });
}

function toggleArchive(message: Message) {
    router.patch(messageRoute.toggleArchive(message.id), {}, { preserveScroll: true });
}

function switchStatus(status: 'inbox' | 'archived') {
    router.get(messageRoute.index(), { status }, { preserveState: true });
}
</script>

<template>
    <Head title="Messages" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <AlertDialog :open="!!pendingDelete">
            <AlertDialogContent>
                <AlertDialogHeader>
                    <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
                    <AlertDialogDescription>
                        This will permanently delete the message from <strong>{{ pendingDelete?.name }}</strong>. This action cannot be undone.
                    </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                    <AlertDialogCancel @click="pendingDelete = null">Cancel</AlertDialogCancel>
                    <AlertDialogAction @click="confirmDelete" class="bg-destructive hover:bg-destructive/70">
                        <Trash2Icon class="mr-2 size-4" />
                        Delete
                    </AlertDialogAction>
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>

        <!-- Status Filter Tabs -->
        <section class="mb-4">
            <div class="inline-flex gap-1 rounded-lg bg-neutral-100 p-1 dark:bg-neutral-800">
                <button
                    @click="switchStatus('inbox')"
                    :class="[
                        'flex items-center rounded-md px-4 py-2 transition-colors text-sm font-medium',
                        filters.status === 'inbox'
                            ? 'bg-white shadow-sm dark:bg-neutral-700 dark:text-neutral-100'
                            : 'text-neutral-500 hover:bg-neutral-200/60 hover:text-black dark:text-neutral-400 dark:hover:bg-neutral-700/60',
                    ]"
                >
                    Inbox
                </button>
                <button
                    @click="switchStatus('archived')"
                    :class="[
                        'flex items-center rounded-md px-4 py-2 transition-colors text-sm font-medium',
                        filters.status === 'archived'
                            ? 'bg-white shadow-sm dark:bg-neutral-700 dark:text-neutral-100'
                            : 'text-neutral-500 hover:bg-neutral-200/60 hover:text-black dark:text-neutral-400 dark:hover:bg-neutral-700/60',
                    ]"
                >
                    Archived
                </button>
            </div>
        </section>

        <!-- Page Content Section -->
        <section class="overflow-hidden rounded-sm border">
            <Table>
                <TableCaption>List of {{ filters.status }} messages.</TableCaption>
                <TableHeader class="sticky top-0 z-10 bg-muted">
                    <TableRow>
                        <TableHead class="w-10 text-center">
                            <StarIcon class="size-4 mx-auto" />
                        </TableHead>
                        <TableHead>Sender</TableHead>
                        <TableHead>Subject</TableHead>
                        <TableHead>Date</TableHead>
                        <TableHead>Status</TableHead>
                        <TableHead class="w-10 text-right">Action</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow
                        v-for="message in messages.data"
                        :key="message.id"
                        :class="[
                            !message.isRead ? 'bg-muted/30 font-semibold' : ''
                        ]"
                    >
                        <TableCell class="text-center">
                            <button @click="toggleImportant(message)" class="hover:text-yellow-500 transition-colors">
                                <StarIcon 
                                    :class="[
                                        'size-4 mx-auto',
                                        message.isImportant ? 'fill-yellow-500 text-yellow-500' : 'text-muted-foreground'
                                    ]" 
                                />
                            </button>
                        </TableCell>
                        <TableCell>
                            <div class="flex flex-col">
                                <span>{{ message.name }}</span>
                                <span class="text-xs text-muted-foreground font-normal">{{ message.email }}</span>
                            </div>
                        </TableCell>
                        <TableCell>
                            <div class="flex items-center gap-2">
                                <Link :href="messageRoute.show(message.id)" class="hover:underline">
                                    {{ message.subject }}
                                </Link>
                                <Badge v-if="!message.isRead" variant="secondary" class="text-[10px] px-1.5 py-0 h-4">New</Badge>
                            </div>
                        </TableCell>
                        <TableCell class="text-xs text-muted-foreground">
                            {{ message.diffForHumans }}
                        </TableCell>
                        <TableCell>
                            <Badge :variant="message.status === 'archived' ? 'outline' : 'default'" class="capitalize">
                                {{ message.status }}
                            </Badge>
                        </TableCell>
                        <TableCell class="text-right">
                            <DropdownMenu>
                                <DropdownMenuTrigger as-child>
                                    <Button variant="ghost" size="icon">
                                        <EllipsisVertical class="size-4" />
                                    </Button>
                                </DropdownMenuTrigger>
                                <DropdownMenuContent align="end">
                                    <DropdownMenuLabel>Actions</DropdownMenuLabel>
                                    
                                    <DropdownMenuItem as-child>
                                        <Link :href="messageRoute.show(message.id)">
                                            <EyeIcon class="mr-2 size-4" />
                                            View Details
                                        </Link>
                                    </DropdownMenuItem>

                                    <DropdownMenuItem @click="toggleRead(message)">
                                        <component :is="message.isRead ? MailIcon : MailOpenIcon" class="mr-2 size-4" />
                                        Mark as {{ message.isRead ? 'Unread' : 'Read' }}
                                    </DropdownMenuItem>

                                    <DropdownMenuItem @click="toggleArchive(message)">
                                        <component :is="message.status === 'inbox' ? ArchiveIcon : ArchiveRestoreIcon" class="mr-2 size-4" />
                                        {{ message.status === 'inbox' ? 'Archive' : 'Move to Inbox' }}
                                    </DropdownMenuItem>

                                    <DropdownMenuItem
                                        class="text-destructive focus:text-destructive"
                                        @click="pendingDelete = message"
                                    >
                                        <Trash2Icon class="mr-2 size-4" />
                                        Delete Permanently
                                    </DropdownMenuItem>
                                </DropdownMenuContent>
                            </DropdownMenu>
                        </TableCell>
                    </TableRow>
                    <TableRow v-if="messages.data.length === 0">
                        <TableCell colspan="6" class="h-24 text-center text-muted-foreground">
                            No messages found in {{ filters.status }}.
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </section>
    </AppLayout>
</template>
