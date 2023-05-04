<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Product</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submitForm">
                            <div class="mb-4">
                                <label class="block text-gray-700 font-bold mb-2" for="name">
                                    Name
                                </label>
                                <input v-model="form.name"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="name" name="name" type="text" placeholder="Product Name">
                                <p v-if="form?.errors.name" class="text-red-500 text-xs italic">{{ form.errors.name }}</p>
                            </div>
                     
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-bold mb-2" for="quantity">
                                        Quantity
                                    </label>
                                    <input v-model="form.quantity"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        id="name" name="name" type="text" placeholder="Product quantity">
                                    <p v-if="form?.errors.quantity" class="text-red-500 text-xs italic">{{ form.errors.quantity
                                    }}</p>
                                </div>
                          
                        
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-bold mb-2" for="price">
                                        Price
                                    </label>
                                    <input v-model="form.price"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        id="name" name="name" type="text" placeholder="Product price">
                                    <p v-if="form?.errors.price" class="text-red-500 text-xs italic">{{ form.errors.price
                                    }}</p>
                                </div>
                            
                            
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-bold mb-2" for="image">
                                        Image URL
                                    </label>
                                    <input v-model="form.image"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        id="name" name="name" type="text" placeholder="Product image">
                                    <p v-if="form?.errors.image" class="text-red-500 text-xs italic">{{
                                        form.errors.image }}</p>
                                </div>
                            
                            <div class="flex items-center justify-between">
                                <button type="submit"
                                    class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-500">Save</button>
                                <a :href="route('products.index')"
                                    class="px-4 py-2 text-white bg-gray-500 rounded hover:bg-gray-400">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/vue3';

export default {
    components: {
        AuthenticatedLayout,
    },
    props: {
        product: {
            type: Object,
            required: true
        }
    },
    setup(props) {
        const form = useForm({
            name: props.product.name,
            quantity: props.product.quantity,
            price: props.product.price,
            image: props.product.image,
        });

        const submitForm = () => {
            form.put(route('products.update', props.product.id));
        };

        return {
            form: form,
            submitForm,
        };
    },
    head() {
        return {
            title: 'Edit Product',
        };
    },
};
</script>