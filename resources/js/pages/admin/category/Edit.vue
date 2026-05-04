<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft, CheckCircle, Loader, TriangleAlert } from 'lucide-vue-next';
import { onMounted, ref } from 'vue';
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
import categoryRoute from '@/routes/category';
import type { Category } from '@/types/model/category';
import type { CategoryForm, CategoryFormErrors } from './types';

// Props
const props = defineProps<{
    errors?: CategoryFormErrors;
    category: Category;
}>();

const breadcrumbs = ref([
    {
        title: 'Category',
        href: categoryRoute.index(),
    },
    {
        title: 'Edit',
        href: categoryRoute.edit(props.category.id),
    },
]);

// Form
const form = useForm<CategoryForm>({
    name: '',
    description: '',
});

const handleSubmit = () => {
    console.log('tes');
    form.put(categoryRoute.update(props.category.id).url);
};

onMounted(() => {
    form.name = props.category.name;
    form.description = props.category.description;
});
</script>

<template>
    <Head title="Edit Category" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <Card>
            <CardHeader>
                <CardTitle>Edit Category Form</CardTitle>
                <CardDescription>
                    Enter your category name and it's description to edit new
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
                                <span class="text-destructive"
                                    >*</span
                                ></FieldLabel
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
                    <Link :href="categoryRoute.index()"
                        ><ArrowLeft /> Back</Link
                    >
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
