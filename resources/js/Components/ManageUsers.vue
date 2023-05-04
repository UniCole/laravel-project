<template>
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
                            <tr v-for="store in stores.data" :key="store.id">
                                <td class="border px-4 py-2">{{ store.id }}</td>
                                <td class="border px-4 py-2">{{ store.name }}</td>
                                <td class="border px-4 py-2">
                                    <a :href="`/${store.id}`" target="_blank"
                                        class="text-blue-600 hover:text-blue-800 mr-2">Visit Store</a>
                                    |
                                    <a :href="`/impersonate/${store.id}`"
                                        class="text-blue-600 hover:text-blue-800 mr-2">Login As</a>
                                    |
                                    <button @click="deleteStore(store.id)"
                                        class="text-red-600 hover:text-red-800">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                

            <div class="flex justify-center my-8">
                    <Link :href="`?page=${stores.current_page - 1}`" class="mr-2" method="get" as="button" type="button"
                        :disabled="stores.current_page == 1">
                    Previous
                    </Link>

                    <Link :href="`?page=${stores.current_page + 1}`" class="ml-2" method="get" as="button" type="button"
                        :disabled="stores.current_page === stores.last_page">
                    Next
                    </Link>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm, usePage, Link } from '@inertiajs/vue3';

export default {
    components: {
        AuthenticatedLayout,
        Link,
    },
    setup() {
        const stores = usePage().props?.stores;
        console.log(stores);
        const form = useForm({});
        const deleteStore = (storeId) => {
            if (confirm('Are you sure you want to delete?')) {
                form.delete(route('store.destroy', storeId))
                window.location.reload();//because inertia is bit broken, fix it later, maybe its my PC?
            }
        };

        return {
            stores,
            deleteStore
        };
    },
    head() {
        return {
            title: 'Category List',
        };
    },
};
</script>
