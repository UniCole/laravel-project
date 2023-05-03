<!-- <script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script> -->
<script>
import NavBar from '@/Layouts/Store/NavBar.vue';
import Hero from '@/Layouts/Store/Hero.vue';
import Products from '@/Layouts/Store/Products.vue';
import Footer from '@/Layouts/Store/Footer.vue';

export default {
    components: {
        NavBar,
        Hero,
        Products,
        Footer,
    }
};
</script>
<template>
    <div class="container mx-auto bg-white text-gray-600 work-sans leading-normal text-base tracking-normal">
        <!--Nav-->
        <NavBar />
        <Hero />
        <Products />
        <Footer />
    </div>
</template>

