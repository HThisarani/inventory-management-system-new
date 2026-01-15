<script setup>
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const props = defineProps({
    item: Object,
    transactions: Array,
})
</script>

<template>
    <Head title="Item History" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ item.name }} - History
            </h2>
        </template>

        <div class="p-6">
            <table class="w-full border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2">Type</th>
                        <th class="border p-2">Quantity</th>
                        <th class="border p-2">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="t in transactions" :key="t.id">
                        <td class="border p-2">{{ t.type }}</td>
                        <td class="border p-2">{{ t.quantity }}</td>
                        <td class="border p-2">
                            {{ new Date(t.created_at).toLocaleString() }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AuthenticatedLayout>
</template>
