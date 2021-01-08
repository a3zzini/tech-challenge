<template>
    <div>
        <h3 class="text-center">All Products</h3><br/>
        <input class="form-control mb-2 w-50" type="text"
                placeholder="Filter by id, name, description, price or category"
                v-model="filter" />
        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="cursor-pointer" @click="sort('id')">ID</th>
                <th class="cursor-pointer" @click="sort('name')">Name</th>
                <th class="cursor-pointer" @click="sort('description')">Description</th>
                <th class="cursor-pointer" @click="sort('price')">Price</th>
                <th class="cursor-pointer" @click="sort('category')">Category</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="product in sortedProducts" :key="product.id">
                <td><router-link :to="{name: 'productHandle', params: { id: product.id }}">{{ product.id }}</router-link></td>
                <td>{{ product.name }}</td>
                <td>{{ product.description }}</td>
                <td>{{ product.price }}</td>
                <td>{{ product.category }}</td>
                <td>
                    <a target="_blank" v-if="product.image" :href="'/upload/'+product.image"><img v-if="product.image" width="50" :src="'/upload/'+product.image" /></a>
                </td>
                <td>
                    <div class="btn-group" role="group">
                        <router-link :to="{name: 'productHandle', params: { id: product.id }}" class="btn btn-primary">Edit
                        </router-link>
                        <button class="btn btn-danger" @click="deleteProduct(product.id)">Delete</button>
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
                products: [],
                currentSort:'id',
                currentSortDir:'asc',
                filter: null
            }
        },
        created() {
            this.axios
            .get('/api/products')
            .then(response => {
                this.products = response.data;
            });
        },
        methods: {
            sort:function(s) {
                if(s === this.currentSort) {
                    this.currentSortDir = this.currentSortDir==='asc'?'desc':'asc';
                }
                this.currentSort = s;
            },
            deleteProduct(id) {
                this.axios
                .delete(`/api/product/delete/${id}`)
                .then(response => {
                    let i = this.products.map(item => item.id).indexOf(id); // find index of your object
                    this.products.splice(i, 1)
                });
            },
            filteredRows() {
                 if(!this.filter)
                    return this.products;
                return this.products.filter(row => {
                    let found = false;
                    for(var z in row){
                        if(z!="image" && row[z].toString().toLowerCase().includes(this.filter.toLowerCase()))
                        {
                            found = true;
                            break;
                        }
                    }
                    return found;
                })
            },
        },
        computed:{
            sortedProducts:function() {
                
                return this.filteredRows().sort((a,b) => {
                    let modifier = 1;
                    if(this.currentSortDir === 'desc') modifier = -1;
                    if(a[this.currentSort] < b[this.currentSort]) return -1 * modifier;
                    if(a[this.currentSort] > b[this.currentSort]) return 1 * modifier;
                    return 0;
                });
            }
        }
    }
</script>