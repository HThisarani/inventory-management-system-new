<script setup>
import { ref } from 'vue'
import Dropdown from '@/Components/Dropdown.vue'
import DropdownLink from '@/Components/DropdownLink.vue'
import NavLink from '@/Components/NavLink.vue'
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue'
import { Link } from '@inertiajs/vue3'

const showingNavigationDropdown = ref(false)
</script>

<template>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50">
        <!-- NAVBAR -->
        <nav class="bg-white border-b border-gray-200 shadow-sm backdrop-blur-lg bg-white/95 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
                
                <!-- LEFT -->
                <div class="flex items-center space-x-8">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <span class="text-xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                            Inventory System
                        </span>
                    </div>

                    <div class="hidden md:flex items-center space-x-1">
                        <NavLink href="/inventory" class="px-4 py-2 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 font-medium">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                </svg>
                                <span>Inventory</span>
                            </div>
                        </NavLink>

                        <NavLink href="/inventory/add" class="px-4 py-2 rounded-lg text-gray-700 hover:bg-green-50 hover:text-green-600 transition-all duration-200 font-medium">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                <span>Add Items</span>
                            </div>
                        </NavLink>

                        <NavLink href="/inventory/deduct" class="px-4 py-2 rounded-lg text-gray-700 hover:bg-red-50 hover:text-red-600 transition-all duration-200 font-medium">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                </svg>
                                <span>Deduct Items</span>
                            </div>
                        </NavLink>
                    </div>
                </div>

                <!-- RIGHT -->
                <div class="flex items-center space-x-4">
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <button class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-100 transition-all duration-200">
                                <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-full flex items-center justify-center text-white font-semibold shadow-md">
                                    {{ $page.props.auth.user.name.charAt(0).toUpperCase() }}
                                </div>
                                <span class="text-sm font-semibold text-gray-700 hidden sm:block">
                                    {{ $page.props.auth.user.name }}
                                </span>
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors"
                    >
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path v-if="!showingNavigationDropdown" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- MOBILE MENU -->
            <div v-if="showingNavigationDropdown" class="md:hidden border-t border-gray-200 bg-white">
                <div class="px-4 py-3 space-y-1">
                    <ResponsiveNavLink href="/inventory" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-50 text-gray-700 hover:text-blue-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                        <span>Inventory</span>
                    </ResponsiveNavLink>

                    <ResponsiveNavLink href="/inventory/add" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-green-50 text-gray-700 hover:text-green-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Add Items</span>
                    </ResponsiveNavLink>

                    <ResponsiveNavLink href="/inventory/deduct" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-red-50 text-gray-700 hover:text-red-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                        </svg>
                        <span>Deduct Items</span>
                    </ResponsiveNavLink>
                </div>
            </div>
        </nav>

        <!-- PAGE HEADER -->
        <header class="bg-white shadow-sm border-b border-gray-200" v-if="$slots.header">
            <div class="max-w-7xl mx-auto py-8 px-6">
                <slot name="header" />
            </div>
        </header>

        <!-- PAGE CONTENT -->
        <main class="max-w-7xl mx-auto px-6 py-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 min-h-[calc(100vh-300px)]">
                <slot />
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-auto">
            <div class="max-w-7xl mx-auto px-6 py-6">
                <p class="text-center text-sm text-gray-500">
                    © 2026 Inventory Management System. All rights reserved.
                </p>
            </div>
        </footer>
    </div>
</template>