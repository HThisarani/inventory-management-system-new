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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Add Inventory Items
            </h2>
        </template>

        <div class="p-6">
            <table class="w-full border mb-4">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2">Name</th>
                        <th class="border p-2">Unit</th>
                        <th class="border p-2">Quantity</th>
                        <th class="border p-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in items" :key="index">
                        <td class="border p-2">
                            <input v-model="item.name" class="border p-1 w-full" />
                        </td>
                        <td class="border p-2">
                            <select v-model="item.unit" class="border p-1 w-full">
                                <option value="">Select</option>
                                <option>Kg</option>
                                <option>m</option>
                                <option>cm</option>
                                <option>Units</option>
                            </select>
                        </td>
                        <td class="border p-2">
                            <input
                                type="number"
                                step="0.01"
                                v-model="item.quantity"
                                class="border p-1 w-full"
                            />
                        </td>
                        <td class="border p-2 text-center">
                            <button
                                v-if="items.length > 1"
                                @click="removeRow(index)"
                                class="text-red-600"
                            >
                                Remove
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <button @click="addRow" class="bg-gray-200 px-4 py-2 mr-2">
                + Add Row
            </button>

            <button @click="submit" class="bg-blue-600 text-white px-4 py-2">
                Save Items
            </button>
        </div>
    </AuthenticatedLayout>
</template>
