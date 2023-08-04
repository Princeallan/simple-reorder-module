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
                        {{ order.product.name }}
                    </th>
                    <td class="px-6 py-4">
                        {{ formatDate(order.created_at) }}
                    </td>
                    <td class="px-6 py-4">
                        {{ order.order_number }}
                    </td>
                    <td class="px-6 py-4">
                        <button class="bg-emerald-500 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded"
                                @click="makeReOrder(order.id)">
                            ReOrder
                        </button>
                        <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                @click="deleteOrder(order.id)">
                            Delete
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
import dayjs from 'dayjs';

const orders = ref([])
const isLoading = ref()
const token = localStorage.getItem('APP_USER_TOKEN')

const headers = {
    headers: {
        Authorization: 'Bearer ' + token
    }
}
onMounted(() => {
    listOrders()
});
const formatDate = (dateString) => {
    const date = dayjs(dateString);
    // Then specify how you want your dates to be formatted
    return date.format('dddd MMMM D, YYYY');
}
const listOrders = async () => {
    isLoading.value = true
    const req = await axios.get('/api/orders', headers)
    orders.value = req.data.data
    isLoading.value = false
}

const makeReOrder = async (order_id) => {
    isLoading.value = true
    alert('Are you sure you want to reorder this order?')
    await axios.post('/api/re-order/' + order_id, {}, headers)
    await listOrders()
    isLoading.value = false
}
const deleteOrder = async (order_id) => {
    isLoading.value = true
    alert('Are you sure you want to delete this order?')
    await axios.delete('/api/order/delete/' + order_id, headers)
    await listOrders()
    isLoading.value = false
}
</script>
