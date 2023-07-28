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
                        Order Number
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Fulfilled Date
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
                    </th>
                </tr>
                </thead>
                <tbody>

                <tr v-for="order in orders" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ order.product_name }}
                    </th>
                    <td class="px-6 py-4">
                        {{ order.order_number }}
                    </td>
                    <td class="px-6 py-4">
                        {{ formatDate(order.updated_at) }}
                    </td>
                    <td class="px-6 py-4 text-green-600">
                        {{ order.status }}
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
const status = ref(2)
const token = localStorage.getItem('APP_USER_TOKEN')

const headers = {
    headers: {
        Authorization: 'Bearer ' + token
    }
}

onMounted(() => {
    listFulfilledOrders()
});

const formatDate = (dateString) => {
    const date = dayjs(dateString);
    // Then specify how you want your dates to be formatted
    return date.format('dddd MMMM D, YYYY');
}
const listFulfilledOrders = async () => {
    isLoading.value = true
    const req = await axios.get('/api/orders/' + status.value, headers)
    orders.value = req.data.data
    isLoading.value = false
}

</script>
