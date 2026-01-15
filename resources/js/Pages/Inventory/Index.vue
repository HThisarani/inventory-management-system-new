<script setup>
import { ref } from 'vue'
import { router, Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const props = defineProps({
    items: Array,
    filters: Object,
})

const search = ref(props.filters?.search || '')

function searchItems() {
    router.get('/inventory', { search: search.value }, { preserveState: true })
}
</script>

<template>
    <Head title="Inventory" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl sm:text-2xl text-gray-800 leading-tight">
                Inventory
            </h2>
        </template>

        <div class="py-4 sm:py-6 px-4">

            <!-- Search -->
            <input
                v-model="search"
                @input="searchItems"
                placeholder="Search item..."
                class="border border-gray-300 rounded-lg px-4 py-3 mb-4 sm:mb-6 w-full
                       focus:ring-2 focus:ring-blue-500 focus:border-transparent
                       transition-all duration-200 shadow-sm"
            />

            <!-- Desktop Table View (hidden on mobile) -->
            <div class="hidden md:block overflow-hidden rounded-lg border border-gray-200 shadow-sm">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 border-b">
                                Name
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 border-b">
                                Unit
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 border-b">
                                Quantity
                            </th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700 border-b">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr
                            v-for="item in items"
                            :key="item.id"
                            class="hover:bg-blue-50 transition-colors duration-150"
                        >
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                {{ item.name }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ item.unit }}
                            </td>

                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                {{ item.quantity }}
                            </td>

                            <td class="px-6 py-4 text-center space-x-2">
                                <!-- View History -->
                                <a
                                    :href="`/inventory/${item.id}/history`"
                                    class="inline-block px-4 py-2 bg-blue-600 hover:bg-blue-700
                                           text-white text-sm font-medium rounded-lg
                                           transition-all duration-200 shadow-sm"
                                >
                                    View
                                </a>

                                <!-- Deduct -->
                                <a
                                    :href="`/inventory/deduct?item=${item.id}`"
                                    class="inline-block px-4 py-2 bg-red-600 hover:bg-red-700
                                           text-white text-sm font-medium rounded-lg
                                           transition-all duration-200 shadow-sm"
                                >
                                    Deduct
                                </a>
                            </td>
                        </tr>

                        <!-- Empty State -->
                        <tr v-if="items.length === 0">
                            <td colspan="4" class="text-center py-12 text-gray-500">
                                No items found
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View (visible only on mobile) -->
            <div class="md:hidden space-y-4">
                <div
                    v-for="item in items"
                    :key="item.id"
                    class="bg-white rounded-lg border border-gray-200 shadow-sm p-4"
                >
                    <div class="space-y-3">
                        <!-- Item Name -->
                        <div>
                            <div class="text-xs text-gray-500 uppercase tracking-wide mb-1">Name</div>
                            <div class="text-base font-semibold text-gray-900">{{ item.name }}</div>
                        </div>

                        <!-- Unit and Quantity -->
                        <div class="flex gap-4">
                            <div class="flex-1">
                                <div class="text-xs text-gray-500 uppercase tracking-wide mb-1">Unit</div>
                                <div class="text-sm text-gray-700">{{ item.unit }}</div>
                            </div>
                            <div class="flex-1">
                                <div class="text-xs text-gray-500 uppercase tracking-wide mb-1">Quantity</div>
                                <div class="text-sm font-semibold text-gray-900">{{ item.quantity }}</div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-2 pt-2">
                            <a
                                :href="`/inventory/${item.id}/history`"
                                class="flex-1 text-center px-4 py-2 bg-blue-600 hover:bg-blue-700
                                       text-white text-sm font-medium rounded-lg
                                       transition-all duration-200 shadow-sm"
                            >
                                View
                            </a>
                            <a
                                :href="`/inventory/deduct?item=${item.id}`"
                                class="flex-1 text-center px-4 py-2 bg-red-600 hover:bg-red-700
                                       text-white text-sm font-medium rounded-lg
                                       transition-all duration-200 shadow-sm"
                            >
                                Deduct
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Empty State Mobile -->
                <div v-if="items.length === 0" class="text-center py-12 text-gray-500">
                    No items found
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>