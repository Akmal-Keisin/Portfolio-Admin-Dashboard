<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft, CheckCircle, Loader, TriangleAlert } from 'lucide-vue-next';
import { ref } from 'vue';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import {
    Field,
    FieldDescription,
    FieldGroup,
    FieldLabel,
    FieldSet,
} from '@/components/ui/field';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import tag from '@/routes/tag';
import type { TagForm, TagFormErrors } from './types';

// Props
defineProps<{
    errors?: TagFormErrors;
}>();

// Ref
const breadcrumbs = ref([
    {
        title: 'Tag',
        href: tag.index(),
    },
    {
        title: 'Create',
        href: tag.create(),
    },
]);

// Form
const form = useForm<TagForm>({
    name: '',
    description: '',
});

const handleSubmit = () => {
    console.log('tes');
    form.post(tag.store().url);
};
</script>

<template>
    <Head title="Create Tag" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <Card>
            <CardHeader>
                <CardTitle>Create Tag Form</CardTitle>
                <CardDescription>
                    Enter your tag name and it's description to create new tag
                </CardDescription>
            </CardHeader>
            <CardContent>
                <FieldSet>
                    <FieldGroup>
                        <!-- Tag Name Field -->
                        <Field>
                            <FieldLabel
                                >Name
                                <span class="text-destructive"
                                    >*</span
                                ></FieldLabel
                            >
                            <Input
                                id="tag_name"
                                :class="{
                                    'border-destructive outline-destructive':
                                        errors?.name,
                                }"
                                type="text"
                                name="name"
                                placeholder="e.g. PHP"
                                v-model="form.name"
                            />
                            <FieldDescription
                                >Short, descriptive name</FieldDescription
                            >

                            <!-- Tag Name Error Message -->
                            <FieldDescription
                                v-if="errors?.name"
                                class="flex items-center gap-1 text-destructive"
                            >
                                <TriangleAlert :size="16" />
                                {{ errors?.name }}
                            </FieldDescription>
                        </Field>

                        <!-- Description Field -->
                        <Field>
                            <FieldLabel>Description</FieldLabel>
                            <Textarea
                                id="description"
                                :class="{
                                    'border-destructive outline-destructive':
                                        errors?.description,
                                }"
                                placeholder="Optional, briefly describe this tag..."
                                v-model="form.description"
                                rows="3"
                                maxlength="255"
                            />
                            <FieldDescription
                                >Describe what is the tag
                                about</FieldDescription
                            >
                            <!-- Description Error Message -->
                            <FieldDescription
                                v-if="errors?.description"
                                class="flex items-center gap-1 text-destructive"
                            >
                                <TriangleAlert :size="16" />
                                {{ errors?.description }}
                            </FieldDescription>
                        </Field>
                    </FieldGroup>
                </FieldSet>
            </CardContent>
            <CardFooter
                class="flex items-center justify-end gap-2 space-y-2 border-t-2 p-4"
            >
                <Button as-child variant="secondary" class="m-0">
                    <Link :href="tag.index()"><ArrowLeft /> Back</Link>
                </Button>
                <Button
                    variant="default"
                    :disabled="form.processing || !form.name"
                    @click="handleSubmit"
                >
                    <Loader v-if="form.processing" class="animate-spin" />
                    <CheckCircle v-else />
                    Submit
                </Button>
            </CardFooter>
        </Card>
    </AppLayout>
</template>
