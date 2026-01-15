<script setup>
</script>

<template>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100">
        <!-- APP TITLE (instead of Laravel logo) -->
        <div class="mb-6 text-center">
            <h1 class="text-2xl font-bold text-gray-800">
                Inventory Management System
            </h1>
            <p class="text-sm text-gray-500">
                Inventory control and tracking
            </p>
        </div>

        <!-- AUTH CARD -->
        <div class="w-full sm:max-w-md px-6 py-6 bg-white shadow-md rounded-lg">
            <slot />
        </div>
    </div>
</template>
