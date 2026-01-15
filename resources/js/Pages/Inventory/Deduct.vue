<script setup>
import { ref, computed, onMounted } from 'vue'
import { router, Head, usePage } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const props = defineProps({
    items: Array,
    selectedItemId: [String, Number], // Add this prop to receive the pre-selected item
})

const page = usePage()
const successMessage = computed(() => page.props.flash?.success || page.props.success)
const errorMessage = computed(() => page.props.flash?.error || page.props.error)

const rows = ref([
    { id: '', quantity: '' }
])

// Pre-select the item if selectedItemId is provided
onMounted(() => {
    if (props.selectedItemId) {
        rows.value[0].id = props.selectedItemId.toString()
    }
})

function addRow() {
    rows.value.push({ id: '', quantity: '' })
}

function removeRow(index) {
    rows.value.splice(index, 1)
}

function submit() {
    router.post('/inventory/deduct', { items: rows.value }, {
        preserveScroll: true,
        onSuccess: () => {
            // Reset form after successful submission
            rows.value = [{ id: '', quantity: '' }]
        }
    })
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
            <!-- Success Message -->
            <div 
                v-if="successMessage" 
                class="mb-6 bg-green-50 border border-green-200 text-green-800 rounded-lg p-4 flex items-start gap-3"
            >
                <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="font-medium">{{ successMessage }}</p>
            </div>

            <!-- Error Message -->
            <div 
                v-if="errorMessage" 
                class="mb-6 bg-red-50 border border-red-200 text-red-800 rounded-lg p-4 flex items-start gap-3"
            >
                <svg class="w-5 h-5 text-red-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <p class="font-medium">{{ errorMessage }}</p>
            </div>

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
                                        {{ item.name }} ({{ item.quantity }} {{ item.unit }})
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