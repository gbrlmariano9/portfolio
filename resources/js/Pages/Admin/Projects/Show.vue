<script setup>
import { Head, Link, router } from "@inertiajs/vue3";

const props = defineProps({
    project: {
        type: Object,
        required: true,
    },
});

const deleteProject = () => {
    if (confirm(`Are you sure you want to delete "${props.project.title}"?`)) {
        router.delete(route("admin.projects.destroy", props.project.id));
    }
};

const statusClasses = {
    draft: "bg-yellow-100 text-yellow-800 ring-yellow-200",
    published: "bg-green-100 text-green-800 ring-green-200",
    archived: "bg-gray-100 text-gray-700 ring-gray-200",
};
</script>

<template>
    <Head :title="`Project - ${project.title}`" />

    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="border-b border-gray-200 bg-white">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <div
                    class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
                >
                    <div>
                        <Link
                            :href="route('admin.projects.index')"
                            class="mb-3 inline-flex items-center gap-2 text-sm font-medium text-gray-600 transition hover:text-gray-900"
                        >
                            <svg
                                class="h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"
                                />
                            </svg>

                            Back to Projects
                        </Link>

                        <div class="flex flex-wrap items-center gap-3">
                            <h1
                                class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl"
                            >
                                {{ project.title }}
                            </h1>

                            <span
                                :class="
                                    statusClasses[project.status] ||
                                    'bg-gray-100 text-gray-700 ring-gray-200'
                                "
                                class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold capitalize ring-1"
                            >
                                {{ project.status }}
                            </span>
                        </div>

                        <p
                            v-if="project.short_description"
                            class="mt-2 max-w-3xl text-sm text-gray-500"
                        >
                            {{ project.short_description }}
                        </p>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-2">
                        <Link
                            :href="route('admin.projects.edit', project.id)"
                            class="inline-flex items-center gap-2 rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-800"
                        >
                            <svg
                                class="h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-9.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 8.5-8.5z"
                                />
                            </svg>

                            Edit Project
                        </Link>

                        <button
                            type="button"
                            @click="deleteProject"
                            class="inline-flex items-center gap-2 rounded-lg border border-red-200 bg-white px-4 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-red-50"
                        >
                            <svg
                                class="h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                />
                            </svg>

                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-3">
                <!-- Main Content -->
                <div class="space-y-6 lg:col-span-2">
                    <!-- Description -->
                    <section
                        class="rounded-xl border border-gray-200 bg-white shadow-sm"
                    >
                        <div class="border-b border-gray-200 px-6 py-4">
                            <h2 class="text-base font-semibold text-gray-900">
                                Description
                            </h2>
                        </div>

                        <div class="px-6 py-6">
                            <div
                                v-if="project.description"
                                class="whitespace-pre-line text-sm leading-7 text-gray-600"
                            >
                                {{ project.description }}
                            </div>

                            <p v-else class="text-sm italic text-gray-400">
                                No description provided.
                            </p>
                        </div>
                    </section>

                    <!-- Project Image -->
                    <section
                        class="rounded-xl border border-gray-200 bg-white shadow-sm"
                    >
                        <div class="border-b border-gray-200 px-6 py-4">
                            <h2 class="text-base font-semibold text-gray-900">
                                Project Image
                            </h2>
                        </div>

                        <div class="p-6">
                            <div
                                v-if="project.image"
                                class="overflow-hidden rounded-xl border border-gray-200 bg-gray-100"
                            >
                                <img
                                    :src="`/storage/${project.image}`"
                                    :alt="project.title"
                                    class="max-h-[500px] w-full object-cover"
                                />
                            </div>

                            <div
                                v-else
                                class="flex h-64 items-center justify-center rounded-xl border border-dashed border-gray-300 bg-gray-50"
                            >
                                <div class="text-center">
                                    <svg
                                        class="mx-auto h-10 w-10 text-gray-400"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.5"
                                            d="M3 16.5V7a2 2 0 012-2h3l2-2h4l2 2h3a2 2 0 012 2v9.5M3 16.5A2.5 2.5 0 005.5 19h13a2.5 2.5 0 002.5-2.5M3 16.5l3.5-3.5a2 2 0 012.828 0L12 15.5l2.172-2.172a2 2 0 012.828 0L21 17"
                                        />
                                        <circle cx="15.5" cy="9.5" r="1.5" />
                                    </svg>

                                    <p class="mt-2 text-sm text-gray-500">
                                        No project image uploaded.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Links -->
                    <section
                        class="rounded-xl border border-gray-200 bg-white shadow-sm"
                    >
                        <div class="border-b border-gray-200 px-6 py-4">
                            <h2 class="text-base font-semibold text-gray-900">
                                Project Links
                            </h2>
                        </div>

                        <div class="divide-y divide-gray-100">
                            <!-- GitHub -->
                            <div
                                class="flex items-center justify-between gap-4 px-6 py-5"
                            >
                                <div class="flex items-center gap-3">
                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-100"
                                    >
                                        <svg
                                            class="h-5 w-5 text-gray-700"
                                            fill="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                d="M12 .5a12 12 0 00-3.79 23.39c.6.11.82-.26.82-.58v-2.26c-3.34.73-4.04-1.42-4.04-1.42-.55-1.39-1.34-1.76-1.34-1.76-1.09-.75.08-.74.08-.74 1.2.08 1.84 1.24 1.84 1.24 1.07 1.84 2.81 1.31 3.5 1 .11-.78.42-1.31.76-1.61-2.67-.3-5.47-1.34-5.47-5.94 0-1.31.47-2.38 1.24-3.22-.13-.3-.54-1.52.12-3.18 0 0 1.01-.32 3.3 1.23a11.5 11.5 0 016 0c2.29-1.55 3.3-1.23 3.3-1.23.66 1.66.25 2.88.12 3.18.77.84 1.24 1.91 1.24 3.22 0 4.61-2.8 5.63-5.48 5.93.43.37.81 1.1.81 2.22v3.29c0 .32.22.69.83.57A12 12 0 0012 .5z"
                                            />
                                        </svg>
                                    </div>

                                    <div>
                                        <p
                                            class="text-sm font-semibold text-gray-900"
                                        >
                                            GitHub Repository
                                        </p>

                                        <p
                                            v-if="project.github_url"
                                            class="max-w-md truncate text-xs text-gray-500"
                                        >
                                            {{ project.github_url }}
                                        </p>

                                        <p v-else class="text-xs text-gray-400">
                                            No GitHub URL provided.
                                        </p>
                                    </div>
                                </div>

                                <a
                                    v-if="project.github_url"
                                    :href="project.github_url"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="shrink-0 rounded-lg border border-gray-300 px-3 py-2 text-xs font-medium text-gray-700 transition hover:bg-gray-50"
                                >
                                    Open
                                </a>
                            </div>

                            <!-- Live -->
                            <div
                                class="flex items-center justify-between gap-4 px-6 py-5"
                            >
                                <div class="flex items-center gap-3">
                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-50"
                                    >
                                        <svg
                                            class="h-5 w-5 text-blue-600"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4m-1-9l3-3m0 0v4m0-4h-4"
                                            />
                                        </svg>
                                    </div>

                                    <div>
                                        <p
                                            class="text-sm font-semibold text-gray-900"
                                        >
                                            Live Website
                                        </p>

                                        <p
                                            v-if="project.live_url"
                                            class="max-w-md truncate text-xs text-gray-500"
                                        >
                                            {{ project.live_url }}
                                        </p>

                                        <p v-else class="text-xs text-gray-400">
                                            No live URL provided.
                                        </p>
                                    </div>
                                </div>

                                <a
                                    v-if="project.live_url"
                                    :href="project.live_url"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="shrink-0 rounded-lg border border-gray-300 px-3 py-2 text-xs font-medium text-gray-700 transition hover:bg-gray-50"
                                >
                                    Open
                                </a>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Project Information -->
                    <section
                        class="rounded-xl border border-gray-200 bg-white shadow-sm"
                    >
                        <div class="border-b border-gray-200 px-6 py-4">
                            <h2 class="text-base font-semibold text-gray-900">
                                Project Information
                            </h2>
                        </div>

                        <div class="divide-y divide-gray-100">
                            <!-- Status -->
                            <div class="px-6 py-4">
                                <p
                                    class="text-xs font-medium uppercase tracking-wide text-gray-400"
                                >
                                    Status
                                </p>

                                <p
                                    class="mt-1 text-sm font-semibold capitalize text-gray-900"
                                >
                                    {{ project.status }}
                                </p>
                            </div>

                            <!-- Featured -->
                            <div class="px-6 py-4">
                                <p
                                    class="text-xs font-medium uppercase tracking-wide text-gray-400"
                                >
                                    Featured
                                </p>

                                <div class="mt-1">
                                    <span
                                        v-if="project.featured"
                                        class="inline-flex rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700"
                                    >
                                        Yes
                                    </span>

                                    <span
                                        v-else
                                        class="inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600"
                                    >
                                        No
                                    </span>
                                </div>
                            </div>

                            <!-- Sort Order -->
                            <div class="px-6 py-4">
                                <p
                                    class="text-xs font-medium uppercase tracking-wide text-gray-400"
                                >
                                    Sort Order
                                </p>

                                <p
                                    class="mt-1 text-sm font-semibold text-gray-900"
                                >
                                    {{ project.sort_order }}
                                </p>
                            </div>

                            <!-- Slug -->
                            <div class="px-6 py-4">
                                <p
                                    class="text-xs font-medium uppercase tracking-wide text-gray-400"
                                >
                                    Slug
                                </p>

                                <p class="mt-1 break-all text-sm text-gray-600">
                                    {{ project.slug }}
                                </p>
                            </div>
                        </div>
                    </section>

                    <!-- Dates -->
                    <section
                        class="rounded-xl border border-gray-200 bg-white shadow-sm"
                    >
                        <div class="border-b border-gray-200 px-6 py-4">
                            <h2 class="text-base font-semibold text-gray-900">
                                Timeline
                            </h2>
                        </div>

                        <div class="space-y-5 px-6 py-5">
                            <div>
                                <p
                                    class="text-xs font-medium uppercase tracking-wide text-gray-400"
                                >
                                    Created
                                </p>

                                <p class="mt-1 text-sm text-gray-700">
                                    {{
                                        new Date(
                                            project.created_at,
                                        ).toLocaleString()
                                    }}
                                </p>
                            </div>

                            <div>
                                <p
                                    class="text-xs font-medium uppercase tracking-wide text-gray-400"
                                >
                                    Last Updated
                                </p>

                                <p class="mt-1 text-sm text-gray-700">
                                    {{
                                        new Date(
                                            project.updated_at,
                                        ).toLocaleString()
                                    }}
                                </p>
                            </div>

                            <div v-if="project.deleted_at">
                                <p
                                    class="text-xs font-medium uppercase tracking-wide text-red-400"
                                >
                                    Deleted
                                </p>

                                <p class="mt-1 text-sm text-red-600">
                                    {{
                                        new Date(
                                            project.deleted_at,
                                        ).toLocaleString()
                                    }}
                                </p>
                            </div>
                        </div>
                    </section>

                    <!-- Technologies -->
                    <section
                        class="rounded-xl border border-gray-200 bg-white shadow-sm"
                    >
                        <div class="border-b border-gray-200 px-6 py-4">
                            <h2 class="text-base font-semibold text-gray-900">
                                Technologies
                            </h2>
                        </div>

                        <div class="px-6 py-5">
                            <div
                                v-if="
                                    project.technologies &&
                                    project.technologies.length
                                "
                                class="flex flex-wrap gap-2"
                            >
                                <span
                                    v-for="technology in project.technologies"
                                    :key="technology.id"
                                    class="rounded-full bg-gray-100 px-3 py-1.5 text-xs font-medium text-gray-700"
                                >
                                    {{ technology.name }}
                                </span>
                            </div>

                            <p v-else class="text-sm italic text-gray-400">
                                No technologies assigned.
                            </p>
                        </div>
                    </section>
                </div>
            </div>
        </main>
    </div>
</template>
