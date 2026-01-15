<script setup>
import { ref } from 'vue'
import { router, Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const items = ref([
    { name: '', unit: '', quantity: '' }
])

function addRow() {
    items.value.push({ name: '', unit: '', quantity: '' })
}

function removeRow(index) {
    items.value.splice(index, 1)
}

function submit() {
    router.post('/inventory/add', { items: items.value })
}
</script>

<template>
    <Head title="Add Items" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Add Inventory Items
            </h2>
        </template>

        <div class="p-6">
            <div class="overflow-hidden rounded-lg border border-gray-200 shadow-sm mb-6">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 border-b border-gray-200">Name</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 border-b border-gray-200">Unit</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 border-b border-gray-200">Quantity</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700 border-b border-gray-200">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="(item, index) in items" :key="index" class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4">
                                <input 
                                    v-model="item.name" 
                                    placeholder="Enter item name"
                                    class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                />
                            </td>
                            <td class="px-6 py-4">
                                <select 
                                    v-model="item.unit" 
                                    class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white"
                                >
                                    <option value="">Select unit</option>
                                    <option>Kg</option>
                                    <option>m</option>
                                    <option>cm</option>
                                    <option>Units</option>
                                </select>
                            </td>
                            <td class="px-6 py-4">
                                <input
                                    type="number"
                                    step="0.01"
                                    v-model="item.quantity"
                                    placeholder="0.00"
                                    class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                />
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button
                                    v-if="items.length > 1"
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

            <div class="flex items-center space-x-3">
                <button 
                    @click="addRow" 
                    class="px-5 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-all duration-200"
                >
                    + Add Row
                </button>

                <button 
                    @click="submit" 
                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-sm hover:shadow-md"
                >
                    Save Items
                </button>
            </div>
        </div>
    </AuthenticatedLayout>
</template>