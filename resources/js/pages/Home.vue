<template>
    <AppLayout>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Product name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Quantity
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Fulfilled Orders No.
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Active Order
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
                </thead>
                <tbody>

                <tr v-for="product in products" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ product.name }}
                    </th>
                    <td class="px-6 py-4">
                        {{ product.quantity }}
                    </td>
                    <td class="px-6 py-4">
                        {{ product.fulfilled_orders_count }}
                    </td>
                    <td class="px-6 py-4">
                        {{ product.order_number ?? "N/A" }}
                    </td>
                    <td class="px-6 py-4">
                        <button v-if="product.quantity > 0 && product.order_number == null"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                @click="handleOrder(product.id)">
                            order
                        </button>
                    </td>
                </tr>

                </tbody>
            </table>
        </div>
    </AppLayout>
</template>
<script setup>
import {ref, onMounted} from 'vue'
import AppLayout from "../layouts/AppLayout.vue";
// import {request} from '../helper'
// import Loader from './components/Loader.vue';

const products = ref([])
const isLoading = ref()
const token = localStorage.getItem('APP_USER_TOKEN')

const headers = {
    headers: {
        Authorization: 'Bearer ' + token
    }
}
onMounted(() => {
    handleProducts()
});

const handleProducts = async () => {
    isLoading.value = true
    const req = await axios.get('/api/products', headers)
    products.value = req.data.data
    isLoading.value = false
}

const handleOrder = async (product_id) => {
    isLoading.value = true
    alert('Are you sure you want to make this order?')
    await axios.post('/api/add-order/' + product_id, {}, headers)
    await handleProducts()
    isLoading.value = false
}
</script>
