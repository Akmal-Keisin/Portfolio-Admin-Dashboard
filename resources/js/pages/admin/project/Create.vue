<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft, CheckCircle, Loader, Upload } from 'lucide-vue-next';
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
import { Checkbox } from '@/components/ui/checkbox';
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
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import projectRoute from '@/routes/project';
import type { TechStack } from '@/types/model/tech-stack';

// Props
defineProps<{
    techStacks: TechStack[];
}>();

// Ref
const breadcrumbs = ref([
    {
        title: 'Project',
        href: projectRoute.index(),
    },
    {
        title: 'Create',
        href: projectRoute.create(),
    },
]);

const thumbnailPreview = ref<string | null>(null);

// Form
const form = useForm({
    title: '',
    description: '',
    excerpt: '',
    thumbnail: null as File | null,
    live_url: '',
    repo_url: '',
    status: 'ongoing',
    featured: false,
    tech_stacks: [] as number[],
});

// Functions
const handleThumbnailChange = (event: Event) => {
    const target = event.target as HTMLInputElement;

    if (target.files && target.files[0]) {
        const file = target.files[0];
        form.thumbnail = file;
        thumbnailPreview.value = URL.createObjectURL(file);
    }
};

const toggleTechStack = (id: number) => {
    const index = form.tech_stacks.indexOf(id);

    if (index > -1) {
        form.tech_stacks.splice(index, 1);
    } else {
        form.tech_stacks.push(id);
    }
};

const handleSubmit = () => {
    form.post(projectRoute.store().url);
};
</script>

<template>
    <Head title="Create Project" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <Card>
            <CardHeader>
                <CardTitle>Create Project</CardTitle>
                <CardDescription>
                    Fill in the details below to showcase your amazing work.
                </CardDescription>
            </CardHeader>
            <CardContent>
                <FieldSet>
                    <FieldGroup>
                        <!-- Title -->
                        <Field>
                            <FieldLabel>
                                Title
                                <span class="text-destructive">*</span>
                            </FieldLabel>
                            <Input
                                id="title"
                                type="text"
                                placeholder="e.g. Portfolio Website"
                                v-model="form.title"
                            />
                            <FieldDescription
                                v-if="form.errors.title"
                                class="text-destructive"
                            >
                                {{ form.errors.title }}
                            </FieldDescription>
                        </Field>

                        <!-- Excerpt -->
                        <Field>
                            <FieldLabel>Excerpt</FieldLabel>
                            <Input
                                id="excerpt"
                                type="text"
                                placeholder="Short summary of the project"
                                v-model="form.excerpt"
                            />
                            <FieldDescription
                                v-if="form.errors.excerpt"
                                class="text-destructive"
                            >
                                {{ form.errors.excerpt }}
                            </FieldDescription>
                        </Field>

                        <!-- Description -->
                        <Field>
                            <FieldLabel>
                                Description
                                <span class="text-destructive">*</span>
                            </FieldLabel>
                            <Textarea
                                id="description"
                                placeholder="Detailed project description"
                                v-model="form.description"
                                rows="5"
                            />
                            <FieldDescription
                                v-if="form.errors.description"
                                class="text-destructive"
                            >
                                {{ form.errors.description }}
                            </FieldDescription>
                        </Field>

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <!-- Thumbnail -->
                            <Field>
                                <FieldLabel>Thumbnail</FieldLabel>
                                <div class="flex items-center gap-4">
                                    <div
                                        v-if="thumbnailPreview"
                                        class="relative size-20 overflow-hidden rounded border"
                                    >
                                        <img
                                            :src="thumbnailPreview"
                                            class="size-full object-cover"
                                        />
                                    </div>
                                    <div
                                        v-else
                                        class="flex size-20 items-center justify-center rounded border bg-muted"
                                    >
                                        <Upload
                                            class="size-6 text-muted-foreground"
                                        />
                                    </div>
                                    <Input
                                        id="thumbnail"
                                        type="file"
                                        accept="image/*"
                                        @change="handleThumbnailChange"
                                        class="flex-1"
                                    />
                                </div>
                                <FieldDescription
                                    v-if="form.errors.thumbnail"
                                    class="text-destructive"
                                >
                                    {{ form.errors.thumbnail }}
                                </FieldDescription>
                            </Field>

                            <!-- Status -->
                            <Field>
                                <FieldLabel
                                    >Status
                                    <span class="text-destructive"
                                        >*</span
                                    ></FieldLabel
                                >
                                <Select v-model="form.status">
                                    <SelectTrigger>
                                        <SelectValue
                                            placeholder="Select status"
                                        />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="ongoing"
                                            >Ongoing</SelectItem
                                        >
                                        <SelectItem value="completed"
                                            >Completed</SelectItem
                                        >
                                    </SelectContent>
                                </Select>
                                <FieldDescription
                                    v-if="form.errors.status"
                                    class="text-destructive"
                                >
                                    {{ form.errors.status }}
                                </FieldDescription>
                            </Field>
                        </div>

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <!-- Live URL -->
                            <Field>
                                <FieldLabel>Live URL</FieldLabel>
                                <Input
                                    id="live_url"
                                    type="url"
                                    placeholder="https://..."
                                    v-model="form.live_url"
                                />
                                <FieldDescription
                                    v-if="form.errors.live_url"
                                    class="text-destructive"
                                >
                                    {{ form.errors.live_url }}
                                </FieldDescription>
                            </Field>

                            <!-- Repo URL -->
                            <Field>
                                <FieldLabel>Repo URL</FieldLabel>
                                <Input
                                    id="repo_url"
                                    type="url"
                                    placeholder="https://github.com/..."
                                    v-model="form.repo_url"
                                />
                                <FieldDescription
                                    v-if="form.errors.repo_url"
                                    class="text-destructive"
                                >
                                    {{ form.errors.repo_url }}
                                </FieldDescription>
                            </Field>
                        </div>

                        <!-- Featured -->
                        <Field
                            class="flex flex-row items-start space-y-0 space-x-3 rounded-md border p-4"
                        >
                            <Checkbox
                                id="featured"
                                :checked="form.featured"
                                @update:checked="
                                    (val: boolean | 'indeterminate') =>
                                        (form.featured = val === true)
                                "
                            />
                            <div class="space-y-1 leading-none">
                                <FieldLabel for="featured"
                                    >Featured Project</FieldLabel
                                >
                                <FieldDescription>
                                    Showcase this project on the homepage.
                                </FieldDescription>
                            </div>
                        </Field>

                        <!-- Tech Stacks -->
                        <Field>
                            <FieldLabel>Tech Stacks</FieldLabel>
                            <div
                                class="mt-2 grid grid-cols-2 gap-2 md:grid-cols-4"
                            >
                                <div
                                    v-for="stack in techStacks"
                                    :key="stack.id"
                                    class="flex items-center space-x-2"
                                >
                                    <Checkbox
                                        :id="`stack-${stack.id}`"
                                        :checked="
                                            form.tech_stacks.includes(stack.id)
                                        "
                                        @update:checked="
                                            () => toggleTechStack(stack.id)
                                        "
                                    />
                                    <label
                                        :for="`stack-${stack.id}`"
                                        class="text-sm leading-none font-medium peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                                    >
                                        {{ stack.name }}
                                    </label>
                                </div>
                            </div>
                            <FieldDescription
                                v-if="form.errors.tech_stacks"
                                class="text-destructive"
                            >
                                {{ form.errors.tech_stacks }}
                            </FieldDescription>
                        </Field>
                    </FieldGroup>
                </FieldSet>
            </CardContent>
            <CardFooter
                class="flex items-center justify-end gap-2 border-t p-4"
            >
                <Button as-child variant="secondary">
                    <Link :href="projectRoute.index()"
                        ><ArrowLeft class="mr-2 size-4" /> Back</Link
                    >
                </Button>
                <Button
                    variant="default"
                    :disabled="form.processing"
                    @click="handleSubmit"
                >
                    <Loader
                        v-if="form.processing"
                        class="mr-2 size-4 animate-spin"
                    />
                    <CheckCircle v-else class="mr-2 size-4" />
                    Save Project
                </Button>
            </CardFooter>
        </Card>
    </AppLayout>
</template>
