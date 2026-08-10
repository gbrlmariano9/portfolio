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

    <div class="min-h-screen bg-slate-50">
        <div class="border-b border-slate-200 bg-white shadow-sm">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                    <div>
                        <Link
                            :href="route('admin.projects.index')"
                            class="mb-3 inline-flex items-center gap-2 text-sm font-medium text-slate-600 transition hover:text-slate-900"
                        >
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Projects
                        </Link>

                        <div class="flex flex-wrap items-center gap-3">
                            <h1 class="text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl">{{ project.title }}</h1>
                            <span
                                :class="statusClasses[project.status] || 'bg-slate-100 text-slate-700 ring-slate-200'"
                                class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold capitalize ring-1"
                            >
                                {{ project.status }}
                            </span>
                        </div>

                        <p class="mt-3 max-w-3xl text-sm leading-6 text-slate-500">
                            {{ project.short_description || 'No short description provided.' }}
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <Link
                            :href="route('admin.projects.edit', project.id)"
                            class="inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800"
                        >
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-9.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 8.5-8.5z" />
                            </svg>
                            Edit Project
                        </Link>

                        <button
                            type="button"
                            @click="deleteProject"
                            class="inline-flex items-center gap-2 rounded-2xl border border-red-200 bg-white px-4 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-red-50"
                        >
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-[2fr_1fr]">
                <div class="space-y-6">
                    <section class="overflow-hidden rounded-[32px] bg-white p-6 shadow-sm ring-1 ring-slate-200">
                        <div class="mb-5">
                            <h2 class="text-lg font-semibold text-slate-900">Description</h2>
                            <p class="mt-2 text-sm leading-6 text-slate-500">The full project writeup shown to visitors.</p>
                        </div>

                        <div class="text-sm leading-7 text-slate-600">
                            <div v-if="project.description" class="whitespace-pre-line">{{ project.description }}</div>
                            <p v-else class="italic text-slate-400">No description provided.</p>
                        </div>
                    </section>

                    <section class="overflow-hidden rounded-[32px] bg-white p-6 shadow-sm ring-1 ring-slate-200">
                        <div class="mb-5">
                            <h2 class="text-lg font-semibold text-slate-900">Project image</h2>
                            <p class="mt-2 text-sm leading-6 text-slate-500">A visual preview for this project.</p>
                        </div>

                        <div>
                            <div v-if="project.image" class="overflow-hidden rounded-[28px] border border-slate-200 bg-slate-100">
                                <img :src="`/storage/${project.image}`" :alt="project.title" class="h-[420px] w-full object-cover" />
                            </div>
                            <div v-else class="flex h-64 items-center justify-center rounded-[28px] border border-dashed border-slate-300 bg-slate-50">
                                <div class="text-center">
                                    <svg class="mx-auto h-10 w-10 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 16.5V7a2 2 0 012-2h3l2-2h4l2 2h3a2 2 0 012 2v9.5M3 16.5A2.5 2.5 0 005.5 19h13a2.5 2.5 0 002.5-2.5M3 16.5l3.5-3.5a2 2 0 012.828 0L12 15.5l2.172-2.172a2 2 0 012.828 0L21 17" />
                                        <circle cx="15.5" cy="9.5" r="1.5" />
                                    </svg>
                                    <p class="mt-2 text-sm text-slate-500">No project image uploaded.</p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="overflow-hidden rounded-[32px] bg-white p-6 shadow-sm ring-1 ring-slate-200">
                        <div class="mb-5">
                            <h2 class="text-lg font-semibold text-slate-900">Project links</h2>
                            <p class="mt-2 text-sm leading-6 text-slate-500">Links visitors can use to explore the repository and live demo.</p>
                        </div>

                        <div class="divide-y divide-slate-100">
                            <div class="flex flex-col gap-4 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-100 text-slate-700">
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 .5a12 12 0 00-3.79 23.39c.6.11.82-.26.82-.58v-2.26c-3.34.73-4.04-1.42-4.04-1.42-.55-1.39-1.34-1.76-1.34-1.76-1.09-.75.08-.74.08-.74 1.2.08 1.84 1.24 1.84 1.24 1.07 1.84 2.81 1.31 3.5 1 .11-.78.42-1.31.76-1.61-2.67-.3-5.47-1.34-5.47-5.94 0-1.31.47-2.38 1.24-3.22-.13-.3-.54-1.52.12-3.18 0 0 1.01-.32 3.3 1.23a11.5 11.5 0 016 0c2.29-1.55 3.3-1.23 3.3-1.23.66 1.66.25 2.88.12 3.18.77.84 1.24 1.91 1.24 3.22 0 4.61-2.8 5.63-5.48 5.93.43.37.81 1.1.81 2.22v3.29c0 .32.22.69.83.57A12 12 0 0012 .5z" /></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-slate-900">GitHub repository</p>
                                        <p v-if="project.github_url" class="max-w-md truncate text-xs text-slate-500">{{ project.github_url }}</p>
                                        <p v-else class="text-xs text-slate-400">No GitHub URL provided.</p>
                                    </div>
                                </div>
                                <a
                                    v-if="project.github_url"
                                    :href="project.github_url"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex rounded-2xl border border-slate-200 px-4 py-2 text-xs font-medium text-slate-700 transition hover:bg-slate-50"
                                >
                                    Open
                                </a>
                            </div>

                            <div class="flex flex-col gap-4 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4m-1-9l3-3m0 0v4m0-4h-4" /></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-slate-900">Live website</p>
                                        <p v-if="project.live_url" class="max-w-md truncate text-xs text-slate-500">{{ project.live_url }}</p>
                                        <p v-else class="text-xs text-slate-400">No live URL provided.</p>
                                    </div>
                                </div>
                                <a
                                    v-if="project.live_url"
                                    :href="project.live_url"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex rounded-2xl border border-slate-200 px-4 py-2 text-xs font-medium text-slate-700 transition hover:bg-slate-50"
                                >
                                    Open
                                </a>
                            </div>
                        </div>
                    </section>
                </div>

                <aside class="space-y-6">
                    <section class="overflow-hidden rounded-[32px] bg-white p-6 shadow-sm ring-1 ring-slate-200">
                        <div class="mb-4">
                            <h2 class="text-lg font-semibold text-slate-900">Project details</h2>
                            <p class="mt-2 text-sm leading-6 text-slate-500">Status, featured flag, and metadata for the project.</p>
                        </div>
                        <div class="space-y-4">
                            <div class="rounded-2xl bg-slate-50 p-4">
                                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Status</p>
                                <p class="mt-2 text-sm font-semibold text-slate-900">{{ project.status }}</p>
                            </div>
                            <div class="rounded-2xl bg-slate-50 p-4">
                                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Featured</p>
                                <p class="mt-2 text-sm font-semibold text-slate-900">{{ project.featured ? 'Yes' : 'No' }}</p>
                            </div>
                            <div class="rounded-2xl bg-slate-50 p-4">
                                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Sort order</p>
                                <p class="mt-2 text-sm font-semibold text-slate-900">{{ project.sort_order }}</p>
                            </div>
                            <div class="rounded-2xl bg-slate-50 p-4">
                                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Slug</p>
                                <p class="mt-2 break-all text-sm text-slate-600">{{ project.slug }}</p>
                            </div>
                        </div>
                    </section>

                    <section class="overflow-hidden rounded-[32px] bg-white p-6 shadow-sm ring-1 ring-slate-200">
                        <div class="mb-4">
                            <h2 class="text-lg font-semibold text-slate-900">Technologies</h2>
                            <p class="mt-2 text-sm leading-6 text-slate-500">Tools and frameworks used in this project.</p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <span
                                v-for="technology in project.technologies"
                                :key="technology.id"
                                class="rounded-full bg-slate-100 px-3 py-1.5 text-xs font-medium text-slate-700"
                            >
                                {{ technology.name }}
                            </span>
                        </div>
                        <p v-if="!project.technologies?.length" class="text-sm italic text-slate-400">No technologies assigned.</p>
                    </section>

                    <section class="overflow-hidden rounded-[32px] bg-white p-6 shadow-sm ring-1 ring-slate-200">
                        <div class="mb-4">
                            <h2 class="text-lg font-semibold text-slate-900">Timeline</h2>
                            <p class="mt-2 text-sm leading-6 text-slate-500">Project creation and update timestamps.</p>
                        </div>
                        <div class="space-y-4">
                            <div class="rounded-2xl bg-slate-50 p-4">
                                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Created</p>
                                <p class="mt-2 text-sm text-slate-900">{{ new Date(project.created_at).toLocaleString() }}</p>
                            </div>
                            <div class="rounded-2xl bg-slate-50 p-4">
                                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Last updated</p>
                                <p class="mt-2 text-sm text-slate-900">{{ new Date(project.updated_at).toLocaleString() }}</p>
                            </div>
                            <div v-if="project.deleted_at" class="rounded-2xl bg-red-50 p-4">
                                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-red-500">Deleted</p>
                                <p class="mt-2 text-sm text-red-700">{{ new Date(project.deleted_at).toLocaleString() }}</p>
                            </div>
                        </div>
                    </section>
                </aside>
            </div>
        </main>
    </div>
</template>
