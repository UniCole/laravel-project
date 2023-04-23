<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Category List</h2>
            <a :href="route('categories.create')" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-500">Create</a>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <table class="table-auto w-full">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">#</th>
                                    <th class="px-4 py-2">Name</th>
                                    <th class="px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(category, index) in categories" :key="category.id">
                                    <td class="border px-4 py-2">{{ index + 1 }}</td>
                                    <td class="border px-4 py-2">{{ category.name }}</td>
                                    <td class="border px-4 py-2">
                                        <a :href="`/categories/${category.id}/edit`" class="text-blue-600 hover:text-blue-800 mr-2">Edit</a>
                                        <button @click="deleteCategory(category.id)" class="text-red-600 hover:text-red-800">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm, usePage } from '@inertiajs/vue3';

export default {
    components: {
        AuthenticatedLayout,
    },
    setup() {
        // const { categories } = usePage().props.value;
        const categories = usePage().props.categories;
        const form = useForm({});
        const deleteCategory = (categoryId) => {
            if(confirm('Are you sure you want to delete?')){
                form.delete(route('categories.destroy', categoryId))
                window.location.reload();//because inertia is bit broken, fix it later, maybe its my PC?
            }
        };

        return {
            categories,
            deleteCategory,
        };
    },
    head() {
        return {
            title: 'Category List',
        };
    },
};
</script>
