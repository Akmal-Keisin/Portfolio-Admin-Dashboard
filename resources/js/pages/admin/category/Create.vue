<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft, CheckCircle, Loader, TriangleAlert } from 'lucide-vue-next';
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
import category from '@/routes/category';
import type { CategoryForm, CategoryFormErrors } from './types';

// Props
defineProps<{
    errors?: CategoryFormErrors;
}>();

// Options
defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Category',
                href: category.index(),
            },
            {
                title: 'Create',
                href: category.create(),
            },
        ],
    },
});

// Form
const form = useForm<CategoryForm>({
    name: '',
    description: '',
});

const handleSubmit = () => {
    console.log('tes');
    form.post(category.store().url);
};
</script>

<template>
    <Head title="Create Category" />
    <Card>
        <CardHeader>
            <CardTitle>Create Category Form</CardTitle>
            <CardDescription>
                Enter your category name and it's description to create new
                category
            </CardDescription>
        </CardHeader>
        <CardContent>
            <FieldSet>
                <FieldGroup>
                    <!-- Category Name Field -->
                    <Field>
                        <FieldLabel
                            >Name
                            <span class="text-destructive">*</span></FieldLabel
                        >
                        <Input
                            id="category_name"
                            :class="{
                                'border-destructive outline-destructive':
                                    errors?.name,
                            }"
                            type="text"
                            name="name"
                            placeholder="e.g. Technology"
                            v-model="form.name"
                        />
                        <FieldDescription
                            >Short, descriptive name</FieldDescription
                        >

                        <!-- Category Name Error Message -->
                        <FieldDescription
                            v-if="errors?.name"
                            class="flex items-center gap-1 text-destructive"
                        >
                            <TriangleAlert :size="16" />
                            {{ errors?.name }}
                            Test
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
                            placeholder="Optional, briefly describe this category..."
                            v-model="form.description"
                            rows="3"
                            maxlength="255"
                        />
                        <FieldDescription
                            >Describe what is the category
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
                <Link :href="category.index()"><ArrowLeft /> Back</Link>
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
</template>
