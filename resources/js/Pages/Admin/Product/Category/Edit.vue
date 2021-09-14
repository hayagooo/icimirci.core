<template>
    <div>
        <input type="text" placeholder="Nama Category" v-model="form.category">
        <textarea placeholder="Nama Category" v-model="form.description"></textarea>
        <button @click="submit(category_product.id)" class="p-4 bg-gradient-to-r from-green-400 to-blue-500 hover:from-pink-500 hover:to-yellow-500">
            Submit
        </button>
    </div>
</template>

<script>
import {Inertia} from '@inertiajs/inertia'
export default {
    props: ['category_product'],
    mounted() {
        this.getData()
    },
    data() {
        return{
            form: {
                category:null,
                _method:'PATCH',
            },
        }
    },
    methods: {
        getData(){
            this.form.category = this.category_product.category
            this.form.description = this.category_product.description
        },
        submit: function(id){
            Inertia.post(route('category.update', id), this.form)
        }
    }
}
</script>