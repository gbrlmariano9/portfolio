<script setup>
import { Head, Link } from "@inertiajs/vue3";

const props = defineProps({
    project: {
        type: Object,
        required: true,
    },
});

const project = props.project;

const formatDate = (date) => {
    if (!date) return "";

    return new Date(date).toLocaleDateString("en-US", {
        year: "numeric",
        month: "long",
        day: "numeric",
    });
};
</script>

<template>
    <Head :title="project.title" />

    <div
        class="min-h-screen bg-slate-950 text-white selection:bg-red-500 selection:text-white"
    >
        <!-- =========================================================
             Navigation
        ========================================================== -->
        <header
            class="sticky top-0 z-50 border-b border-white/10 bg-slate-950/90 backdrop-blur-xl"
        >
            <div
                class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4 sm:px-6 lg:px-8"
            >
                <!-- Logo / Portfolio -->
                <Link
                    :href="route('portfolio')"
                    class="group flex items-center gap-3"
                >
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-500 font-bold shadow-lg shadow-red-500/20 transition group-hover:bg-red-400"
                    >
                        P
                    </div>

                    <div class="hidden sm:block">
                        <p class="text-sm font-semibold text-white">
                            My Portfolio
                        </p>

                        <p class="text-xs text-slate-400">
                            Developer & Creator
                        </p>
                    </div>
                </Link>

                <!-- Back -->
                <Link
                    :href="route('portfolio')"
                    class="inline-flex items-center gap-2 rounded-lg border border-white/10 bg-white/5 px-4 py-2 text-sm font-medium text-slate-200 transition hover:border-white/20 hover:bg-white/10 hover:text-white"
                >
                    <svg
                        class="h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 19l-7-7 7-7"
                        />
                    </svg>

                    <span>Back to Projects</span>
                </Link>
            </div>
        </header>

        <!-- =========================================================
             Main
        ========================================================== -->
        <main>
            <!-- =====================================================
                 Hero
            ====================================================== -->
            <section class="relative overflow-hidden">
                <!-- Background decoration -->
                <div
                    class="pointer-events-none absolute -left-40 top-20 h-96 w-96 rounded-full bg-red-500/10 blur-3xl"
                ></div>

                <div
                    class="pointer-events-none absolute -right-40 top-0 h-96 w-96 rounded-full bg-blue-500/10 blur-3xl"
                ></div>

                <div
                    class="relative mx-auto max-w-7xl px-5 pb-16 pt-12 sm:px-6 sm:pt-16 lg:px-8 lg:pb-24 lg:pt-20"
                >
                    <!-- Breadcrumb -->
                    <div
                        class="mb-8 flex flex-wrap items-center gap-2 text-sm text-slate-400"
                    >
                        <Link
                            :href="route('portfolio')"
                            class="transition hover:text-white"
                        >
                            Portfolio
                        </Link>

                        <svg
                            class="h-4 w-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 5l7 7-7 7"
                            />
                        </svg>

                        <span class="text-slate-500">
                            {{ project.title }}
                        </span>
                    </div>

                    <!-- Hero Image -->
                    <div
                        v-if="project.images && project.images.length"
                        class="group relative mb-12 overflow-hidden rounded-2xl border border-white/10 bg-slate-900 shadow-2xl shadow-black/30"
                    >
                        <div
                            class="absolute inset-0 z-10 bg-gradient-to-t from-black/50 via-transparent to-transparent"
                        ></div>

                        <img
                            :src="`/storage/${(project.images.find(image => image.is_primary) || project.images[0]).image_path}`"
                            :alt="
                                (project.images.find(image => image.is_primary) || project.images[0]).alt_text ||
                                project.title
                            "
                            class="aspect-[16/8] w-full object-cover transition duration-700 group-hover:scale-[1.02]"
                        />
                    </div>

                    <!-- Image Placeholder -->
                    <div
                        v-else
                        class="relative mb-12 flex aspect-[16/7] items-center justify-center overflow-hidden rounded-2xl border border-white/10 bg-gradient-to-br from-slate-900 via-slate-900 to-slate-800 shadow-2xl shadow-black/30"
                    >
                        <div
                            class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(239,68,68,0.12),transparent_45%)]"
                        ></div>

                        <div class="relative text-center">
                            <div
                                class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl border border-white/10 bg-white/5"
                            >
                                <svg
                                    class="h-8 w-8 text-slate-500"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-9h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                    />
                                </svg>
                            </div>

                            <p class="text-sm text-slate-500">
                                Project Preview
                            </p>
                        </div>
                    </div>

                    <!-- Hero Content -->
                    <div class="grid gap-10 lg:grid-cols-[1fr_320px] lg:gap-16">
                        <!-- Main information -->
                        <div>
                            <!-- Featured -->
                            <div
                                v-if="project.featured"
                                class="mb-5 inline-flex items-center gap-2 rounded-full border border-red-500/20 bg-red-500/10 px-3 py-1.5 text-xs font-semibold uppercase tracking-wider text-red-400"
                            >
                                <span
                                    class="h-1.5 w-1.5 rounded-full bg-red-400"
                                ></span>

                                Featured Project
                            </div>

                            <p
                                v-else
                                class="mb-4 text-sm font-semibold uppercase tracking-[0.2em] text-red-400"
                            >
                                Project Showcase
                            </p>

                            <h1
                                class="max-w-4xl text-4xl font-bold tracking-tight text-white sm:text-5xl lg:text-6xl"
                            >
                                {{ project.title }}
                            </h1>

                            <p
                                v-if="project.short_description"
                                class="mt-6 max-w-3xl text-lg leading-8 text-slate-400 sm:text-xl"
                            >
                                {{ project.short_description }}
                            </p>

                            <!-- Buttons -->
                            <div class="mt-8 flex flex-wrap gap-3">
                                <a
                                    v-if="project.live_url"
                                    :href="project.live_url"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center gap-2 rounded-xl bg-red-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-red-500/20 transition hover:-translate-y-0.5 hover:bg-red-400"
                                >
                                    <svg
                                        class="h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"
                                        />
                                    </svg>

                                    Live Demo
                                </a>

                                <a
                                    v-if="project.github_url"
                                    :href="project.github_url"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center gap-2 rounded-xl border border-white/10 bg-white/5 px-5 py-3 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:border-white/20 hover:bg-white/10"
                                >
                                    <svg
                                        class="h-5 w-5"
                                        fill="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            d="M12 .5C5.65.5.5 5.65.5 12c0 5.09 3.3 9.41 7.88 10.94.58.11.79-.25.79-.56v-2.17c-3.2.7-3.88-1.36-3.88-1.36-.53-1.33-1.28-1.68-1.28-1.68-1.04-.71.08-.7.08-.7 1.15.08 1.76 1.18 1.76 1.18 1.02 1.75 2.68 1.25 3.33.96.1-.74.4-1.25.73-1.54-2.55-.29-5.23-1.28-5.23-5.7 0-1.26.45-2.29 1.18-3.1-.12-.29-.51-1.47.11-3.06 0 0 .96-.31 3.15 1.18a10.93 10.93 0 015.74 0c2.19-1.49 3.15-1.18 3.15-1.18.62 1.59.23 2.77.11 3.06.73.81 1.18 1.84 1.18 3.1 0 4.43-2.69 5.41-5.25 5.69.41.36.78 1.08.78 2.18v3.23c0 .31.21.67.8.56A10.51 10.51 0 0019.5 12C19.5 5.65 14.35.5 8 .5z"
                                        />
                                    </svg>

                                    View on GitHub
                                </a>
                            </div>
                        </div>

                        <!-- Project Meta -->
                        <aside
                            class="rounded-2xl border border-white/10 bg-white/[0.03] p-6"
                        >
                            <h2
                                class="text-sm font-semibold uppercase tracking-wider text-slate-400"
                            >
                                Project Details
                            </h2>

                            <div class="mt-6 space-y-5">
                                <!-- Status -->
                                <div
                                    class="flex items-center justify-between gap-4"
                                >
                                    <span class="text-sm text-slate-500">
                                        Status
                                    </span>

                                    <span
                                        class="inline-flex rounded-full px-3 py-1 text-xs font-semibold capitalize"
                                        :class="{
                                            'bg-emerald-500/10 text-emerald-400':
                                                project.status === 'published',
                                            'bg-yellow-500/10 text-yellow-400':
                                                project.status === 'draft',
                                            'bg-slate-500/10 text-slate-400':
                                                project.status === 'archived',
                                        }"
                                    >
                                        {{ project.status }}
                                    </span>
                                </div>

                                <!-- Featured -->
                                <div
                                    class="flex items-center justify-between gap-4 border-t border-white/10 pt-5"
                                >
                                    <span class="text-sm text-slate-500">
                                        Featured
                                    </span>

                                    <span
                                        class="text-sm font-medium text-white"
                                    >
                                        {{ project.featured ? "Yes" : "No" }}
                                    </span>
                                </div>

                                <!-- Created -->
                                <div
                                    v-if="project.created_at"
                                    class="border-t border-white/10 pt-5"
                                >
                                    <span class="block text-sm text-slate-500">
                                        Created
                                    </span>

                                    <span
                                        class="mt-1 block text-sm font-medium text-white"
                                    >
                                        {{ formatDate(project.created_at) }}
                                    </span>
                                </div>

                                <!-- Updated -->
                                <div
                                    v-if="project.updated_at"
                                    class="border-t border-white/10 pt-5"
                                >
                                    <span class="block text-sm text-slate-500">
                                        Last Updated
                                    </span>

                                    <span
                                        class="mt-1 block text-sm font-medium text-white"
                                    >
                                        {{ formatDate(project.updated_at) }}
                                    </span>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>
            </section>

            <!-- =====================================================
                 Project Description
            ====================================================== -->
            <section
                v-if="project.description"
                class="border-t border-white/10 bg-slate-900/40"
            >
                <div class="mx-auto max-w-4xl px-5 py-16 sm:px-6 lg:py-24">
                    <div class="mb-8">
                        <p
                            class="text-sm font-semibold uppercase tracking-[0.2em] text-red-400"
                        >
                            About the project
                        </p>

                        <h2
                            class="mt-3 text-3xl font-bold tracking-tight text-white sm:text-4xl"
                        >
                            Project Overview
                        </h2>
                    </div>

                    <div
                        class="prose prose-invert max-w-none text-base leading-8 text-slate-400 sm:text-lg"
                    >
                        <p class="whitespace-pre-line">
                            {{ project.description }}
                        </p>
                    </div>
                </div>
            </section>

            <!-- =====================================================
                 Technologies
            ====================================================== -->
            <section
                v-if="project.technologies && project.technologies.length"
                class="border-t border-white/10"
            >
                <div
                    class="mx-auto max-w-7xl px-5 py-16 sm:px-6 lg:px-8 lg:py-24"
                >
                    <div class="max-w-2xl">
                        <p
                            class="text-sm font-semibold uppercase tracking-[0.2em] text-red-400"
                        >
                            Technology
                        </p>

                        <h2
                            class="mt-3 text-3xl font-bold tracking-tight text-white"
                        >
                            Built With
                        </h2>

                        <p class="mt-4 text-slate-400">
                            Technologies and tools used to build this project.
                        </p>
                    </div>

                    <div class="mt-8 flex flex-wrap gap-3">
                        <div
                            v-for="technology in project.technologies"
                            :key="technology.id"
                            class="inline-flex items-center gap-3 rounded-xl border border-white/10 bg-white/[0.03] px-4 py-3 transition hover:border-white/20 hover:bg-white/[0.06]"
                        >
                            <div
                                class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-500/10 text-xs font-bold text-red-400"
                            >
                                {{ technology.name?.charAt(0)?.toUpperCase() }}
                            </div>

                            <span class="text-sm font-medium text-slate-200">
                                {{ technology.name }}
                            </span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- =====================================================
                 Project Gallery
            ====================================================== -->
            <section
                v-if="project.images && project.images.length"
                class="border-t border-white/10 bg-slate-900/40"
            >
                <div
                    class="mx-auto max-w-7xl px-5 py-16 sm:px-6 lg:px-8 lg:py-24"
                >
                    <div class="max-w-2xl">
                        <p
                            class="text-sm font-semibold uppercase tracking-[0.2em] text-red-400"
                        >
                            Gallery
                        </p>

                        <h2
                            class="mt-3 text-3xl font-bold tracking-tight text-white"
                        >
                            Project Screenshots
                        </h2>
                    </div>

                    <div class="mt-10 grid gap-6 md:grid-cols-2">
                        <div
                            v-for="image in project.images"
                            :key="image.id"
                            class="group overflow-hidden rounded-2xl border border-white/10 bg-slate-900"
                        >
                            <img
                                :src="`/storage/${image.image_path}`"
                                :alt="image.alt_text || project.title"
                                class="aspect-video w-full object-cover transition duration-500 group-hover:scale-[1.02]"
                            />

                            <div
                                v-if="image.alt_text"
                                class="border-t border-white/10 px-5 py-4"
                            >
                                <p class="text-sm text-slate-400">
                                    {{ image.alt_text }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- =====================================================
                 CTA
            ====================================================== -->
            <section class="border-t border-white/10">
                <div
                    class="mx-auto max-w-4xl px-5 py-16 text-center sm:px-6 lg:py-24"
                >
                    <div
                        class="rounded-3xl border border-white/10 bg-gradient-to-br from-white/[0.06] to-white/[0.02] p-8 sm:p-12"
                    >
                        <p
                            class="text-sm font-semibold uppercase tracking-[0.2em] text-red-400"
                        >
                            Explore more
                        </p>

                        <h2
                            class="mt-4 text-3xl font-bold tracking-tight text-white sm:text-4xl"
                        >
                            Interested in this project?
                        </h2>

                        <p class="mx-auto mt-4 max-w-xl text-slate-400">
                            Take a look at more projects and explore other work
                            from the portfolio.
                        </p>

                        <div class="mt-8">
                            <Link
                                :href="route('portfolio')"
                                class="inline-flex items-center gap-2 rounded-xl bg-white px-6 py-3 text-sm font-semibold text-slate-950 transition hover:-translate-y-0.5 hover:bg-slate-200"
                            >
                                View All Projects

                                <svg
                                    class="h-4 w-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3"
                                    />
                                </svg>
                            </Link>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- =========================================================
             Footer
        ========================================================== -->
        <footer class="border-t border-white/10">
            <div
                class="mx-auto flex max-w-7xl flex-col gap-4 px-5 py-8 text-sm text-slate-500 sm:px-6 md:flex-row md:items-center md:justify-between lg:px-8"
            >
                <p>
                    © {{ new Date().getFullYear() }} My Portfolio. All rights
                    reserved.
                </p>

                <Link
                    :href="route('portfolio')"
                    class="transition hover:text-white"
                >
                    Back to Portfolio
                </Link>
            </div>
        </footer>
    </div>
</template>
