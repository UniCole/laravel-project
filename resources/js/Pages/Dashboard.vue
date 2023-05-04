<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ManageUsers from '@/Components/ManageUsers.vue';
</script>

<template>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                
                    <div class="p-6 text-gray-900"> Welcome! <br><br> You're logged in ☺</div>
                   
                </div>
            </div>
        </div>

        <ManageUsers v-if="$page.props.auth.user.role === 'admin'" />
        

    </AuthenticatedLayout>
</template>
