<script setup>
import { ref, computed } from 'vue'
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
const successMessage = computed(() => page.props.flash?.success || page.props.success)

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
        preserveScroll: true,
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

    <!-- ITEM NAME SUGGESTIONS -->
    <datalist id="item-names">
        <option
            v-for="item in existingItems"
            :key="item.name"
            :value="item.name"
        />
    </datalist>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl md:text-2xl text-gray-800 leading-tight">
                Add Inventory Items
            </h2>
        </template>

        <div class="p-4 md:p-6">
            <!-- SUCCESS MESSAGE -->
            <div
                v-if="showSuccess || successMessage"
                class="mb-6 bg-green-50 border border-green-200 text-green-800 rounded-lg p-4 flex items-start gap-3"
            >
                <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="font-medium">{{ successMessage || 'Items added successfully' }}</p>
            </div>

            <!-- DESKTOP TABLE VIEW -->
            <div class="hidden md:block overflow-hidden rounded-lg border border-gray-200 shadow-sm mb-6">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 border-b border-gray-200">Item Name</th>
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
                                    list="item-names"
                                    placeholder="Enter item name"
                                    class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                    :class="{ 'border-red-500': getError(index, 'name') }"
                                />
                                <p v-if="getError(index, 'name')" class="text-red-600 text-xs mt-1">
                                    {{ getError(index, 'name') }}
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                <select 
                                    v-model="item.unit" 
                                    class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white"
                                    :class="{ 'border-red-500': getError(index, 'unit') }"
                                >
                                    <option value="">Select unit</option>
                                    <option>Kg</option>
                                    <option>m</option>
                                    <option>cm</option>
                                    <option>Units</option>
                                </select>
                                <p v-if="getError(index, 'unit')" class="text-red-600 text-xs mt-1">
                                    {{ getError(index, 'unit') }}
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                <input
                                    type="number"
                                    step="0.01"
                                    v-model="item.quantity"
                                    placeholder="0.00"
                                    class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                    :class="{ 'border-red-500': getError(index, 'quantity') }"
                                />
                                <p v-if="getError(index, 'quantity')" class="text-red-600 text-xs mt-1">
                                    {{ getError(index, 'quantity') }}
                                </p>
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

            <!-- MOBILE CARD VIEW -->
            <div class="md:hidden space-y-4 mb-6">
                <div 
                    v-for="(item, index) in items" 
                    :key="index" 
                    class="bg-white rounded-lg border border-gray-200 shadow-sm p-4"
                >
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-sm font-semibold text-gray-700">Item #{{ index + 1 }}</span>
                        <button
                            v-if="items.length > 1"
                            @click="removeRow(index)"
                            class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-lg transition-all duration-200"
                        >
                            Remove
                        </button>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Item Name</label>
                            <input
                                v-model="item.name"
                                list="item-names"
                                placeholder="Enter item name"
                                class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-sm"
                                :class="{ 'border-red-500': getError(index, 'name') }"
                            />
                            <p v-if="getError(index, 'name')" class="text-red-600 text-xs mt-1">
                                {{ getError(index, 'name') }}
                            </p>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Unit</label>
                            <select 
                                v-model="item.unit" 
                                class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white text-sm"
                                :class="{ 'border-red-500': getError(index, 'unit') }"
                            >
                                <option value="">Select unit</option>
                               <option>Kg</option>
                               <option>g</option>
                               <option>cm</option>
                               <option>m</option>
                               <option>L</option>
                               <option>ml</option>
                               <option>Units</option>
                            </select>
                            <p v-if="getError(index, 'unit')" class="text-red-600 text-xs mt-1">
                                {{ getError(index, 'unit') }}
                            </p>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Quantity</label>
                            <input
                                type="number"
                                step="0.01"
                                v-model="item.quantity"
                                placeholder="0.00"
                                class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-sm"
                                :class="{ 'border-red-500': getError(index, 'quantity') }"
                            />
                            <p v-if="getError(index, 'quantity')" class="text-red-600 text-xs mt-1">
                                {{ getError(index, 'quantity') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ACTION BUTTONS -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <button 
                    @click="addRow" 
                    class="px-5 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-all duration-200 text-sm sm:text-base"
                >
                    + Add Row
                </button>

                <button 
                    @click="submit" 
                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-sm hover:shadow-md text-sm sm:text-base"
                >
                    Save Items
                </button>
            </div>
        </div>
    </AuthenticatedLayout>
</template>