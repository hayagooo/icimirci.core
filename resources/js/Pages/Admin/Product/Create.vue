<template>
    <div>
        <input type="text" placeholder="Name" v-model="input.name">
        <input type="text" placeholder="Deskripsi" v-model="input.description">
        <button @click="onSubmit()" class="p-4 bg-gradient-to-r from-green-400 to-blue-500 hover:from-pink-500 hover:to-yellow-500">
            Submit
        </button>
    </div>
</template>

<script>
import {Inertia} from '@inertiajs/inertia'
export default {
    data() {
        return {
            input: {
                name: '',
                description: '',
            }
        }
    },
    methods: {
        onSubmit() {
            let formData = new FormData()
            formData.append('name', this.input.name)
            formData.append('description', this.input.description)
            Inertia.post(route('product.store'), formData)
        }
    }
}
</script>
