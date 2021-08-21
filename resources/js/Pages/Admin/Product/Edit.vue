<template>
    <div>
        <input type="text" placeholder="Name" v-model="input.name">
        <input type="text" placeholder="Deskripsi" v-model="input.description">
        <button @click="onSubmit()" class="p-4 bg-gradient-to-r from-green-400 to-blue-500 hover:from-pink-500 hover:to-yellow-500">
            Update
        </button>
    </div>
</template>

<script>
import {Inertia} from '@inertiajs/inertia'
export default {
    props: ['product'],
    data() {
        return {
            input: {
                name: '',
                description: '',
            }
        }
    },
    // function di load
    mounted() {
        this.getData()
    },
    // function setelah di load
    created() {

    },
    methods: {
        getData() {
            this.input.name = this.product.name
            this.input.description = this.product.description
        },
        onSubmit() {
            let formData = new FormData()
            formData.append('name', this.input.name)
            formData.append('description', this.input.description)
            formData.append('_method', 'PATCH')
            Inertia.post(route('product.update', this.product.id), formData)
        }
    }
}
</script>
