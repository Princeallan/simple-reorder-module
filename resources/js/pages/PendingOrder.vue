<template>

    <app-layout>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Product name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Order Date
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
                </thead>
                <tbody>

                <tr v-for="order in orders" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ order.product_name }}
                    </th>
                    <td class="px-6 py-4">
                        {{ order.created_at }}
                    </td>
                    <td class="px-6 py-4">
                        {{ order.order_number }}
                    </td>
                    <td class="px-6 py-4">
                        <button class="bg-emerald-500 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded"
                                @click="fulFillOrder(order.id)">
                            Fulfill
                        </button>
                    </td>
                </tr>

                </tbody>
            </table>
        </div>
    </app-layout>
</template>
<script setup>
import {ref, onMounted} from 'vue'
import AppLayout from "../layouts/AppLayout.vue";
// import {request} from '../helper'
// import Loader from './components/Loader.vue';

const orders = ref([])
const isLoading = ref()
const status = ref(1)
const fulfil = ref(2)

onMounted(() => {
    listPendingOrders()
});

const listPendingOrders = async () => {
    isLoading.value = true
    const req = await axios.get('/api/orders/' + status.value)
    orders.value = req.data.data
    isLoading.value = false
}

const fulFillOrder = async (order_id) => {
    isLoading.value = true
    alert('are you sure you want to fulfil this order?')
    await axios.post('/api/order/update/' + order_id + '/' + fulfil.value)
    await listPendingOrders()
    isLoading.value = false
}
</script>
