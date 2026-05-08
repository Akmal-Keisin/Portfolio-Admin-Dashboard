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
import techStackRoute from '@/routes/tech-stack';
import type { TechStack } from '@/types/model/tech-stack';
import type { TechStackForm, TechStackFormErrors } from './types';

// Props
const props = defineProps<{
    errors?: TechStackFormErrors;
    techStack: TechStack;
}>();

const breadcrumbs = ref([
    {
        title: 'Tech Stack',
        href: techStackRoute.index().url,
    },
    {
        title: 'Edit',
        href: techStackRoute.edit(props.techStack.id).url,
    },
]);

// Form
const form = useForm<TechStackForm>({
    name: '',
    description: '',
});

const handleSubmit = () => {
    form.put(techStackRoute.update(props.techStack.id).url);
};

onMounted(() => {
    form.name = props.techStack.name;
    form.description = props.techStack.description;
});
</script>

<template>
    <Head title="Edit Tech Stack" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <Card>
            <CardHeader>
                <CardTitle>Edit Tech Stack Form</CardTitle>
                <CardDescription>
                    Enter your tech stack name and its description to edit tech
                    stack
                </CardDescription>
            </CardHeader>
            <CardContent>
                <FieldSet>
                    <FieldGroup>
                        <!-- Name Field -->
                        <Field>
                            <FieldLabel
                                >Name
                                <span class="text-destructive"
                                    >*</span
                                ></FieldLabel
                            >
                            <Input
                                id="name"
                                :class="{
                                    'border-destructive outline-destructive':
                                        errors?.name,
                                }"
                                type="text"
                                name="name"
                                placeholder="e.g. Laravel"
                                v-model="form.name"
                            />
                            <FieldDescription
                                >Short, descriptive name</FieldDescription
                            >

                            <!-- Error Message -->
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
                                placeholder="Optional, briefly describe this tech stack..."
                                v-model="form.description"
                                rows="3"
                                maxlength="255"
                            />
                            <FieldDescription
                                >Describe what is the tech stack
                                about</FieldDescription
                            >
                            <!-- Error Message -->
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
                    <Link :href="techStackRoute.index().url"
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
