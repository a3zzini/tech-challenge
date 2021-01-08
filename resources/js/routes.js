import productList from './components/product/list.vue';
import productHandle from './components/product/handle.vue';
import categoryList from './components/category/list.vue';
import categoryHandle from './components/category/handle.vue';

export const routes = [
    {
        name: 'productList',
        path: '/',
        component: productList
    },
    {
        name: 'productHandle',
        path: '/product/handle',
        component: productHandle
    },
    {
        name: 'categoryList',
        path: '/category/list',
        component: categoryList
    },
    {
        name: 'categoryHandle',
        path: '/category/handle',
        component: categoryHandle
    }
];