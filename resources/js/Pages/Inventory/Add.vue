<script setup>
import { ref } from 'vue'
import { router, Head, usePage } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const page = usePage()

const props = defineProps({
    existingItems: Array,
})

const items = ref([
    { name: '', unit: '', quantity: '' }
])

const showSuccess = ref(false)
const errors = ref([])

function addRow() {
    items.value.push({ name: '', unit: '', quantity: '' })
}

function removeRow(index) {
    items.value.splice(index, 1)
    errors.value = errors.value.filter(err => err.index !== index)
}

function validateForm() {
    errors.value = []
    let isValid = true

    items.value.forEach((item, index) => {
        const itemErrors = { index, name: '', unit: '', quantity: '' }

        if (!item.name || item.name.trim() === '') {
            itemErrors.name = 'Item name is required'
            isValid = false
        }

        if (!item.unit) {
            itemErrors.unit = 'Unit is required'
            isValid = false
        }

        if (!item.quantity || parseFloat(item.quantity) <= 0) {
            itemErrors.quantity = 'Quantity must be greater than 0'
            isValid = false
        }

        if (itemErrors.name || itemErrors.unit || itemErrors.quantity) {
            errors.value.push(itemErrors)
        }
    })

    return isValid
}

function getError(index, field) {
    const error = errors.value.find(err => err.index === index)
    return error ? error[field] : ''
}

function submit() {
    if (!validateForm()) return

    router.post('/inventory/add', { items: items.value }, {
        onSuccess: () => {
            showSuccess.value = true
            items.value = [{ name: '', unit: '', quantity: '' }]
            errors.value = []
            setTimeout(() => showSuccess.value = false, 4000)
        }
    })
}
</script>

<template>
    <Head title="Add Items" />

    <!-- 🔹 ITEM NAME SUGGESTIONS -->
    <datalist id="item-names">
        <option
            v-for="item in existingItems"
            :key="item.name"
            :value="item.name"
        />
    </datalist>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl md:text-2xl text-gray-800">
                Add Inventory Items
            </h2>
        </template>

        <div class="p-4 md:p-6">

            <!-- SUCCESS MESSAGE -->
            <div
                v-if="showSuccess || page.props.flash?.success"
                class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg"
            >
                Items added successfully
            </div>

            <!-- DESKTOP TABLE -->
            <div class="hidden md:block border rounded-lg shadow mb-6">
                <table class="w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 text-left">Name</th>
                            <th class="p-3 text-left">Unit</th>
                            <th class="p-3 text-left">Quantity</th>
                            <th class="p-3 text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(item, index) in items" :key="index">
                            <td class="p-3">
                                <input
                                    v-model="item.name"
                                    list="item-names"
                                    placeholder="Enter item name"
                                    class="w-full border rounded px-3 py-2"
                                />
                                <p class="text-red-500 text-xs">{{ getError(index,'name') }}</p>
                            </td>

                            <td class="p-3">
                                <select v-model="item.unit" class="w-full border rounded px-3 py-2">
                                    <option value="">Select</option>
                                    <option>Kg</option>
                                    <option>m</option>
                                    <option>cm</option>
                                    <option>Units</option>
                                </select>
                                <p class="text-red-500 text-xs">{{ getError(index,'unit') }}</p>
                            </td>

                            <td class="p-3">
                                <input
                                    type="number"
                                    step="0.01"
                                    v-model="item.quantity"
                                    class="w-full border rounded px-3 py-2"
                                />
                                <p class="text-red-500 text-xs">{{ getError(index,'quantity') }}</p>
                            </td>

                            <td class="p-3 text-center">
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
            </div>

            <!-- ACTION BUTTONS -->
            <div class="flex gap-3">
                <button @click="addRow" class="px-4 py-2 bg-gray-200 rounded">
                    + Add Row
                </button>

                <button @click="submit" class="px-6 py-2 bg-blue-600 text-white rounded">
                    Save Items
                </button>
            </div>

        </div>
    </AuthenticatedLayout>
</template>
