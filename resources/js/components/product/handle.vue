<template>
    <div>
        <h3 class="text-center">{{product_id?'Edit':'Add'}} Product</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="submit" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" required class="form-control" v-model="product.name">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" v-model="product.description">
                        </textarea>
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <input step="0.01" type="number" class="form-control" v-model="product.price">
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" v-model="product.category_id">
                            <option v-for="option in categories" v-bind:value="option.value">
                                {{ option.text }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <a target="_blank" v-if="product.image" :href="'/upload/'+product.image"><img v-if="product.image" width="50" :src="'/upload/'+product.image" /></a>
                        <input type="file" class="form-control" v-on:change="onFileChange" name="image" accept="image/x-png,image/gif,image/jpeg"/>
                    </div>
                    <button type="submit" class="btn btn-primary">{{product_id?'Edit':'Add'}} Product</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                product_id: null,
                product: {},
                image: null,
                categories: {},
            }
        },
        created () { 

        console.log(base_url);
            // Get categories list
            this.axios
            .get(`/api/categories/list`)
            .then((response) => {
                this.categories = response.data
            })

            if(this.$route.params.id){
                // Get product info
                this.product_id = this.$route.params.id
                this.axios
                .get(`/api/product/edit/${this.$route.params.id}`)
                .then((response) => {
                    this.product = response.data
                })
            }
            return null 
        },
        methods: {
            onFileChange(e) {
                this.image = e.target.files[0];
            },
            submit() {
                var url_ = "add"
                if(this.product_id)
                    url_ = "update/"+this.product_id
                const config = {
                    headers: {
                        'content-type': 'multipart/form-data;',
                    }
                }
                let formData = new FormData();
                if(this.image)
                    formData.append('image', this.image);
                for (var z in this.product) {
                    if(this.product[z])
                        formData.append(z, this.product[z]);
                }
                this.axios
                .post('/api/product/'+url_, formData, config)
                .then(response => (
                    this.$router.push({name: 'productList'})
                ))
                .catch(error => console.log(error))
                .finally(() => this.loading = false)
            }
        }
    }
</script>