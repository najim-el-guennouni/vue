<template>
    <div>
        <div class="row">
            <div class="col-12">
                <h1>
                    Products
                </h1>
            </div>
        </div>
        <product-list :products="products" />
    </div>
</template>
<script>
import axios from 'axios';
import LegendComponent from '@/components/legend';
import ProductList from '@/components/product-list';

export default {

    name: 'Catalog',
    components: {
        LegendComponent,
        ProductList,
    },
    data: () => ({
        products: [],
        legend: 'Shipping takes 10-12 weeks, and products probably won\'t work',
    }),
    async  mounted() {
        const response = await axios.get('/api/products');
        this.products = response.data['hydra:member'];
    },
};
</script>
