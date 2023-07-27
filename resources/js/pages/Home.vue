<template>

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
                    {{ product.order_number }}
                </td>
                <td class="px-6 py-4">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                    @click="handleOrder">
                        order
                    </button>
                </td>
            </tr>

            </tbody>
        </table>
    </div>
</template>
<script setup>
import {ref, onMounted} from 'vue'
// import {request} from '../helper'
// import Loader from './components/Loader.vue';

const products = ref([])
const isLoading = ref()

onMounted(() => {
    handleProducts()
});

const handleProducts = async () => {
    const req = await axios.get('/api/products')
    products.value = req.data.data
    isLoading.value = false
}
const handleOrder = async () => {
    isLoading.value = false
    await axios.post('/api/add-order')
    isLoading.value = false
}
</script>
