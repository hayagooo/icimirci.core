<template>
    <dashboard-page>
        <h1>Product</h1>
        <button type="button" @click="createData()" class="p-4 bg-gradient-to-r from-green-400 to-blue-500 hover:from-pink-500 hover:to-yellow-500">Tambah produk</button>
        <input type="text" v-model="input.name" @keyup="search()">
        <div :key="index" v-for="item, index in products">
            <h2 class="text-2xl font-bold">{{ item.name }}</h2>
            <p>{{ item.description }}</p>
            <button class="bg-green-500 p-4" type="button" @click="editData(item.id)">Edit</button>
            <button class="bg-red-500 p-4" type="button" @click="ondelete.status = true, ondelete.id = item.id">Delete</button>
        </div>

        <!-- modal -->
        <div v-if="ondelete.status" class="min-w-screen h-screen animated fadeIn faster  fixed  left-0 top-0 flex justify-center items-center inset-0 z-50 outline-none focus:outline-none bg-no-repeat bg-center bg-cover" id="modal-id">
            <div class="absolute bg-black opacity-80 inset-0 z-0"></div>
            <div class="w-full  max-w-lg p-5 relative mx-auto my-auto rounded-xl shadow-lg  bg-white ">
            <!--content-->
            <div class="">
                <!--body-->
                <div class="text-center p-5 flex-auto justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 -m-1 flex items-center text-red-500 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 flex items-center text-red-500 mx-auto" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                            <h2 class="text-xl font-bold py-4 ">Are you sure?</h2>
                            <p class="text-sm text-gray-500 px-8">Do you really want to delete this product ?
                    This process cannot be undone</p>
                </div>
                <!--footer-->
                <div class="p-3  mt-2 text-center space-x-4 md:block">
                    <button @click="ondelete.status = false, ondelete.id = null" class="mb-2 md:mb-0 bg-white px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-gray-600 rounded-full hover:shadow-lg hover:bg-gray-100">
                        Cancel
                    </button>
                    <button @click="deleteData(ondelete.id)" class="mb-2 md:mb-0 bg-red-500 border border-red-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-600">Delete</button>
                </div>
            </div>
            </div>
        </div>
    </dashboard-page>
</template>

<script>
import DashboardPage from '@/Layouts/DahboardPage'
import { Inertia } from '@inertiajs/inertia'
export default {
    props: ['products'],
    data() {
        return {
            ondelete: {
                status: false,
                id: null
            },
            input: {
                name: ''
            }
        }
    },
    components: {
        DashboardPage
    },
    methods: {
        search() {
            Inertia.get(route('product.index'), {
                name: this.input.name
            }, { preserveState: true })
        },
        createData() {
            Inertia.get(route('product.create'))
        },
        editData(id) {
            console.log('edit')
            Inertia.get(route('product.edit', id))
        },
        deleteData(id) {
            Inertia.delete(route('product.destroy', id))
            this.ondelete.status = false
            this.ondelete.id = null
        },
    }
}
</script>
