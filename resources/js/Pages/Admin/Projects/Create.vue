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

    <div class="min-h-screen bg-slate-50 p-6">
        <div class="mx-auto max-w-5xl">
            <div class="mb-6 overflow-hidden rounded-[32px] border border-slate-200 bg-white px-6 py-7 shadow-sm">
                <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.3em] text-red-600">New project</p>
                        <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-900">Create a project</h1>
                        <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-600">Add a new portfolio project and prepare it for publishing.</p>
                    </div>

                    <Link
                        :href="route('admin.projects.index')"
                        class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
                    >
                        ← Back
                    </Link>
                </div>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <section class="overflow-hidden rounded-[32px] bg-white p-6 shadow-sm ring-1 ring-slate-200">
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-slate-900">Project details</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-500">Enter the project title, description, and core settings.</p>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label for="title" class="mb-2 block text-sm font-medium text-slate-700">Project Title</label>
                            <input
                                id="title"
                                v-model="form.title"
                                type="text"
                                class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-red-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-100"
                                placeholder="My Laravel Portfolio"
                            />
                            <p v-if="form.errors.title" class="mt-2 text-sm text-red-600">{{ form.errors.title }}</p>
                        </div>

                        <div>
                            <label for="slug" class="mb-2 block text-sm font-medium text-slate-700">Slug</label>
                            <input
                                id="slug"
                                v-model="form.slug"
                                type="text"
                                class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-red-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-100"
                                placeholder="my-laravel-portfolio"
                            />
                            <p class="mt-2 text-xs text-slate-500">Leave blank to generate automatically from the title.</p>
                            <p v-if="form.errors.slug" class="mt-2 text-sm text-red-600">{{ form.errors.slug }}</p>
                        </div>

                        <div class="md:col-span-2">
                            <label for="short_description" class="mb-2 block text-sm font-medium text-slate-700">Short Description</label>
                            <textarea
                                id="short_description"
                                v-model="form.short_description"
                                rows="3"
                                maxlength="500"
                                class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-red-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-100"
                                placeholder="A short summary of the project..."
                            ></textarea>
                            <p v-if="form.errors.short_description" class="mt-2 text-sm text-red-600">{{ form.errors.short_description }}</p>
                        </div>

                        <div class="md:col-span-2">
                            <label for="description" class="mb-2 block text-sm font-medium text-slate-700">Description</label>
                            <textarea
                                id="description"
                                v-model="form.description"
                                rows="7"
                                class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-red-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-100"
                                placeholder="Describe the project in detail..."
                            ></textarea>
                            <p v-if="form.errors.description" class="mt-2 text-sm text-red-600">{{ form.errors.description }}</p>
                        </div>
                    </div>
                </section>

                <section class="overflow-hidden rounded-[32px] bg-white p-6 shadow-sm ring-1 ring-slate-200">
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-slate-900">Project settings</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-500">Finalize the links, publication status, and project order.</p>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label for="github_url" class="mb-2 block text-sm font-medium text-slate-700">GitHub URL</label>
                            <input
                                id="github_url"
                                v-model="form.github_url"
                                type="url"
                                class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-red-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-100"
                                placeholder="https://github.com/username/project"
                            />
                            <p v-if="form.errors.github_url" class="mt-2 text-sm text-red-600">{{ form.errors.github_url }}</p>
                        </div>

                        <div>
                            <label for="live_url" class="mb-2 block text-sm font-medium text-slate-700">Live Demo URL</label>
                            <input
                                id="live_url"
                                v-model="form.live_url"
                                type="url"
                                class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-red-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-100"
                                placeholder="https://example.com"
                            />
                            <p v-if="form.errors.live_url" class="mt-2 text-sm text-red-600">{{ form.errors.live_url }}</p>
                        </div>

                        <div>
                            <label for="status" class="mb-2 block text-sm font-medium text-slate-700">Status</label>
                            <select
                                id="status"
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
                            <label for="sort_order" class="mb-2 block text-sm font-medium text-slate-700">Sort Order</label>
                            <input
                                id="sort_order"
                                v-model="form.sort_order"
                                type="number"
                                min="0"
                                class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-red-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-100"
                            />
                            <p class="mt-2 text-xs text-slate-500">Lower numbers appear first.</p>
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
                        <p class="mt-3 text-sm text-slate-500">Featured projects can be highlighted on the portfolio home and in filtered listings.</p>
                    </div>
                </section>

                <div class="flex justify-end gap-3">
                    <Link
                        :href="route('admin.projects.index')"
                        class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
                    >
                        Cancel
                    </Link>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="inline-flex items-center justify-center rounded-2xl bg-red-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        {{ form.processing ? 'Saving...' : 'Create Project' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
