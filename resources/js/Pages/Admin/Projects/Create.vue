<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    title: '',
    slug: '',
    short_description: '',
    description: '',
    github_url: '',
    live_url: '',
    featured: false,
    status: 'draft',
    sort_order: 0,
});

function submit() {
    form.post(route('admin.projects.store'));
}
</script>

<template>
    <Head title="Create Project" />

    <div class="min-h-screen bg-gray-100 p-6">
        <div class="mx-auto max-w-4xl">

            <!-- Header -->
            <div class="mb-6 flex items-center justify-between">

                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        Create Project
                    </h1>

                    <p class="mt-1 text-sm text-gray-600">
                        Add a new project to your portfolio.
                    </p>
                </div>

                <Link
                    :href="route('admin.projects.index')"
                    class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                >
                    ← Back
                </Link>

            </div>

            <!-- Form -->
            <form
                @submit.prevent="submit"
                class="rounded-xl bg-white p-6 shadow"
            >

                <!-- Title -->
                <div class="mb-5">
                    <label
                        for="title"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Project Title
                    </label>

                    <input
                        id="title"
                        v-model="form.title"
                        type="text"
                        class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500"
                        placeholder="My Laravel Portfolio"
                    />

                    <p
                        v-if="form.errors.title"
                        class="mt-1 text-sm text-red-600"
                    >
                        {{ form.errors.title }}
                    </p>
                </div>

                <!-- Slug -->
                <div class="mb-5">
                    <label
                        for="slug"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Slug
                    </label>

                    <input
                        id="slug"
                        v-model="form.slug"
                        type="text"
                        class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500"
                        placeholder="my-laravel-portfolio"
                    />

                    <p class="mt-1 text-xs text-gray-500">
                        Leave blank to automatically generate from the title.
                    </p>

                    <p
                        v-if="form.errors.slug"
                        class="mt-1 text-sm text-red-600"
                    >
                        {{ form.errors.slug }}
                    </p>
                </div>

                <!-- Short Description -->
                <div class="mb-5">
                    <label
                        for="short_description"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Short Description
                    </label>

                    <textarea
                        id="short_description"
                        v-model="form.short_description"
                        rows="3"
                        maxlength="500"
                        class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500"
                        placeholder="A short summary of the project..."
                    ></textarea>

                    <p
                        v-if="form.errors.short_description"
                        class="mt-1 text-sm text-red-600"
                    >
                        {{ form.errors.short_description }}
                    </p>
                </div>

                <!-- Description -->
                <div class="mb-5">
                    <label
                        for="description"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Description
                    </label>

                    <textarea
                        id="description"
                        v-model="form.description"
                        rows="7"
                        class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500"
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
                <div class="mb-5">
                    <label
                        for="github_url"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        GitHub URL
                    </label>

                    <input
                        id="github_url"
                        v-model="form.github_url"
                        type="url"
                        class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500"
                        placeholder="https://github.com/username/project"
                    />

                    <p
                        v-if="form.errors.github_url"
                        class="mt-1 text-sm text-red-600"
                    >
                        {{ form.errors.github_url }}
                    </p>
                </div>

                <!-- Live URL -->
                <div class="mb-5">
                    <label
                        for="live_url"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Live Demo URL
                    </label>

                    <input
                        id="live_url"
                        v-model="form.live_url"
                        type="url"
                        class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500"
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
                <div class="mb-5">
                    <label
                        for="status"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Status
                    </label>

                    <select
                        id="status"
                        v-model="form.status"
                        class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500"
                    >
                        <option value="draft">
                            Draft
                        </option>

                        <option value="published">
                            Published
                        </option>

                        <option value="archived">
                            Archived
                        </option>
                    </select>

                    <p
                        v-if="form.errors.status"
                        class="mt-1 text-sm text-red-600"
                    >
                        {{ form.errors.status }}
                    </p>
                </div>

                <!-- Sort Order -->
                <div class="mb-5">
                    <label
                        for="sort_order"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Sort Order
                    </label>

                    <input
                        id="sort_order"
                        v-model="form.sort_order"
                        type="number"
                        min="0"
                        class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500"
                    />

                    <p class="mt-1 text-xs text-gray-500">
                        Lower numbers appear first.
                    </p>

                    <p
                        v-if="form.errors.sort_order"
                        class="mt-1 text-sm text-red-600"
                    >
                        {{ form.errors.sort_order }}
                    </p>
                </div>

                <!-- Featured -->
                <div class="mb-6">
                    <label class="flex items-center gap-3">
                        <input
                            v-model="form.featured"
                            type="checkbox"
                            class="rounded border-gray-300 text-red-600 focus:ring-red-500"
                        />

                        <span class="text-sm font-medium text-gray-700">
                            Featured Project
                        </span>
                    </label>

                    <p class="mt-1 text-xs text-gray-500">
                        Featured projects can be highlighted on the portfolio.
                    </p>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-3 border-t pt-5">

                    <Link
                        :href="route('admin.projects.index')"
                        class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50"
                    >
                        Cancel
                    </Link>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="rounded-lg bg-red-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        {{ form.processing ? 'Saving...' : 'Create Project' }}
                    </button>

                </div>

            </form>

        </div>
    </div>
</template>
