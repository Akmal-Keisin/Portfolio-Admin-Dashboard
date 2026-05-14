<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import {
    ArchiveIcon,
    ArchiveRestoreIcon,
    ArrowLeft,
    MailIcon,
    MailOpenIcon,
    StarIcon,
    Trash2Icon,
    UserIcon,
    MailCheckIcon,
    CalendarIcon
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
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import AppLayout from '@/layouts/AppLayout.vue';
import messageRoute from '@/routes/messages';
import type { Message } from '@/types/model/message';

// Props
const props = defineProps<{
    message: Message;
}>();

// Refs
const breadcrumbs = ref([
    {
        title: 'Messages',
        href: messageRoute.index(),
    },
    {
        title: 'View Details',
        href: messageRoute.show(props.message.id),
    },
]);

const showDeleteDialog = ref(false);

// Functions
function confirmDelete() {
    router.delete(messageRoute.destroy(props.message.id), {
        onFinish: () => {
            showDeleteDialog.ref = false;
        },
    });
}

function toggleRead() {
    router.patch(messageRoute.toggleRead(props.message.id), {}, { preserveScroll: true });
}

function toggleImportant() {
    router.patch(messageRoute.toggleImportant(props.message.id), {}, { preserveScroll: true });
}

function toggleArchive() {
    router.patch(messageRoute.toggleArchive(props.message.id), {}, { preserveScroll: true });
}
</script>

<template>
    <Head title="View Message" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <AlertDialog :open="showDeleteDialog">
            <AlertDialogContent>
                <AlertDialogHeader>
                    <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
                    <AlertDialogDescription>
                        This will permanently delete the message from <strong>{{ message.name }}</strong>. This action cannot be undone.
                    </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                    <AlertDialogCancel @click="showDeleteDialog = false">Cancel</AlertDialogCancel>
                    <AlertDialogAction @click="confirmDelete" class="bg-destructive hover:bg-destructive/70">
                        <Trash2Icon class="mr-2 size-4" />
                        Delete
                    </AlertDialogAction>
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>

        <div class="max-w-4xl mx-auto space-y-4">
            <div class="flex items-center justify-between">
                <Button as-child variant="ghost" size="sm">
                    <Link :href="messageRoute.index()">
                        <ArrowLeft class="mr-2 size-4" />
                        Back to Inbox
                    </Link>
                </Button>

                <div class="flex items-center gap-2">
                    <Button variant="outline" size="sm" @click="toggleImportant">
                        <StarIcon 
                            :class="[
                                'mr-2 size-4',
                                message.isImportant ? 'fill-yellow-500 text-yellow-500' : ''
                            ]" 
                        />
                        {{ message.isImportant ? 'Important' : 'Mark Important' }}
                    </Button>
                    <Button variant="outline" size="sm" @click="toggleRead">
                        <component :is="message.isRead ? MailIcon : MailOpenIcon" class="mr-2 size-4" />
                        {{ message.isRead ? 'Mark Unread' : 'Mark Read' }}
                    </Button>
                    <Button variant="outline" size="sm" @click="toggleArchive">
                        <component :is="message.status === 'inbox' ? ArchiveIcon : ArchiveRestoreIcon" class="mr-2 size-4" />
                        {{ message.status === 'inbox' ? 'Archive' : 'Move to Inbox' }}
                    </Button>
                    <Button variant="destructive" size="sm" @click="showDeleteDialog = true">
                        <Trash2Icon class="mr-2 size-4" />
                        Delete
                    </Button>
                </div>
            </div>

            <Card>
                <CardHeader class="border-b">
                    <div class="flex items-start justify-between">
                        <div class="space-y-1">
                            <CardTitle class="text-2xl">{{ message.subject }}</CardTitle>
                            <div class="flex items-center gap-4 text-sm text-muted-foreground">
                                <div class="flex items-center gap-1">
                                    <UserIcon class="size-4" />
                                    <span>{{ message.name }}</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <MailCheckIcon class="size-4" />
                                    <span>{{ message.email }}</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <CalendarIcon class="size-4" />
                                    <span>{{ message.createdAt }} ({{ message.diffForHumans }})</span>
                                </div>
                            </div>
                        </div>
                        <Badge :variant="message.status === 'archived' ? 'outline' : 'default'" class="capitalize">
                            {{ message.status }}
                        </Badge>
                    </div>
                </CardHeader>
                <CardContent class="py-8">
                    <div class="prose prose-sm dark:prose-invert max-w-none whitespace-pre-wrap leading-relaxed text-base">
                        {{ message.message }}
                    </div>
                </CardContent>
                <CardFooter class="border-t bg-muted/20 py-4 flex justify-between items-center text-xs text-muted-foreground italic">
                    <div>
                        Last updated: {{ message.updatedAt }}
                    </div>
                    <div v-if="message.isImportant" class="flex items-center gap-1 text-yellow-600 dark:text-yellow-500 font-medium">
                        <StarIcon class="size-3 fill-current" />
                        Marked as Important
                    </div>
                </CardFooter>
            </Card>
        </div>
    </AppLayout>
</template>
