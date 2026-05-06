<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import type { JSONContent } from '@tiptap/vue-3';
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
import {
    Select,
    SelectContent,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import AppLayout from '@/layouts/AppLayout.vue';
import article from '@/routes/article';
import type { Category } from '@/types/model/category';
import type { Tag } from '@/types/model/tag';
import type { ArticleForm, ArticleFormErrors } from './types';

// Props
defineProps<{
    errors?: ArticleFormErrors;
    categories: Category[];
    tags: Tag[];
}>();

// Ref
const breadcrumbs = ref([
    {
        title: 'Article',
        href: article.index(),
    },
    {
        title: 'Create',
        href: article.create(),
    },
]);

// Form
const form = useForm<ArticleForm>({
    title: '',
    content: {},
    category: 0,
    tags: [],
});

// Functions
const handleUpdateContent = (content: JSONContent) => {
    form.content = content;
};

const handleSubmit = () => {
    form.post(article.store().url);
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
                            <FieldLabel>
                                Content
                                <span class="text-destructive"> * </span>
                            </FieldLabel>
                            <TipTap @update:content="handleUpdateContent" />
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
                        <Field>
                            <FieldLabel>
                                Category
                                <span class="text-destructive">*</span>
                            </FieldLabel>
                            <Select v-model="form.category">
                                <SelectTrigger>
                                    <SelectValue
                                        placeholder="Select a category"
                                    />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectLabel>Categories</SelectLabel>
                                    <template
                                        v-for="category in categories"
                                        :key="category.id"
                                    >
                                        <SelectItem :value="category.id">
                                            {{ category.name }}
                                        </SelectItem>
                                    </template>
                                </SelectContent>
                            </Select>
                        </Field>
                        <Field>
                            <FieldLabel> Tags </FieldLabel>
                            <Select multiple v-model="form.tags">
                                <SelectTrigger>
                                    <SelectValue placeholder="Select tags" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectLabel>Tags</SelectLabel>
                                    <template v-for="tag in tags" :key="tag.id">
                                        <SelectItem :value="tag.id">
                                            {{ tag.name }}
                                        </SelectItem>
                                    </template>
                                </SelectContent>
                            </Select>
                        </Field>
                    </FieldGroup>
                </FieldSet>
            </CardContent>
            <CardFooter
                class="flex items-center justify-end gap-2 space-y-2 border-t-2 p-4"
            >
                <Button as-child variant="secondary" class="m-0">
                    <Link :href="article.index()"><ArrowLeft /> Back</Link>
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
