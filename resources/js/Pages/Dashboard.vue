<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <!-- HEADER -->
        <template #header>
            <h2 class="font-semibold text-2xl text-gray-800">
                Dashboard
            </h2>
        </template>

        <!-- CONTENT -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- TOTAL ITEMS -->
            <div class="bg-white rounded-xl shadow p-6 border-l-4 border-blue-500">
                <h3 class="text-sm text-gray-500">Total Items</h3>
                <p class="text-3xl font-bold text-blue-600 mt-2">
                    {{ $page.props.totalItems ?? '—' }}
                </p>
            </div>

            <!-- STOCK ADDED -->
            <div class="bg-white rounded-xl shadow p-6 border-l-4 border-green-500">
                <h3 class="text-sm text-gray-500">Stock Added</h3>
                <p class="text-3xl font-bold text-green-600 mt-2">
                    {{ $page.props.stockIn ?? '—' }}
                </p>
            </div>

            <!-- STOCK DEDUCTED -->
            <div class="bg-white rounded-xl shadow p-6 border-l-4 border-red-500">
                <h3 class="text-sm text-gray-500">Stock Deducted</h3>
                <p class="text-3xl font-bold text-red-600 mt-2">
                    {{ $page.props.stockOut ?? '—' }}
                </p>
            </div>
        </div>

        <!-- WELCOME CARD -->
        <div class="mt-8 bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800">
                Welcome to Inventory Management System
            </h3>
            <p class="text-gray-600 mt-2">
                Use the navigation bar above to manage inventory items, add stock,
                deduct stock, and view transaction history.
            </p>
        </div>
    </AuthenticatedLayout>
</template>
