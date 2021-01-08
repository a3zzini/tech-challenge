<template>
    <div>
        <h3 class="text-center">All Categories</h3><br/>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Parent category</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="category in categories" :key="category.id">
                <td><router-link :to="{name: 'categoryHandle', params: { id: category.id }}">{{ category.id }}</router-link></td>
                <td>{{ category.name }}</td>
                <td>{{ category.parent_category }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <router-link :to="{name: 'categoryHandle', params: { id: category.id }}" class="btn btn-primary">Edit
                        </router-link>
                        <button class="btn btn-danger" @click="deleteCategory(category.id)">Delete</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                categories: []
            }
        },
        created() {
            this.axios
            .get('/api/categories')
            .then(response => {
                this.categories = response.data;
            });
        },
        methods: {
            deleteCategory(id) {
                this.axios
                .delete(`/api/category/delete/${id}`)
                .then(response => {
                    let i = this.categories.map(item => item.id).indexOf(id);
                    this.categories.splice(i, 1)
                });
            }
        }
    }
</script>