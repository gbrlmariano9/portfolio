<script setup>
import { Head, Link } from "@inertiajs/vue3";

defineProps({
    featuredProjects: {
        type: Array,
        default: () => [],
    },
    projects: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <Head title="Portfolio" />

    <div class="min-h-screen bg-slate-950 text-white">
        <!-- ========================================
             Navigation
        ========================================= -->
        <header class="border-b border-white/10">
            <div
                class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5 lg:px-8"
            >
                <Link
                    :href="route('portfolio')"
                    class="text-xl font-bold tracking-tight"
                >
                    Gabriel<span class="text-red-500">.</span>
                </Link>

                <nav
                    class="hidden items-center gap-8 text-sm text-slate-300 md:flex"
                >
                    <a href="#about" class="transition hover:text-white">
                        About
                    </a>

                    <a href="#projects" class="transition hover:text-white">
                        Projects
                    </a>

                    <a href="#contact" class="transition hover:text-white">
                        Contact
                    </a>

                    <Link
                        :href="route('login')"
                        class="rounded-lg border border-white/10 px-4 py-2 transition hover:border-white/20 hover:bg-white/5"
                    >
                        Login
                    </Link>
                </nav>

                <Link
                    :href="route('login')"
                    class="rounded-lg border border-white/10 px-4 py-2 text-sm text-slate-300 md:hidden"
                >
                    Login
                </Link>
            </div>
        </header>

        <!-- ========================================
             Hero
        ========================================= -->
        <section class="relative overflow-hidden">
            <div
                class="absolute inset-0 bg-gradient-to-br from-red-500/10 via-transparent to-transparent"
            ></div>

            <div
                class="relative mx-auto grid max-w-7xl items-center gap-12 px-6 py-24 lg:grid-cols-2 lg:px-8 lg:py-32"
            >
                <div>
                    <p
                        class="mb-5 text-sm font-semibold uppercase tracking-[0.3em] text-red-500"
                    >
                        Web Developer & Data Analyst
                    </p>

                    <h1
                        class="max-w-3xl text-5xl font-bold tracking-tight sm:text-6xl lg:text-7xl"
                    >
                        Building digital
                        <span class="text-red-500">experiences</span>
                        that work.
                    </h1>

                    <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-400">
                        I build modern web applications, data-driven systems,
                        and practical digital solutions using technologies such
                        as Laravel, Vue.js, PHP, MySQL, and more.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-4">
                        <a
                            href="#projects"
                            class="rounded-lg bg-red-600 px-6 py-3 font-semibold transition hover:bg-red-500"
                        >
                            View My Projects
                        </a>

                        <a
                            href="#contact"
                            class="rounded-lg border border-white/10 px-6 py-3 font-semibold text-slate-300 transition hover:bg-white/5 hover:text-white"
                        >
                            Get In Touch
                        </a>
                    </div>
                </div>

                <!-- Hero visual -->
                <div class="hidden lg:block">
                    <div
                        class="relative mx-auto flex aspect-square max-w-md items-center justify-center rounded-3xl border border-white/10 bg-white/[0.03] shadow-2xl"
                    >
                        <div
                            class="absolute inset-8 rounded-2xl border border-red-500/20"
                        ></div>

                        <div class="text-center">
                            <div
                                class="mx-auto mb-6 flex h-24 w-24 items-center justify-center rounded-2xl bg-red-600/10 text-4xl font-bold text-red-500"
                            >
                                G
                            </div>

                            <p class="text-xl font-semibold">Gabriel Mariano</p>

                            <p class="mt-2 text-sm text-slate-400">
                                Laravel • Vue • Data
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================
             About
        ========================================= -->
        <section id="about" class="border-y border-white/10 bg-slate-900/50">
            <div class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
                <div class="max-w-3xl">
                    <p
                        class="text-sm font-semibold uppercase tracking-[0.25em] text-red-500"
                    >
                        About Me
                    </p>

                    <h2
                        class="mt-3 text-3xl font-bold tracking-tight sm:text-4xl"
                    >
                        Turning ideas into working systems.
                    </h2>

                    <p class="mt-6 text-lg leading-8 text-slate-400">
                        I enjoy creating applications that solve real-world
                        problems. My work combines backend development, frontend
                        interfaces, databases, and data analysis.
                    </p>
                </div>

                <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <div
                        class="rounded-2xl border border-white/10 bg-white/[0.03] p-6"
                    >
                        <p class="text-3xl font-bold text-red-500">Laravel</p>
                        <p class="mt-2 text-sm text-slate-400">
                            Backend & APIs
                        </p>
                    </div>

                    <div
                        class="rounded-2xl border border-white/10 bg-white/[0.03] p-6"
                    >
                        <p class="text-3xl font-bold text-red-500">Vue</p>
                        <p class="mt-2 text-sm text-slate-400">
                            Modern Interfaces
                        </p>
                    </div>

                    <div
                        class="rounded-2xl border border-white/10 bg-white/[0.03] p-6"
                    >
                        <p class="text-3xl font-bold text-red-500">MySQL</p>
                        <p class="mt-2 text-sm text-slate-400">
                            Data & Databases
                        </p>
                    </div>

                    <div
                        class="rounded-2xl border border-white/10 bg-white/[0.03] p-6"
                    >
                        <p class="text-3xl font-bold text-red-500">Data</p>
                        <p class="mt-2 text-sm text-slate-400">
                            Analysis & Insights
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================
             Featured Projects
        ========================================= -->
        <section id="projects" class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
            <div
                class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end"
            >
                <div>
                    <p
                        class="text-sm font-semibold uppercase tracking-[0.25em] text-red-500"
                    >
                        Selected Work
                    </p>

                    <h2
                        class="mt-3 text-3xl font-bold tracking-tight sm:text-4xl"
                    >
                        Featured Projects
                    </h2>

                    <p class="mt-4 max-w-2xl text-slate-400">
                        A selection of projects I've built and worked on.
                    </p>
                </div>
            </div>

            <!-- Featured projects -->
            <div
                v-if="featuredProjects.length"
                class="mt-10 grid gap-6 md:grid-cols-2"
            >
                <article
                    v-for="project in featuredProjects"
                    :key="project.id"
                    class="group overflow-hidden rounded-2xl border border-white/10 bg-white/[0.03] transition hover:-translate-y-1 hover:border-red-500/30"
                >
                    <div
                        class="flex aspect-video items-center justify-center bg-slate-900"
                    >
                        <img
                            v-if="project.images?.length"
                            :src="`/storage/${project.images[0].image_path}`"
                            :alt="project.images[0].alt_text || project.title"
                            class="h-full w-full object-cover"
                        />

                        <span
                            v-else
                            class="text-5xl font-bold text-white/10"
                        >
                            {{ project.title.charAt(0) }}
                        </span>
                    </div>

                    <div class="p-6">
                        <div class="flex items-center justify-between gap-4">
                            <h3 class="text-xl font-semibold">
                                {{ project.title }}
                            </h3>

                            <span
                                class="rounded-full bg-red-500/10 px-3 py-1 text-xs font-medium text-red-400"
                            >
                                Featured
                            </span>
                        </div>

                        <p class="mt-3 text-sm leading-6 text-slate-400">
                            {{ project.short_description }}
                        </p>

                        <Link
                            :href="route('portfolio.projects.show', project.id)"
                            class="mt-5 inline-flex items-center text-sm font-semibold text-red-500 transition group-hover:text-red-400"
                        >
                            View Project
                            <span class="ml-2">→</span>
                        </Link>
                    </div>
                </article>
            </div>

            <!-- No featured projects -->
            <div
                v-else
                class="mt-10 rounded-2xl border border-dashed border-white/10 p-10 text-center"
            >
                <p class="text-slate-400">No featured projects yet.</p>
            </div>

            <!-- ========================================
                 All Projects
            ========================================= -->
            <div class="mt-20">
                <h3 class="text-2xl font-bold">All Projects</h3>

                <div
                    v-if="projects.length"
                    class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3"
                >
                    <article
                        v-for="project in projects"
                        :key="project.id"
                        class="group rounded-2xl border border-white/10 bg-white/[0.03] p-6 transition hover:-translate-y-1 hover:border-white/20"
                    >
                        <div
                            class="mb-5 flex h-14 w-14 items-center justify-center rounded-xl bg-red-500/10 text-xl font-bold text-red-500"
                        >
                            {{ project.title.charAt(0) }}
                        </div>

                        <h3 class="text-lg font-semibold">
                            {{ project.title }}
                        </h3>

                        <p
                            class="mt-2 line-clamp-3 text-sm leading-6 text-slate-400"
                        >
                            {{ project.short_description }}
                        </p>

                        <Link
                            :href="route('portfolio.projects.show', project.id)"
                            class="mt-5 inline-flex text-sm font-semibold text-red-500"
                        >
                            View Project →
                        </Link>
                    </article>
                </div>

                <div
                    v-else
                    class="mt-8 rounded-2xl border border-dashed border-white/10 p-10 text-center"
                >
                    <p class="text-slate-400">No published projects yet.</p>
                </div>
            </div>
        </section>

        <!-- ========================================
             Contact
        ========================================= -->
        <section id="contact" class="border-t border-white/10 bg-slate-900/50">
            <div class="mx-auto max-w-4xl px-6 py-24 text-center lg:px-8">
                <p
                    class="text-sm font-semibold uppercase tracking-[0.25em] text-red-500"
                >
                    Let's Work Together
                </p>

                <h2 class="mt-4 text-4xl font-bold tracking-tight sm:text-5xl">
                    Have a project in mind?
                </h2>

                <p
                    class="mx-auto mt-6 max-w-2xl text-lg leading-8 text-slate-400"
                >
                    Let's build something useful, scalable, and beautiful.
                </p>

                <a
                    href="mailto:gbrlmariano9@gmail.com"
                    class="mt-8 inline-flex rounded-lg bg-red-600 px-7 py-3 font-semibold transition hover:bg-red-500"
                >
                    Get In Touch
                </a>
            </div>
        </section>

        <!-- ========================================
             Footer
        ========================================= -->
        <footer class="border-t border-white/10">
            <div
                class="mx-auto flex max-w-7xl flex-col gap-3 px-6 py-8 text-sm text-slate-500 sm:flex-row sm:items-center sm:justify-between lg:px-8"
            >
                <p>
                    © {{ new Date().getFullYear() }} Gabriel Mariano. All rights
                    reserved.
                </p>

                <p>Built with Laravel & Vue.</p>
            </div>
        </footer>
    </div>
</template>
