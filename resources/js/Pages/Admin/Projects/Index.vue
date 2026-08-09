
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

    <div class="min-h-screen bg-gray-100 p-6">
        <div class="mx-auto max-w-7xl">
            <!-- Header -->
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Projects</h1>

                    <p class="mt-1 text-sm text-gray-600">
                        Manage your portfolio projects.
                    </p>
                </div>

                <Link
                    :href="route('admin.projects.create')"
                    class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-red-700"
                >
                    + New Project
                </Link>
            </div>

            <!-- Projects Table -->
            <div class="overflow-hidden rounded-xl bg-white shadow">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead
                            class="bg-gray-50 text-xs uppercase text-gray-600"
                        >
                            <tr>
                                <th class="px-6 py-4">Title</th>

                                <th class="px-6 py-4">Status</th>

                                <th class="px-6 py-4">Featured</th>

                                <th class="px-6 py-4">Created</th>

                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">
                            <tr
                                v-for="project in projects.data"
                                :key="project.id"
                                class="hover:bg-gray-50"
                            >
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-900">
                                        {{ project.title }}
                                    </div>

                                    <div class="text-xs text-gray-500">
                                        {{ project.slug }}
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <span
                                        class="rounded-full px-3 py-1 text-xs font-semibold"
                                        :class="{
                                            'bg-yellow-100 text-yellow-800':
                                                project.status === 'draft',

                                            'bg-green-100 text-green-800':
                                                project.status === 'published',

                                            'bg-gray-100 text-gray-800':
                                                project.status === 'archived',
                                        }"
                                    >
                                        {{ project.status }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <span
                                        v-if="project.featured"
                                        class="font-semibold text-red-600"
                                    >
                                        Yes
                                    </span>

                                    <span v-else class="text-gray-500">
                                        No
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    {{ project.created_at }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex justify-end gap-2">
                                        <Link
                                            :href="
                                                route(
                                                    'admin.projects.show',
                                                    project.id,
                                                )
                                            "
                                            class="rounded-lg border border-gray-300 px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-100"
                                        >
                                            View
                                        </Link>

                                        <Link
                                            :href="
                                                route(
                                                    'admin.projects.edit',
                                                    project.id,
                                                )
                                            "
                                            class="rounded-lg bg-blue-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-blue-700"
                                        >
                                            Edit
                                        </Link>

                                        <button
                                            type="button"
                                            @click="deleteProject(project)"
                                            class="rounded-lg bg-red-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-red-700"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Empty state -->
                            <tr v-if="projects.data.length === 0">
                                <td
                                    colspan="5"
                                    class="px-6 py-12 text-center text-gray-500"
                                >
                                    No projects found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div
                v-if="projects.links.length > 3"
                class="mt-6 flex flex-wrap gap-2"
            >
                <template v-for="link in projects.links" :key="link.label">
                    <Link
                        v-if="link.url"
                        :href="link.url"
                        class="rounded-lg border px-3 py-2 text-sm"
                        :class="{
                            'bg-red-600 text-white': link.active,

                            'bg-white text-gray-700 hover:bg-gray-100':
                                !link.active,
                        }"
                        v-html="link.label"
                    />

                    <span
                        v-else
                        class="rounded-lg border bg-gray-100 px-3 py-2 text-sm text-gray-400"
                        v-html="link.label"
                    />
                </template>
            </div>
        </div>
    </div>
</template>
