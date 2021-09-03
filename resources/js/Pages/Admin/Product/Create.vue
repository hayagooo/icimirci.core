<template>
    <div>
        <input type="text" placeholder="Name" v-model="form.name" />
        <input type="text" placeholder="Deskripsi" v-model="form.description" />
        <input type="file" @input="form.image = $event.target.files[0]" /> 
        <select v-model="form.category_id">
            <option value="">Pilih Category</option>
            <option v-for="item, index in category_product" :key="index" :value="item.id">{{ item.category }}</option>
        </select>
        <button @click="submit()" class="p-4 bg-gradient-to-r from-green-400 to-blue-500 hover:from-pink-500 hover:to-yellow-500">
            Submit
        </button>
    </div>
</template>

<script>
import {Inertia} from '@inertiajs/inertia'
import { useForm } from '@inertiajs/inertia-vue3'
export default {
    props : ['category_product'],
    setup () {
        const form = useForm({
            name: null,
            description: null,
            image: null,
            category_id: null,
        })
        function submit() {
            Inertia.post(route('product.store'), form)
        }
        return { form, submit }
    },
    data() {
        return {
            previewImg: ''
        }
    },
    methods:{
        upload: function(data){
            this.previewImg = URL.createObjectURL(data)
        }
    }
}
</script>
