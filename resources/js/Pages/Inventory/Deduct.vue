<script setup>
import { ref } from 'vue'
import { router, Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const props = defineProps({
    items: Array,
})

const rows = ref([
    { id: '', quantity: '' }
])

function addRow() {
    rows.value.push({ id: '', quantity: '' })
}

function removeRow(index) {
    rows.value.splice(index, 1)
}

function submit() {
    router.post('/inventory/deduct', { items: rows.value })
}
</script>

<template>
    <Head title="Deduct Items" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl md:text-2xl text-gray-800 leading-tight">
                Deduct Inventory Items
            </h2>
        </template>

        <div class="p-4 md:p-6">
            <!-- Desktop Table View -->
            <div class="hidden md:block overflow-hidden rounded-lg border border-gray-200 shadow-sm mb-6">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 border-b border-gray-200">Item</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 border-b border-gray-200">Quantity</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700 border-b border-gray-200">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="(row, index) in rows" :key="index" class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4">
                                <select 
                                    v-model="row.id" 
                                    class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white"
                                >
                                    <option value="">Select item</option>
                                    <option
                                        v-for="item in items"
                                        :key="item.id"
                                        :value="item.id"
                                    >
                                        {{ item.name }} ({{ item.quantity }})
                                    </option>
                                </select>
                            </td>
                            <td class="px-6 py-4">
                                <input
                                    type="number"
                                    step="0.01"
                                    v-model="row.quantity"
                                    placeholder="0.00"
                                    class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                />
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button
                                    v-if="rows.length > 1"
                                    @click="removeRow(index)"
                                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-sm"
                                >
                                    Remove
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="md:hidden space-y-4 mb-6">
                <div 
                    v-for="(row, index) in rows" 
                    :key="index" 
                    class="bg-white rounded-lg border border-gray-200 shadow-sm p-4"
                >
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-sm font-semibold text-gray-700">Deduction #{{ index + 1 }}</span>
                        <button
                            v-if="rows.length > 1"
                            @click="removeRow(index)"
                            class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-lg transition-all duration-200"
                        >
                            Remove
                        </button>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Item</label>
                            <select 
                                v-model="row.id" 
                                class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white text-sm"
                            >
                                <option value="">Select item</option>
                                <option
                                    v-for="item in items"
                                    :key="item.id"
                                    :value="item.id"
                                >
                                    {{ item.name }} ({{ item.quantity }})
                                </option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Quantity to Deduct</label>
                            <input
                                type="number"
                                step="0.01"
                                v-model="row.quantity"
                                placeholder="0.00"
                                class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-sm"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <button 
                    @click="addRow" 
                    class="px-5 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-all duration-200 text-sm sm:text-base"
                >
                    + Add Row
                </button>

                <button 
                    @click="submit" 
                    class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-sm hover:shadow-md text-sm sm:text-base"
                >
                    Deduct Items
                </button>
            </div>
        </div>
    </AuthenticatedLayout>
</template>