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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Deduct Inventory Items
            </h2>
        </template>

        <div class="p-6">
            <table class="w-full border mb-4">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2">Item</th>
                        <th class="border p-2">Quantity</th>
                        <th class="border p-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index) in rows" :key="index">
                        <td class="border p-2">
                            <select v-model="row.id" class="border p-1 w-full">
                                <option value="">Select</option>
                                <option
                                    v-for="item in items"
                                    :key="item.id"
                                    :value="item.id"
                                >
                                    {{ item.name }} ({{ item.quantity }})
                                </option>
                            </select>
                        </td>
                        <td class="border p-2">
                            <input
                                type="number"
                                step="0.01"
                                v-model="row.quantity"
                                class="border p-1 w-full"
                            />
                        </td>
                        <td class="border p-2 text-center">
                            <button
                                v-if="rows.length > 1"
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

            <button @click="submit" class="bg-red-600 text-white px-4 py-2">
                Deduct Items
            </button>
        </div>
    </AuthenticatedLayout>
</template>
