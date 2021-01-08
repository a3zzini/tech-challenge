<template>
    <div>
        <h3 class="text-center">{{category_id?'Edit':'Add'}} Category</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="submit" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" required class="form-control" v-model="category.name">
                    </div>
                    <div class="form-group">
                        <label>Parent category</label>
                        <select class="form-control" v-model="category.parent_category_id">
                            <option v-for="option in categories " v-bind:value="option.value" v-if="!category_id || option.value!=category_id">
                                {{ option.text }}
                            </option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">{{category_id?'Edit':'Add'}} Category</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                category_id: null,
                category: {},
                categories: {},
            }
        },
        created () { 
            this.axios
            .get(`/api/categories/list`)
            .then((response) => {
                this.categories = response.data
            })

            if(this.$route.params.id){
                this.category_id = this.$route.params.id
                this.axios
                .get(`/api/category/edit/${this.$route.params.id}`)
                .then((response) => {
                    this.category = response.data
                })
            }
            return null 
        },
        methods: {
            submit() {
                var url_ = "add"
                if(this.category_id)
                    url_ = "update/"+this.category_id

                this.axios
                .post('/api/category/'+url_, this.category)
                .then(response => (
                    this.$router.push({name: 'categoryList'})
                ))
                .catch(error => console.log(error))
                .finally(() => this.loading = false)
            }
        }
    }
</script>