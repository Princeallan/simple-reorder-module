<template>
    <AppLayout>
        <div
            class="block rounded-lg bg-white shadow-lg dark:bg-neutral-700">
            <div class="grid grid-flow-col gap-4">
                <div class="ml-8">
                    <h2 class="mt-5 block uppercase font-bold">Create Product Form</h2>
                </div>

                <div class="mr-10">
                    <router-link to="/home">
                        <button type="button"
                                class="float-right mt-3 text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:shadow-none focus:outline-none active:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                            <img src="//cdn.jsdelivr.net/npm/heroicons@1.0.1/outline/plus.svg"
                                 class="w-7 text-white-800 fill-current inline"/>
                            All Products
                        </button>
                    </router-link>
                </div>
            </div>

            <form class="w-full  px-6 py-6">
                <div class="flex flex-wrap -mx-3 mb-6">

                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="grid-last-name">
                            Product Name
                        </label>
                        <input
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="grid-last-name"
                            type="text"
                            v-model="product.name"
                            placeholder="Iphone 14">
                    </div>

                    <div class="w-full md:w-1/4 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="quantity">
                            Quantity
                        </label>
                        <input
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="quantity"
                            type="number"
                            v-model="product.quantity"
                            placeholder="10">
                    </div>
                    <div class="w-full md:w-1/4 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="uom">
                            UOM
                        </label>
                        <input
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="uom"
                            type="text"
                            v-model="product.uom"
                            placeholder="Kgs">
                    </div>
                    <div class="w-full px-3 pt-5">
                        <div class="mr-10">
                            <button type="button"
                                    class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:shadow-none focus:outline-none active:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"
                                    @click="updateProduct">
                                <img src="//cdn.jsdelivr.net/npm/heroicons@1.0.1/outline/check.svg"
                                     class="w-7 text-white-800 fill-current inline"/>
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
<script setup>
import {ref, reactive, computed, onMounted} from 'vue'
import AppLayout from "../layouts/AppLayout.vue";
import {useRouter, useRoute} from 'vue-router';
import {useNotification} from "@kyvg/vue3-notification";

const {notify} = useNotification()
const router = useRouter();
const route = useRoute();
const isLoading = ref()
const token = localStorage.getItem('APP_USER_TOKEN')
let product = reactive({})
const productId = route.params.id;

const headers = {
    headers: {
        Authorization: 'Bearer ' + token
    }
}
onMounted(() => {
    if (productId) {
        axios.get(`/api/products/${productId}`, headers).then(response => {
            let data = response.data.data;
            product.name = data.name;
            product.uom = data.uom;
            product.quantity = data.quantity;
        })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }
})
const updateProduct = async () => {
    isLoading.value = true

    alert('Are you sure you want to save this product?')
    await axios.put(`/api/products/update/${productId}`, {
        name: product.name,
        quantity: product.quantity,
        uom: product.uom,
    }, headers).then((response) => {

        notify({
            type: 'success',
            title: "Authorization",
            text: "Product successfully updates!!",
        }).catch(error =>{
            notify({
                type: 'error',
                title: "Failed",
                text: "Saving Failed, Check before trying again!",
            });
        });

        router.push('/home')
        isLoading.value = false
    })

}

</script>
