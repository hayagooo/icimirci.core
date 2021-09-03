<template>
    <div>
        <input type="text" placeholder="Nama Category" v-model="form.category">
        <button @click="submit()" class="p-4 bg-gradient-to-r from-green-400 to-blue-500 hover:from-pink-500 hover:to-yellow-500">
            Submit
        </button>
    </div>
</template>

<script>
import {Inertia} from '@inertiajs/inertia'
import { useForm } from '@inertiajs/inertia-vue3'
export default {
    setup() {
        const form = useForm({
            category:null,
        })
        function submit(){
            Inertia.post(route('category.store'), form)
        }
        return { form, submit }
    },
}
</script>