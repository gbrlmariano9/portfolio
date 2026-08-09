<script setup>
import { Head, Link, router, useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    project: {
        type: Object,
        required: true,
    },

    technologies: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    title: props.project.title ?? "",
    slug: props.project.slug ?? "",
    short_description: props.project.short_description ?? "",
    description: props.project.description ?? "",
    github_url: props.project.github_url ?? "",
    live_url: props.project.live_url ?? "",
    featured: Boolean(props.project.featured),
    status: props.project.status ?? "draft",
    sort_order: props.project.sort_order ?? 0,
    technologies:
        props.project.technologies?.map((technology) => technology.id) ?? [],

    images: [],
    image_alt_text: "",
});

const processingImage = ref(null);
const savedImage = ref(null);


const setPrimary = (image) => {
    if (processingImage.value) {
        return;
    }

    processingImage.value = image.id;

    router.post(
        route("admin.projects.images.primary", {
            project: props.project.id,
            image: image.id,
        }),
        {},
        {
            preserveScroll: true,
            onFinish: () => {
                processingImage.value = null;
            },
        },
    );
};

const updateImage = (image) => {
    if (processingImage.value) {
        return;
    }

    processingImage.value = image.id;
    savedImage.value = null;

    router.put(
        route("admin.projects.images.update", {
            project: props.project.id,
            image: image.id,
        }),
        {
            alt_text: image.alt_text ?? "",
            sort_order: image.sort_order ?? 0,
        },
        {
            preserveScroll: true,

            onSuccess: () => {
                savedImage.value = image.id;

                setTimeout(() => {
                    if (savedImage.value === image.id) {
                        savedImage.value = null;
                    }
                }, 2000);
            },

            onFinish: () => {
                processingImage.value = null;
            },
        }
    );
};



const deleteImage = (image) => {
    if (processingImage.value) {
        return;
    }

    const confirmed = window.confirm(
        "Are you sure you want to delete this image?",
    );

    if (!confirmed) {
        return;
    }

    processingImage.value = image.id;

    router.delete(
        route("admin.projects.images.delete", {
            project: props.project.id,
            image: image.id,
        }),
        {
            preserveScroll: true,
            onFinish: () => {
                processingImage.value = null;
            },
        },
    );
};

const handleImages = (event) => {
    form.images = Array.from(event.target.files);
};

const submit = () => {
    form.transform((data) => ({
        ...data,
        _method: "PUT",
    })).post(route("admin.projects.update", props.project.id), {
        forceFormData: true,
        preserveScroll: true,
    });
};
</script>

<template>
    <Head :title="`Edit ${project.title}`" />

    <div class="p-6">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Project</h1>

                <p class="mt-1 text-sm text-gray-500">
                    Update your project information.
                </p>
            </div>

            <Link
                :href="route('admin.projects.show', project.id)"
                class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
            >
                ← Back
            </Link>
        </div>

        <!-- Form -->
        <form @submit.prevent="submit" class="space-y-6">
            <!-- Project Information -->
            <div
                class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm"
            >
                <h2 class="mb-5 text-lg font-semibold text-gray-900">
                    Project Information
                </h2>

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <!-- Title -->
                    <div>
                        <label
                            class="mb-2 block text-sm font-medium text-gray-700"
                        >
                            Project Title
                        </label>

                        <input
                            v-model="form.title"
                            type="text"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-red-500"
                            placeholder="Enter project title"
                        />

                        <p
                            v-if="form.errors.title"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.title }}
                        </p>
                    </div>

                    <!-- Slug -->
                    <div>
                        <label
                            class="mb-2 block text-sm font-medium text-gray-700"
                        >
                            Slug
                        </label>

                        <input
                            v-model="form.slug"
                            type="text"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-red-500"
                            placeholder="project-slug"
                        />

                        <p
                            v-if="form.errors.slug"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.slug }}
                        </p>
                    </div>

                    <!-- Short Description -->
                    <div class="md:col-span-2">
                        <label
                            class="mb-2 block text-sm font-medium text-gray-700"
                        >
                            Short Description
                        </label>

                        <textarea
                            v-model="form.short_description"
                            rows="3"
                            maxlength="500"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-red-500"
                            placeholder="Brief description of the project"
                        ></textarea>

                        <div class="mt-1 flex justify-between">
                            <p
                                v-if="form.errors.short_description"
                                class="text-sm text-red-600"
                            >
                                {{ form.errors.short_description }}
                            </p>

                            <span class="ml-auto text-xs text-gray-400">
                                {{ form.short_description.length }}/500
                            </span>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label
                            class="mb-2 block text-sm font-medium text-gray-700"
                        >
                            Description
                        </label>

                        <textarea
                            v-model="form.description"
                            rows="7"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-red-500"
                            placeholder="Describe the project in detail..."
                        ></textarea>

                        <p
                            v-if="form.errors.description"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.description }}
                        </p>
                    </div>

                    <!-- GitHub -->
                    <div>
                        <label
                            class="mb-2 block text-sm font-medium text-gray-700"
                        >
                            GitHub URL
                        </label>

                        <input
                            v-model="form.github_url"
                            type="url"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-red-500"
                            placeholder="https://github.com/..."
                        />

                        <p
                            v-if="form.errors.github_url"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.github_url }}
                        </p>
                    </div>

                    <!-- Live URL -->
                    <div>
                        <label
                            class="mb-2 block text-sm font-medium text-gray-700"
                        >
                            Live URL
                        </label>

                        <input
                            v-model="form.live_url"
                            type="url"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-red-500"
                            placeholder="https://example.com"
                        />

                        <p
                            v-if="form.errors.live_url"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.live_url }}
                        </p>
                    </div>

                    <!-- Status -->
                    <div>
                        <label
                            class="mb-2 block text-sm font-medium text-gray-700"
                        >
                            Status
                        </label>

                        <select
                            v-model="form.status"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-red-500"
                        >
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                            <option value="archived">Archived</option>
                        </select>

                        <p
                            v-if="form.errors.status"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.status }}
                        </p>
                    </div>

                    <!-- Sort Order -->
                    <div>
                        <label
                            class="mb-2 block text-sm font-medium text-gray-700"
                        >
                            Sort Order
                        </label>

                        <input
                            v-model.number="form.sort_order"
                            type="number"
                            min="0"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-red-500"
                        />

                        <p
                            v-if="form.errors.sort_order"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.sort_order }}
                        </p>
                    </div>
                </div>

                <!-- Featured -->
                <div class="mt-5">
                    <label class="flex cursor-pointer items-center gap-3">
                        <input
                            v-model="form.featured"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-500"
                        />

                        <span class="text-sm font-medium text-gray-700">
                            Featured Project
                        </span>
                    </label>
                </div>
            </div>

            <!-- Technologies -->
            <div
                class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm"
            >
                <h2 class="mb-2 text-lg font-semibold text-gray-900">
                    Technologies
                </h2>

                <p class="mb-5 text-sm text-gray-500">
                    Select the technologies used in this project.
                </p>

                <div
                    v-if="technologies.length"
                    class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3"
                >
                    <label
                        v-for="technology in technologies"
                        :key="technology.id"
                        class="flex cursor-pointer items-center gap-3 rounded-lg border border-gray-200 p-3 transition hover:border-red-300 hover:bg-red-50"
                    >
                        <input
                            v-model="form.technologies"
                            :value="technology.id"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-500"
                        />

                        <div>
                            <div class="text-sm font-medium text-gray-900">
                                {{ technology.name }}
                            </div>

                            <div class="text-xs text-gray-400">
                                {{ technology.slug }}
                            </div>
                        </div>
                    </label>
                </div>

                <div
                    v-else
                    class="rounded-lg bg-gray-50 p-4 text-sm text-gray-500"
                >
                    No technologies available.
                </div>
            </div>

            <!-- Project Images -->
            <div
                class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm"
            >
                <div class="mb-5">
                    <h2 class="text-lg font-semibold text-gray-900">
                        Project Images
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Upload images for this project.
                    </p>
                </div>

                <!-- Existing Images -->
                <div
                    v-if="project.images?.length"
                    class="mb-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3"
                >
                    <div
                        v-for="image in project.images"
                        :key="image.id"
                        class="overflow-hidden rounded-xl border border-gray-200 bg-white"
                    >
                        <img
                            :src="`/storage/${image.image_path}`"
                            :alt="image.alt_text || project.title"
                            class="h-48 w-full object-cover"
                        />

                        <div class="p-4">
                            <!-- Image Header -->
                            <div class="mb-3 flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-700">
                                    Image #{{ image.sort_order + 1 }}
                                </span>

                                <span
                                    v-if="image.is_primary"
                                    class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-700"
                                >
                                    Primary
                                </span>
                            </div>

                            <!-- Alt Text -->
                            <!-- Image Details -->
                            <div class="space-y-4">

                                <!-- Alt Text -->
                                <div>
                                    <label class="mb-1 block text-xs font-medium text-gray-600">
                                        Alt Text
                                    </label>

                                    <input
                                        v-model="image.alt_text"
                                        type="text"
                                        maxlength="255"
                                        placeholder="Describe this image"
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-red-500 focus:ring-red-500"
                                    />
                                </div>

                                <!-- Sort Order -->
                                <div>
                                    <label class="mb-1 block text-xs font-medium text-gray-600">
                                        Sort Order
                                    </label>

                                    <input
                                        v-model.number="image.sort_order"
                                        type="number"
                                        min="0"
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-red-500 focus:ring-red-500"
                                    />
                                </div>

                            </div>

                            <!-- Actions -->
                            <div class="flex gap-2">
                                <!-- Set Primary -->
                                <button
                                    type="button"
                                    @click="updateImage(image)"
                                    :disabled="
                                        processingImage === image.id ||
                                        savedImage === image.id
                                    "
                                    class="flex-1 rounded-lg px-3 py-2 text-xs font-semibold transition disabled:cursor-not-allowed disabled:opacity-70"
                                    :class="
                                        savedImage === image.id
                                            ? 'bg-green-100 text-green-700'
                                            : 'bg-gray-900 text-white hover:bg-gray-800'
                                    "
                                >
                                    <span v-if="processingImage === image.id">
                                        Saving...
                                    </span>

                                    <span v-else-if="savedImage === image.id">
                                        ✓ Saved
                                    </span>

                                    <span v-else>
                                        Save
                                    </span>
                                </button>

                                <!-- Delete -->
                                <button
                                    type="button"
                                    @click="deleteImage(image)"
                                    :disabled="processingImage === image.id"
                                    class="rounded-lg border border-red-200 px-3 py-2 text-xs font-semibold text-red-600 transition hover:bg-red-50 disabled:cursor-not-allowed disabled:opacity-50"
                                >
                                    🗑 Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upload -->
                <div
                    class="rounded-xl border-2 border-dashed border-gray-300 p-6"
                >
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Upload Images
                    </label>

                    <input
                        type="file"
                        multiple
                        accept="image/jpeg,image/png,image/webp"
                        @change="handleImages"
                        class="block w-full text-sm text-gray-600 file:mr-4 file:rounded-lg file:border-0 file:bg-red-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-red-700 hover:file:bg-red-100"
                    />

                    <p class="mt-2 text-xs text-gray-500">
                        JPG, JPEG, PNG, or WEBP. Maximum 5 MB per image.
                    </p>

                    <!-- Selected files -->
                    <div v-if="form.images.length" class="mt-4">
                        <p class="mb-2 text-sm font-medium text-gray-700">
                            Selected Images
                        </p>

                        <ul class="space-y-2">
                            <li
                                v-for="(image, index) in form.images"
                                :key="index"
                                class="flex items-center justify-between rounded-lg bg-gray-50 px-3 py-2"
                            >
                                <span class="truncate text-sm text-gray-700">
                                    {{ image.name }}
                                </span>

                                <span
                                    class="ml-3 shrink-0 text-xs text-gray-400"
                                >
                                    {{ (image.size / 1024 / 1024).toFixed(2) }}
                                    MB
                                </span>
                            </li>
                        </ul>
                    </div>

                    <!-- Alt Text -->
                    <div class="mt-5">
                        <label
                            class="mb-2 block text-sm font-medium text-gray-700"
                        >
                            Alt Text
                        </label>

                        <input
                            v-model="form.image_alt_text"
                            type="text"
                            maxlength="255"
                            placeholder="Describe the uploaded images"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-red-500"
                        />

                        <p class="mt-1 text-xs text-gray-500">
                            This will be applied to the images uploaded in this
                            batch.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-3">
                <Link
                    :href="route('admin.projects.show', project.id)"
                    class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                >
                    Cancel
                </Link>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="rounded-lg bg-red-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-50"
                >
                    <span v-if="form.processing"> Saving... </span>

                    <span v-else> Save Changes </span>
                </button>
            </div>
        </form>
    </div>
</template>
