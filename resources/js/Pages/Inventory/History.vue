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
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ item.name }} - History
            </h2>
        </template>

        <div class="p-6">
            <div class="overflow-hidden rounded-lg border border-gray-200 shadow-sm">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 border-b border-gray-200">Type</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 border-b border-gray-200">Quantity</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 border-b border-gray-200">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="t in transactions" :key="t.id" class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4">
                                <span 
                                    :class="[
                                        'inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold',
                                        t.type === 'add' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                                    ]"
                                >
                                    {{ t.type === 'add' ? '+ Add' : '− Deduct' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ t.quantity }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ new Date(t.created_at).toLocaleString() }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>