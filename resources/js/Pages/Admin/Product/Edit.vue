<template>
    <div>
        <input type="text" placeholder="Name" v-model="form.name">
        <input type="text" placeholder="Deskripsi" v-model="form.description">
        <input type="file" @input="form.image = $event.target.files[0]" @change="upload($event.target.files[0])" /> 
        <button @click="submit(product.id)" class="p-4 bg-gradient-to-r from-green-400 to-blue-500 hover:from-pink-500 hover:to-yellow-500">
            Update
        </button>
    </div>
</template>

<script>
import {Inertia} from '@inertiajs/inertia'
export default {
    props: ['product'],
    mounted(){
        this.getData()
    },
    data() {
        return {
            form: {
                name: null,
                description: null,
                image: null,
                _method: 'PATCH'
            },
            previewImg: '',
        }
    },
    methods: {
        upload: function(data){
            this.previewImg = URL.createObjectURL(data)
        },
        getData() {
            this.form.name = this.product.name
            this.form.description = this.product.description
            this.previewImg = '/image/product/' + this.product.image
        },
        submit: function(id){
            Inertia.post(route('product.update', id), this.form)
        }
    }
}
</script>
