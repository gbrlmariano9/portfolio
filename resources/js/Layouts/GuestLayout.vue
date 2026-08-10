<template>
    <div
        class="flex min-h-screen flex-col items-center bg-gray-100 pt-6 sm:justify-center sm:pt-0 dark:bg-gray-900"
    >
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="mt-6 w-full overflow-hidden bg-white px-6 py-8 shadow-xl sm:max-w-md sm:rounded-3xl dark:bg-gray-800"
            >
                <slot />
            </div>
        </div>
    </div>
</template>
