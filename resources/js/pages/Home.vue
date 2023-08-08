<template>
    <AppLayout>
        <div class="grid grid-flow-col gap-4">
            <div class="ml-5">
                <h2 class="mt-5 block uppercase font-bold">Products</h2>
            </div>
            <div class="mr-10">
                <router-link to="/create-product">
                    <button type="button"
                            class="float-right text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:shadow-none focus:outline-none active:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                        <img src="//cdn.jsdelivr.net/npm/heroicons@1.0.1/outline/plus.svg"
                             class="w-7 text-white-800 fill-current inline"/>
                        Create Product
                    </button>
                </router-link>

            </div>
        </div>
        <hr>
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
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-1"
                                @click="handleOrder(product.id)">
                            order
                        </button>

                        <button class="bg-gray-500 mr-1 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                            @click="editProduct(product.id)">Edit</button>

                        <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                            @click="deleteProduct(product.id)">Delete</button>

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
import { useRouter } from 'vue-router';
import {useNotification} from "@kyvg/vue3-notification";

const {notify} = useNotification()
const products = ref([])
const router = useRouter()
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
    await axios.post('/api/add-order/' + product_id, {}, headers).then(response => {

        notify({
            type: 'success',
            title: "Success",
            text: "Order Successfully Added!!!",
        });

        handleProducts()
        isLoading.value = false
    }).catch(error =>{

        notify({
            type: 'error',
            title: "Failed",
            text: "Order Failed, Check before trying again!",
        });

    })
}
const editProduct = async (product_id) => {
    await router.push({ name: "edit-product", params: { id: product_id } });
}

const deleteProduct = async (product_id) => {
    try {
        await axios.delete(`/api/products/${product_id}`, headers);
        await handleProducts()
        console.log('Product and related orders deleted');
    } catch (error) {
        console.error('Error deleting product:', error);
    }
}
</script>
