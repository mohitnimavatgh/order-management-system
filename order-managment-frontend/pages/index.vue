<template>
    <div class="space-y-6">
        <h1 class="text-center text-xl">Order Management</h1>
        <div class="w-full flex justify-center">
            <form class="space-y-4" @submit.prevent="placeOrder">
                <div>
                    <ul>
                        <li v-for="error in errors">{{ error[0] }}</li>
                    </ul>
                </div>
                <div class="space-y-1">
                    <p class="text-gray-600 text-xs font-medium">Customer Name</p>
                    <input type="text" class="placeholder:text-gray-500 w-[300px] py-1 px-4 rounded-sm border border-gray-700 border-1" placeholder="Customer Name" v-model="form.customer_name"/>
                    <div v-if="v$.customer_name.$error" class="input-errors" v-for="error of v$.customer_name.$errors" :key="error.$uid">
                        <div class="error-msg text-red-500">{{ error.$message }}</div>
                    </div>
                </div>
                <div class="space-y-1">
                    <p class="text-gray-600 text-xs font-medium">Item Name</p>
                    <input type="text" class="placeholder:text-gray-500 w-[300px] py-1 px-4 rounded-sm border border-gray-700 border-1" placeholder="Item Name" v-model="form.item_name"/>
                    <div v-if="v$.item_name.$error" class="input-errors" v-for="error of v$.item_name.$errors" :key="error.$uid">
                        <div class="error-msg text-red-500">{{ error.$message }}</div>
                    </div>
                </div>
                <div class="space-y-1">
                    <p class="text-gray-600 text-xs font-medium">Price</p>
                    <input type="number" class="placeholder:text-gray-500 w-[300px] py-1 px-4 rounded-sm border border-gray-700 border-1" placeholder="Price" v-model="form.price"/>
                    <div v-if="v$.price.$error" class="input-errors" v-for="error of v$.price.$errors" :key="error.$uid">
                        <div class="error-msg text-red-500">{{ error.$message }}</div>
                    </div>
                </div>
                <div class="space-y-1">
                    <p class="text-gray-600 text-xs font-medium">Status</p>
                    <div class="border border-gray-700 border-1 py-1 px-3 rounded-sm">
                        <select class="placeholder:text-gray-500 w-full" v-model="form.status" >
                            <option value="pending">Pending</option>
                            <option value="paid">Paid</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div v-if="v$.status.$error" class="input-errors" v-for="error of v$.status.$errors" :key="error.$uid">
                        <div class="error-msg text-red-500">{{ error.$message }}</div>
                    </div>
                </div>
                <div>
                    <button class="bg-blue-800 w-full cursor-pointer py-2 px-4 text-white rounded-md" type="submit">Place Order</button>
                </div>
            </form>
        </div>
        <div class="flex justify-center">
            <table class="table-auto">
                <tbody>
                    <tr>
                        <th class="border text-gray-900 py-2 px-4">Customer Name</th>
                        <th class="border text-gray-900 py-2 px-4">Item Name</th>
                        <th class="border text-gray-900 py-2 px-4">Price</th>
                        <th class="border text-gray-900 py-2 px-4">Status</th>
                    </tr>
                    <tr v-for="order in orders">
                        <td class="border text-gray-700 py-2 px-4">{{order.customer_name}}</td>
                        <td class="border text-gray-700 py-2 px-4">{{order.item_name}}</td>
                        <td class="border text-gray-700 py-2 px-4">{{order.price}}</td>
                        <td class="border text-gray-700 py-2 px-4">                  
                            <div class="border border-gray-700 border-1 py-1 px-3 rounded-sm">
                                <select class="w-[150px]" v-model="order.status" @change="updateOrderStatus(order.id, $event.target.value)" :value="order.status">
                                    <option selected disabled value="pending">Pending</option>
                                    <option value="paid">Paid</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script setup>

import {ref, reactive, onMounted} from 'vue';
import { useVuelidate } from '@vuelidate/core'
import { required, numeric } from '@vuelidate/validators'
const form = reactive({
    customer_name: '',
    item_name: '',
    price: 0,
    status: 'pending'
})
const orders = ref([]);
const errors = ref([]);
const config = useRuntimeConfig()
const api = config.public.api
const rules = {
    customer_name: { required},
    item_name: { required},
    price: { required,numeric},
    status: { required}
}
const v$ = useVuelidate(rules, form)

function getOrderData() {
    $fetch(`${api}/orders`).then((resp) => {
        orders.value = resp.data
    }).catch((error) => {
        console.error(error)
    })
}
function placeOrder() {  
    v$.value.$validate().then((validate) => {
        if(!validate) return;
        errors.value = []
        $fetch(`${api}/orders`, {
            method: 'post',
            body: form
        }).then((resp) => {
            getOrderData()
            form.customer_name = ''
            form.item_name = ''
            form.price = 0
            form.status = 'pending'
            v$.value.$reset()
        }).catch((error) => {
            if (error?.status == 422) {
                errors.value = error.data.errors
            }
        })
    })
}
function updateOrderStatus(id, status) {    
    errors.value = []
    $fetch(`${api}/orders/${id}`, {
        method: 'put',
        body: {status}
    }).then((resp) => {
        getOrderData()
    }).catch((error) => {
        if (error?.status == 422) {
            errors.value = error.data.errors
        }
    })

}
onMounted(getOrderData)
</script>