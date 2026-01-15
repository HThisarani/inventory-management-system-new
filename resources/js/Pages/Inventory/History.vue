<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { computed } from 'vue'

const props = defineProps({
    item: Object,
    transactions: Array,
})

const totalAdded = computed(() => {
    return props.transactions
        .filter(t => t.type === 'add')
        .reduce((sum, t) => sum + parseFloat(t.quantity), 0)
})

const totalDeducted = computed(() => {
    return props.transactions
        .filter(t => t.type === 'deduct')
        .reduce((sum, t) => sum + parseFloat(t.quantity), 0)
})

function formatDate(date) {
    const d = new Date(date)
    const options = { 
        year: 'numeric', 
        month: 'short', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    }
    return d.toLocaleDateString('en-US', options)
}
</script>

<template>
    <Head :title="`${item.name} - History`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-semibold text-xl md:text-2xl text-gray-800 leading-tight">
                        {{ item.name }} - History
                    </h2>
                    <p class="text-sm text-gray-600 mt-1">
                        Current Stock: <span class="font-semibold text-gray-900">{{ item.quantity }} {{ item.unit }}</span>
                    </p>
                </div>
                <Link 
                    href="/inventory" 
                    class="hidden sm:inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-sm"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Inventory
                </Link>
            </div>
        </template>

        <div class="p-4 md:p-6">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <!-- Current Stock Card -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-5 border border-blue-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-blue-600 uppercase tracking-wide">Current Stock</p>
                            <p class="text-2xl font-bold text-blue-900 mt-1">{{ item.quantity }}</p>
                            <p class="text-xs text-blue-700 mt-1">{{ item.unit }}</p>
                        </div>
                        <div class="bg-blue-200 rounded-full p-3">
                            <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Added Card -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-5 border border-green-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-green-600 uppercase tracking-wide">Total Added</p>
                            <p class="text-2xl font-bold text-green-900 mt-1">{{ totalAdded.toFixed(2) }}</p>
                            <p class="text-xs text-green-700 mt-1">{{ item.unit }}</p>
                        </div>
                        <div class="bg-green-200 rounded-full p-3">
                            <svg class="w-6 h-6 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Deducted Card -->
                <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-lg p-5 border border-red-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-red-600 uppercase tracking-wide">Total Deducted</p>
                            <p class="text-2xl font-bold text-red-900 mt-1">{{ totalDeducted.toFixed(2) }}</p>
                            <p class="text-xs text-red-700 mt-1">{{ item.unit }}</p>
                        </div>
                        <div class="bg-red-200 rounded-full p-3">
                            <svg class="w-6 h-6 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaction History Title -->
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Transaction History</h3>
                <p class="text-sm text-gray-600">{{ transactions.length }} total transactions</p>
            </div>

            <!-- Empty State -->
            <div v-if="transactions.length === 0" class="bg-white rounded-lg border border-gray-200 p-12 text-center shadow-sm">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No transactions yet</h3>
                <p class="text-gray-600">Transaction history will appear here once you add or deduct items.</p>
            </div>

            <!-- Desktop Table View -->
            <div v-else class="hidden md:block overflow-hidden rounded-lg border border-gray-200 shadow-sm">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 border-b border-gray-200">Type</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 border-b border-gray-200">Quantity</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 border-b border-gray-200">Date & Time</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="t in transactions" :key="t.id" class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4">
                                <span 
                                    :class="[
                                        'inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold',
                                        t.type === 'add' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                                    ]"
                                >
                                    <svg v-if="t.type === 'add'" class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <svg v-else class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ t.type === 'add' ? 'Added' : 'Deducted' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-semibold text-gray-900">
                                    {{ t.type === 'add' ? '+' : '−' }}{{ t.quantity }} {{ item.unit }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ formatDate(t.created_at) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div v-if="transactions.length > 0" class="md:hidden space-y-3">
                <div 
                    v-for="t in transactions" 
                    :key="t.id" 
                    class="bg-white rounded-lg border border-gray-200 shadow-sm p-4"
                >
                    <div class="flex items-start justify-between mb-3">
                        <span 
                            :class="[
                                'inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold',
                                t.type === 'add' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                            ]"
                        >
                            <svg v-if="t.type === 'add'" class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
                            </svg>
                            <svg v-else class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ t.type === 'add' ? 'Added' : 'Deducted' }}
                        </span>
                        <span class="text-lg font-bold text-gray-900">
                            {{ t.type === 'add' ? '+' : '−' }}{{ t.quantity }} {{ item.unit }}
                        </span>
                    </div>
                    <div class="flex items-center text-xs text-gray-600">
                        <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ formatDate(t.created_at) }}
                    </div>
                </div>
            </div>

            <!-- Back Button for Mobile -->
            <Link 
                href="/inventory" 
                class="sm:hidden mt-6 w-full inline-flex items-center justify-center px-4 py-3 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-sm"
            >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Inventory
            </Link>
        </div>
    </AuthenticatedLayout>
</template>