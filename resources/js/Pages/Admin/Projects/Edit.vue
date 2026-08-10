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
        },
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

    <div class="min-h-screen bg-slate-50 p-6">
        <div class="mx-auto max-w-6xl">
            <div class="mb-6 overflow-hidden rounded-[32px] border border-slate-200 bg-white px-6 py-7 shadow-sm">
                <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.3em] text-red-600">Edit project</p>
                        <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-900">Update project details</h1>
                        <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-600">Adjust the title, status, links, and images for this project.</p>
                    </div>

                    <Link
                        :href="route('admin.projects.show', project.id)"
                        class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
                    >
                        ← Back to project
                    </Link>
                </div>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <section class="overflow-hidden rounded-[32px] bg-white p-6 shadow-sm ring-1 ring-slate-200">
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-slate-900">Project information</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-500">Edit title, slug, descriptions, and deploy links.</p>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">Project Title</label>
                            <input
                                v-model="form.title"
                                type="text"
                                class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-red-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-100"
                                placeholder="Enter project title"
                            />
                            <p v-if="form.errors.title" class="mt-2 text-sm text-red-600">{{ form.errors.title }}</p>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">Slug</label>
                            <input
                                v-model="form.slug"
                                type="text"
                                class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-red-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-100"
                                placeholder="project-slug"
                            />
                            <p v-if="form.errors.slug" class="mt-2 text-sm text-red-600">{{ form.errors.slug }}</p>
                        </div>

                        <div class="md:col-span-2">
                            <label class="mb-2 block text-sm font-medium text-slate-700">Short Description</label>
                            <textarea
                                v-model="form.short_description"
                                rows="3"
                                maxlength="500"
                                class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-red-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-100"
                                placeholder="Brief description of the project"
                            ></textarea>
                            <div class="mt-2 flex items-center justify-between gap-4">
                                <p v-if="form.errors.short_description" class="text-sm text-red-600">{{ form.errors.short_description }}</p>
                                <span class="text-xs text-slate-400">{{ form.short_description.length }}/500</span>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="mb-2 block text-sm font-medium text-slate-700">Description</label>
                            <textarea
                                v-model="form.description"
                                rows="7"
                                class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-red-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-100"
                                placeholder="Describe the project in detail..."
                            ></textarea>
                            <p v-if="form.errors.description" class="mt-2 text-sm text-red-600">{{ form.errors.description }}</p>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">GitHub URL</label>
                            <input
                                v-model="form.github_url"
                                type="url"
                                class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-red-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-100"
                                placeholder="https://github.com/..."
                            />
                            <p v-if="form.errors.github_url" class="mt-2 text-sm text-red-600">{{ form.errors.github_url }}</p>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">Live URL</label>
                            <input
                                v-model="form.live_url"
                                type="url"
                                class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-red-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-100"
                                placeholder="https://example.com"
                            />
                            <p v-if="form.errors.live_url" class="mt-2 text-sm text-red-600">{{ form.errors.live_url }}</p>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">Status</label>
                            <select
                                v-model="form.status"
                                class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-red-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-100"
                            >
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                                <option value="archived">Archived</option>
                            </select>
                            <p v-if="form.errors.status" class="mt-2 text-sm text-red-600">{{ form.errors.status }}</p>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">Sort Order</label>
                            <input
                                v-model.number="form.sort_order"
                                type="number"
                                min="0"
                                class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-red-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-100"
                            />
                            <p v-if="form.errors.sort_order" class="mt-2 text-sm text-red-600">{{ form.errors.sort_order }}</p>
                        </div>
                    </div>

                    <div class="mt-6 rounded-[32px] bg-slate-50 p-5">
                        <label class="flex cursor-pointer items-center gap-3">
                            <input
                                v-model="form.featured"
                                type="checkbox"
                                class="h-4 w-4 rounded border-slate-300 text-red-600 focus:ring-red-500"
                            />
                            <span class="text-sm font-medium text-slate-700">Featured Project</span>
                        </label>
                        <p class="mt-3 text-sm text-slate-500">Featured projects can be highlighted on your portfolio homepage and project listings.</p>
                    </div>
                </section>

                <section class="overflow-hidden rounded-[32px] bg-white p-6 shadow-sm ring-1 ring-slate-200">
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-slate-900">Technologies</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-500">Choose the stack used for this project.</p>
                    </div>

                    <div v-if="technologies.length" class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">
                        <label
                            v-for="technology in technologies"
                            :key="technology.id"
                            class="flex cursor-pointer items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 p-3 transition hover:border-red-300 hover:bg-red-50"
                        >
                            <input
                                v-model="form.technologies"
                                :value="technology.id"
                                type="checkbox"
                                class="h-4 w-4 rounded border-slate-300 text-red-600 focus:ring-red-500"
                            />

                            <div>
                                <div class="text-sm font-medium text-slate-900">{{ technology.name }}</div>
                                <div class="text-xs text-slate-500">{{ technology.slug }}</div>
                            </div>
                        </label>
                    </div>

                    <div v-else class="rounded-2xl bg-slate-50 p-4 text-sm text-slate-500">
                        No technologies available.
                    </div>
                </section>

                <section class="overflow-hidden rounded-[32px] bg-white p-6 shadow-sm ring-1 ring-slate-200">
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-slate-900">Project images</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-500">Manage the images that appear with this project.</p>
                    </div>

                    <div v-if="project.images?.length" class="mb-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                        <div
                            v-for="image in project.images"
                            :key="image.id"
                            class="overflow-hidden rounded-[28px] border border-slate-200 bg-white"
                        >
                            <img
                                :src="`/storage/${image.image_path}`"
                                :alt="image.alt_text || project.title"
                                class="h-48 w-full object-cover"
                            />

                            <div class="p-4">
                                <div class="mb-3 flex items-center justify-between">
                                    <span class="text-sm font-medium text-slate-700">Image #{{ image.sort_order + 1 }}</span>
                                    <span v-if="image.is_primary" class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-700">Primary</span>
                                </div>

                                <div class="space-y-4">
                                    <div>
                                        <label class="mb-1 block text-xs font-medium text-slate-600">Alt Text</label>
                                        <input
                                            v-model="image.alt_text"
                                            type="text"
                                            maxlength="255"
                                            placeholder="Describe this image"
                                            class="w-full rounded-2xl border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100"
                                        />
                                    </div>

                                    <div>
                                        <label class="mb-1 block text-xs font-medium text-slate-600">Sort Order</label>
                                        <input
                                            v-model.number="image.sort_order"
                                            type="number"
                                            min="0"
                                            class="w-full rounded-2xl border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100"
                                        />
                                    </div>
                                </div>

                                <div class="mt-4 flex flex-col gap-2 sm:flex-row">
                                    <button
                                        type="button"
                                        @click="updateImage(image)"
                                        :disabled="processingImage === image.id || savedImage === image.id"
                                        class="flex-1 rounded-2xl px-3 py-2 text-xs font-semibold transition disabled:cursor-not-allowed disabled:opacity-70"
                                        :class="savedImage === image.id ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-900 text-white hover:bg-slate-800'"
                                    >
                                        <span v-if="processingImage === image.id">Saving...</span>
                                        <span v-else-if="savedImage === image.id">✓ Saved</span>
                                        <span v-else>Save</span>
                                    </button>

                                    <button
                                        type="button"
                                        @click="deleteImage(image)"
                                        :disabled="processingImage === image.id"
                                        class="rounded-2xl border border-red-200 px-3 py-2 text-xs font-semibold text-red-600 transition hover:bg-red-50 disabled:cursor-not-allowed disabled:opacity-50"
                                    >
                                        🗑 Delete
                                    </button>

                                    <button
                                        v-if="!image.is_primary"
                                        type="button"
                                        @click="setPrimary(image)"
                                        :disabled="processingImage === image.id"
                                        class="flex-1 rounded-2xl border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-50"
                                    >
                                        <span v-if="processingImage === image.id">Updating...</span>
                                        <span v-else>⭐ Set Primary</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-[32px] border-2 border-dashed border-slate-300 p-6">
                        <label class="mb-3 block text-sm font-medium text-slate-700">Upload images</label>
                        <input
                            type="file"
                            multiple
                            accept="image/jpeg,image/png,image/webp"
                            @change="handleImages"
                            class="block w-full text-sm text-slate-600 file:mr-4 file:rounded-2xl file:border-0 file:bg-red-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-red-700 hover:file:bg-red-100"
                        />
                        <p class="mt-2 text-xs text-slate-500">JPG, JPEG, PNG, or WEBP. Maximum 5 MB per image.</p>

                        <div v-if="form.images.length" class="mt-4 rounded-2xl bg-slate-50 p-4">
                            <p class="mb-3 text-sm font-medium text-slate-700">Selected images</p>
                            <ul class="space-y-2">
                                <li v-for="(image, index) in form.images" :key="index" class="flex items-center justify-between rounded-2xl bg-white px-3 py-2 shadow-sm">
                                    <span class="truncate text-sm text-slate-700">{{ image.name }}</span>
                                    <span class="ml-3 shrink-0 text-xs text-slate-400">{{ (image.size / 1024 / 1024).toFixed(2) }} MB</span>
                                </li>
                            </ul>
                        </div>

                        <div class="mt-5">
                            <label class="mb-2 block text-sm font-medium text-slate-700">Alt Text</label>
                            <input
                                v-model="form.image_alt_text"
                                type="text"
                                maxlength="255"
                                placeholder="Describe the uploaded images"
                                class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-red-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-100"
                            />
                            <p class="mt-2 text-xs text-slate-500">This alt text will be applied to the images uploaded in this batch.</p>
                        </div>
                    </div>
                </section>

                <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <Link
                        :href="route('admin.projects.show', project.id)"
                        class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
                    >
                        Cancel
                    </Link>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="inline-flex items-center justify-center rounded-2xl bg-red-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        <span v-if="form.processing">Saving...</span>
                        <span v-else>Save Changes</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
