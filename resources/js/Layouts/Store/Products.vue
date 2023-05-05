<template>
    <section class="bg-white py-8">
        <div class="container mx-auto flex items-center flex-wrap pt-4 pb-12">
            <div v-for="product in products.data" :key="product.id" class="w-full md:w-1/3 xl:w-1/4 p-6 flex flex-col">
                <a href="#">
                    <img class="hover:grow hover:shadow-lg" :src="product.image">
                    <div class="pt-3 flex items-center justify-between">
                        <p class="">{{ product.name }}</p>
                        <a @click="addToCart(product)" class="pl-3 inline-block no-underline hover:text-black" href="#">
                            <svg class="fill-current hover:text-black" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24">
                                <path
                                    d="M21,7H7.462L5.91,3.586C5.748,3.229,5.392,3,5,3H2v2h2.356L9.09,15.414C9.252,15.771,9.608,16,10,16h8 c0.4,0,0.762-0.238,0.919-0.606l3-7c0.133-0.309,0.101-0.663-0.084-0.944C21.649,7.169,21.336,7,21,7z M17.341,14h-6.697L8.371,9 h11.112L17.341,14z" />
                                <circle cx="10.5" cy="18.5" r="1.5" />
                                <circle cx="17.5" cy="18.5" r="1.5" />
                            </svg>
                        </a>
                    </div>
                    <p class="pt-1 text-gray-900">{{ product.price }}</p>
                </a>
            </div>

        </div>
        <div class="flex justify-center my-8">
            <Link :href="`?page=${products.current_page - 1}`" class="mr-2" method="get" as="button" type="button"
                :disabled="products.current_page == 1">
            Previous
            </Link>

            <Link :href="`?page=${products.current_page + 1}`" class="ml-2" method="get" as="button" type="button"
                :disabled="products.current_page === products.last_page">
            Next
            </Link>
        </div>

    </section>
</template>


<script>

import { usePage, Link } from '@inertiajs/vue3';

export default {
    components: {
        Link,
    },
    setup() {
        const products = usePage().props.products;
        return {
            products,
        };
    },
    methods: {
        addToCart(product) {
            // Retrieve the existing cart values from local storage
            const existingCart = JSON.parse(localStorage.getItem('cart')) || [];

            // Add the selected product to the cart
            existingCart.push(product.id);

            // Store the updated cart in local storage
            localStorage.setItem('cart', JSON.stringify(existingCart))
            window.location.reload();//TODO: need to be fixed, should use $emit instead
        }
    },
};

</script>