<template>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Product name
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
                    {{ order.name }}
                </th>
                <td class="px-6 py-4">
                    {{ order.updated_at }}
                </td>
                <td class="px-6 py-4">
                    {{ order.order_number }}
                </td>

            </tr>

            </tbody>
        </table>
    </div>
</template>
<script setup>
import {ref, onMounted} from 'vue'
// import Loader from './components/Loader.vue';

const orders = ref([])
const isLoading = ref()
const status = ref(2)

onMounted(() => {
    listFulfilledOrders()
});

const listFulfilledOrders = async () => {
    isLoading.value = true
    const req = await axios.get('/api/orders/' + status.value)
    orders.value = req.data.data
    isLoading.value = false
}

</script>
