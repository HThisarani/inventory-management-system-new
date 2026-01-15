<script setup>
import { ref, computed } from 'vue'
import Dropdown from '@/Components/Dropdown.vue'
import DropdownLink from '@/Components/DropdownLink.vue'
import NavLink from '@/Components/NavLink.vue'
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue'
import { Link, usePage } from '@inertiajs/vue3'

const showingNavigationDropdown = ref(false)
const page = usePage()

// Helper function to check if route is active
const isActive = (path) => {
    return page.url.startsWith(path)
}
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <!-- NAVBAR -->
        <nav class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 shadow-lg sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-6 h-16 flex justify-between items-center">
                
                <!-- LEFT -->
                <div class="flex items-center space-x-8">
                    <span class="text-xl font-bold text-white">
                        Inventory System
                    </span>

                    <div class="hidden md:flex items-center space-x-2">
                        <NavLink 
                            href="/inventory" 
                            :class="isActive('/inventory') && !isActive('/inventory/add') && !isActive('/inventory/deduct')
                                ? 'px-4 py-2 rounded-lg text-blue-700 bg-white font-semibold shadow-md flex items-center justify-center' 
                                : 'px-4 py-2 rounded-lg text-white hover:bg-white/20 transition-all duration-200 font-medium flex items-center justify-center'"
                        >
                            Inventory
                        </NavLink>

                        <NavLink 
                            href="/inventory/add" 
                            :class="isActive('/inventory/add')
                                ? 'px-4 py-2 rounded-lg text-blue-700 bg-white font-semibold shadow-md flex items-center justify-center' 
                                : 'px-4 py-2 rounded-lg text-white hover:bg-white/20 transition-all duration-200 font-medium flex items-center justify-center'"
                        >
                            Add Items
                        </NavLink>

                        <NavLink 
                            href="/inventory/deduct" 
                            :class="isActive('/inventory/deduct')
                                ? 'px-4 py-2 rounded-lg text-blue-700 bg-white font-semibold shadow-md flex items-center justify-center' 
                                : 'px-4 py-2 rounded-lg text-white hover:bg-white/20 transition-all duration-200 font-medium flex items-center justify-center'"
                        >
                            Deduct Items
                        </NavLink>
                    </div>
                </div>

                <!-- RIGHT -->
                <div class="flex items-center space-x-4">
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <button class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-white/20 transition-all duration-200">
                                <span class="text-sm font-semibold text-white">
                                    {{ $page.props.auth.user.name }}
                                </span>
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                        </template>

                        <template #content>
                            <DropdownLink :href="route('profile.edit')">
                                Profile
                            </DropdownLink>

                            <DropdownLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                Log Out
                            </DropdownLink>
                        </template>
                    </Dropdown>

                    <!-- Mobile Menu Button -->
                    <button 
                        @click="showingNavigationDropdown = !showingNavigationDropdown"
                        class="md:hidden p-2 rounded-lg hover:bg-white/20 transition-colors"
                    >
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path v-if="!showingNavigationDropdown" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- MOBILE MENU -->
            <div v-if="showingNavigationDropdown" class="md:hidden border-t border-white/20 bg-blue-700">
                <div class="px-4 py-3 space-y-1">
                    <ResponsiveNavLink 
                        href="/inventory" 
                        :class="isActive('/inventory') && !isActive('/inventory/add') && !isActive('/inventory/deduct')
                            ? 'block px-4 py-3 rounded-lg text-blue-700 bg-white font-semibold flex items-center justify-center' 
                            : 'block px-4 py-3 rounded-lg text-white hover:bg-white/20 flex items-center justify-center'"
                    >
                        Inventory
                    </ResponsiveNavLink>

                    <ResponsiveNavLink 
                        href="/inventory/add" 
                        :class="isActive('/inventory/add')
                            ? 'block px-4 py-3 rounded-lg text-blue-700 bg-white font-semibold flex items-center justify-center' 
                            : 'block px-4 py-3 rounded-lg text-white hover:bg-white/20 flex items-center justify-center'"
                    >
                        Add Items
                    </ResponsiveNavLink>

                    <ResponsiveNavLink 
                        href="/inventory/deduct" 
                        :class="isActive('/inventory/deduct')
                            ? 'block px-4 py-3 rounded-lg text-blue-700 bg-white font-semibold flex items-center justify-center' 
                            : 'block px-4 py-3 rounded-lg text-white hover:bg-white/20 flex items-center justify-center'"
                    >
                        Deduct Items
                    </ResponsiveNavLink>
                </div>
            </div>
        </nav>

        <!-- PAGE HEADER -->
        <header class="bg-white shadow-sm" v-if="$slots.header">
            <div class="max-w-7xl mx-auto py-6 px-6">
                <slot name="header" />
            </div>
        </header>

        <!-- PAGE CONTENT -->
        <main class="max-w-7xl mx-auto px-6 py-8">
            <slot />
        </main>
    </div>
</template>