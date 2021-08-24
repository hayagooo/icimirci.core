<template>
    <div>
        <!-- component -->
      <div class="min-h-screen bg-gray-100 flex items-center justify-center">
            <div :class="{'max-w-2xl shadow-xl hover:shadow-2xl ' : previewImg}" class="container mx-auto max-w-md flex justify-center shadow-md hover:shadow-lg transition duration-300" >
                <div class="py-10 p-10 bg-white rounded-l-lg">
                    <h1 class="mb-6 font-bold text-2xl text-center">Edit data Art</h1>

                    <div class="">
                        <label class="mr-4 text-gray-700 font-bold inline-block mb-2" for="title">Title</label>
                        <input type="text" class="border bg-gray-100 py-2 px-4 w-96 outline-none focus:ring-2 focus:ring-indigo-400 rounded" placeholder="Title" v-model="form.title" id="title" :class="{ 'border-red-500':errors.title }" />
						<p v-if="errors.title" class="text-xs italic text-red-500 mt-2" >{{errors.title}}</p>
                    </div>
                    <div class="my-6">
                        <label class="mr-4 text-gray-700 font-bold inline-block mb-2" for="name">Description</label>
                        <input type="text" :class="{ 'border-red-500':errors.description }" class="border bg-gray-100 py-2 px-4 w-96 outline-none focus:ring-2 focus:ring-indigo-400 rounded" placeholder="Description" v-model="form.description" />
						<p v-if="errors.description" class="text-xs italic text-red-500 mt-2" >{{errors.title}}</p>
                    </div>
                    <div class="">
                        <label class="mr-4 text-gray-700 font-bold inline-block mb-2" for="name">Picture</label>
                        <input type="file" @input="form.picture = $event.target.files[0]" :class="{ 'border-red-500':errors.picture }" class="border bg-gray-100 py-2 px-4 w-96 outline-none focus:ring-2 focus:ring-indigo-400 rounded" placeholder="Description" @change="upload($event.target.files[0])" />
						<p v-if="errors.picture" class="text-xs italic text-red-500 mt-2" >{{errors.picture}}</p>
                    </div>
                    <button @click="submit(art.id)" class="w-full mt-6 text-indigo-50 font-bold bg-indigo-600 py-3 rounded-md hover:bg-indigo-500 transition duration-300">Submit</button>
                </div>
                <div  v-if="previewImg" class="py-16 p-10 bg-white rounded-r-lg flex items-strech">
                    <img :src="previewImg" alt=""  class="text-center max-w-md rounded-xl" style="height:500px">
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import {Inertia} from '@inertiajs/inertia'
export default {
    props: {
        errors: Object,
        art: Object
    },
    mounted(){
        this.getData()
    },
    data() {
        return {
            form: {
                title: null,
                description: null,
                picture: null,
                _method: 'PATCH'
            },
            previewImg: '',
        }
    },
    methods:{
        upload: function(data){
            this.previewImg = URL.createObjectURL(data)
        },
        getData: function(){
            this.form.title = this.art.title
            this.form.description = this.art.description
            this.previewImg = '/image/art/' + this.art.picture
        },
        submit: function(id){

            Inertia.post(route('art.update', id), this.form)
        }
    }
}
</script>
