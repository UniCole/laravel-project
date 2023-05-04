<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Product List</h2>
            <a :href="route('products.create')"
                class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-500">Create</a>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="name">
                        Category
                    </label>

                    <select @change="selectCategory" v-model="selectedCategory"
                        class="block appearance-none bg-gray-200 border border-gray-200 text-gray-700 py-2 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                        <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
                    </select>
                    <p v-if="form?.errors?.image" class="text-red-500 text-xs italic">{{ form.errors.name[0] }}
                    </p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <table class="table-auto w-full">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">#</th>
                                    <th class="px-4 py-2">Name</th>
                                    <th class="px-4 py-2">Quantity</th>
                                    <th class="px-4 py-2">price</th>
                                    <th class="px-4 py-2">Image</th>
                                    <th class="px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(product, index) in products" :key="product.id">
                                    <td class="border px-4 py-2">{{ index + 1 }}</td>
                                    <td class="border px-4 py-2">{{ product.name }}</td>
                                    <td class="border px-4 py-2">{{ product.quantity }}</td>
                                    <td class="border px-4 py-2">{{ product.price }}</td>
                                    <td class="border px-4 py-2">{{ product.image }}</td>
                                    <td class="border px-4 py-2">
                                        <a :href="`/products/${product.id}/edit`"
                                            class="text-blue-600 hover:text-blue-800 mr-2">Edit</a>
                                        <button @click="deleteCategory(product.id)"
                                            class="text-red-600 hover:text-red-800">Delete</button>
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

        const categories = usePage().props.categories;

        // const { categories } = usePage().props.value;
        const products = usePage().props.products;
        const form = useForm({});
        const deleteCategory = (categoryId) => {
            if (confirm('Are you sure you want to delete?')) {
                form.delete(route('products.destroy', categoryId))
                window.location.reload();//because inertia is bit broken, fix it later, maybe its my PC?
            }
        };

        return {
            products,
            deleteCategory,
            categories
        };
    },
    head() {
        return {
            title: 'Product List',
        };
    },
    methods: {
        selectCategory() {
            router.get('?category=' + this.selectedCategory)
        }
    }
};
</script>
