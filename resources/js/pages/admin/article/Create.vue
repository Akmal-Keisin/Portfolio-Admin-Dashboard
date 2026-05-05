<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft, CheckCircle, Loader, TriangleAlert } from 'lucide-vue-next';
import { ref } from 'vue';
import TipTap from '@/components/TipTap/TipTap.vue';
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
import AppLayout from '@/layouts/AppLayout.vue';
import category from '@/routes/category';
import type { ArticleForm, ArticleFormErrors } from './types';

// Props
defineProps<{
    errors?: ArticleFormErrors;
}>();

// Ref
const breadcrumbs = ref([
    {
        title: 'Article',
        href: category.index(),
    },
    {
        title: 'Create',
        href: category.create(),
    },
]);

// Form
const form = useForm<ArticleForm>({
    title: '',
    content: '',
    category: 0,
    tags: [],
});

// Functions
const handleSubmit = () => {
    console.log('tes');
    form.post(category.store().url);
};
</script>

<template>
    <Head title="Create Article" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <Card>
            <CardHeader>
                <CardTitle>Create Article Form</CardTitle>
                <CardDescription>
                    Enter your category name and it's description to create new
                    category
                </CardDescription>
            </CardHeader>
            <CardContent>
                <FieldSet>
                    <FieldGroup>
                        <!-- Article Name Field -->
                        <Field>
                            <FieldLabel>
                                Title
                                <span class="text-destructive">*</span>
                            </FieldLabel>
                            <Input
                                id="title"
                                :class="{
                                    'border-destructive outline-destructive':
                                        errors?.title,
                                }"
                                type="text"
                                name="title"
                                placeholder="e.g. What Is Going On With The Tech World?"
                                v-model="form.title"
                            />
                            <FieldDescription>
                                Your article title
                            </FieldDescription>

                            <!-- Article Name Error Message -->
                            <FieldDescription
                                v-if="errors?.title"
                                class="flex items-center gap-1 text-destructive"
                            >
                                <TriangleAlert :size="16" />
                                {{ errors?.title }}
                                Test
                            </FieldDescription>
                        </Field>

                        <!-- Content Field -->
                        <Field>
                            <FieldLabel>Content</FieldLabel>
                            <TipTap v-model="form.content" />
                            <FieldDescription>
                                Write your article here
                            </FieldDescription>
                            <!-- Description Error Message -->
                            <FieldDescription
                                v-if="errors?.content"
                                class="flex items-center gap-1 text-destructive"
                            >
                                <TriangleAlert :size="16" />
                                {{ errors?.content }}
                            </FieldDescription>
                        </Field>
                    </FieldGroup>
                </FieldSet>
            </CardContent>
            <CardFooter
                class="flex items-center justify-end gap-2 space-y-2 border-t-2 p-4"
            >
                <Button as-child variant="secondary" class="m-0">
                    <Link :href="category.index()"><ArrowLeft /> Back</Link>
                </Button>
                <Button
                    variant="default"
                    :disabled="
                        form.processing ||
                        !form.title ||
                        !form.content ||
                        !form.category
                    "
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
