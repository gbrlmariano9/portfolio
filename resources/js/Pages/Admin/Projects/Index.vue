
<script setup>
import { Head, Link, router } from "@inertiajs/vue3";

defineProps({
    projects: {
        type: Object,
        required: true,
    },
});

function deleteProject(project) {
    if (!confirm(`Are you sure you want to delete "${project.title}"?`)) {
        return;
    }

    router.delete(route('admin.projects.destroy', project.id));
}
</script>

<template>
    <Head title="Projects" />

    <div class="min-h-screen bg-slate-50 p-6">
        <div class="mx-auto max-w-7xl">
            <div class="mb-6 overflow-hidden rounded-[32px] border border-slate-200 bg-white px-6 py-7 shadow-sm">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.3em] text-red-600">Projects</p>
                        <h1 class="mt-3 text-3xl font-semibold tracking-tight text-slate-900">Manage your portfolio projects</h1>
                        <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-600">Keep your work organized, publish updates, and highlight your best projects.</p>
                    </div>

                    <Link
                        :href="route('admin.projects.create')"
                        class="inline-flex items-center justify-center rounded-2xl bg-red-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-700"
                    >
                        + New Project
                    </Link>
                </div>

                <div class="mt-6 grid gap-4 sm:grid-cols-3">
                    <div class="rounded-3xl bg-slate-50 p-4">
                        <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Total</p>
                        <p class="mt-3 text-3xl font-semibold text-slate-900">{{ projects.data.length }}</p>
                    </div>
                    <div class="rounded-3xl bg-slate-50 p-4">
                        <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Published</p>
                        <p class="mt-3 text-3xl font-semibold text-emerald-700">{{ projects.data.filter((project) => project.status === 'published').length }}</p>
                    </div>
                    <div class="rounded-3xl bg-slate-50 p-4">
                        <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Featured</p>
                        <p class="mt-3 text-3xl font-semibold text-red-700">{{ projects.data.filter((project) => project.featured).length }}</p>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden rounded-[32px] bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm">
                        <thead class="bg-slate-50 text-xs uppercase tracking-[0.2em] text-slate-500">
                            <tr>
                                <th class="px-6 py-4">Title</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Featured</th>
                                <th class="px-6 py-4">Created</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-200">
                            <tr
                                v-for="project in projects.data"
                                :key="project.id"
                                class="transition hover:bg-slate-50"
                            >
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-900">{{ project.title }}</div>
                                    <div class="text-xs text-slate-500">{{ project.slug }}</div>
                                </td>

                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex rounded-full px-3 py-1 text-xs font-semibold capitalize ring-1"
                                        :class="{
                                            'bg-yellow-100 text-yellow-700 ring-yellow-200': project.status === 'draft',
                                            'bg-emerald-100 text-emerald-700 ring-emerald-200': project.status === 'published',
                                            'bg-slate-100 text-slate-700 ring-slate-200': project.status === 'archived',
                                        }"
                                    >
                                        {{ project.status }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <span
                                        v-if="project.featured"
                                        class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700"
                                    >
                                        Featured
                                    </span>
                                    <span v-else class="text-sm text-slate-500">No</span>
                                </td>

                                <td class="px-6 py-4 text-slate-500">{{ project.created_at }}</td>

                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap justify-end gap-2">
                                        <Link
                                            :href="route('admin.projects.show', project.id)"
                                            class="rounded-full border border-slate-200 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-50"
                                        >
                                            View
                                        </Link>

                                        <Link
                                            :href="route('admin.projects.edit', project.id)"
                                            class="rounded-full bg-blue-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-blue-700"
                                        >
                                            Edit
                                        </Link>

                                        <button
                                            type="button"
                                            @click="deleteProject(project)"
                                            class="rounded-full bg-red-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-red-700"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr v-if="projects.data.length === 0">
                                <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                    No projects found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div v-if="projects.links.length > 3" class="mt-6 flex flex-wrap gap-2">
                <template v-for="link in projects.links" :key="link.label">
                    <Link
                        v-if="link.url"
                        :href="link.url"
                        class="rounded-2xl border px-3 py-2 text-sm"
                        :class="{
                            'bg-red-600 text-white border-red-600': link.active,
                            'bg-white text-slate-700 hover:bg-slate-50': !link.active,
                        }"
                        v-html="link.label"
                    />
                    <span
                        v-else
                        class="rounded-2xl border bg-slate-100 px-3 py-2 text-sm text-slate-400"
                        v-html="link.label"
                    />
                </template>
            </div>
        </div>
    </div>
</template>
