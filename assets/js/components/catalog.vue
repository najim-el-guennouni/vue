<template>
    <div>
        <div class="row">
            <div class="col-12">
                <h1>
                    Products
                </h1>
            </div>
        </div>
        <product-list
            :products="products"
            :loading="loading"
        />
    </div>
</template>
<script>
import LegendComponent from '@/components/legend';
import ProductList from '@/components/product-list';
import { fetchProducts } from '@/services/products-service';

export default {

    name: 'Catalog',
    components: {
        LegendComponent,
        ProductList,
    },
    props: {
        currentCategoryId: {
            type: String,
            default: null,
        },
    },
    data: () => ({
        products: [],
        loading: false,
        legend: 'Shipping takes 10-12 weeks, and products probably won\'t work',
    }),
    async created() {
        const params = {};
        if (this.currentCategoryId) {
            params.category = this.currentCategoryId;
        }

        this.loading = true;
        let response;
        try {
            response = await fetchProducts(this.currentCategoryId);
            this.loading = false;
        } catch (e) {
            this.loading = false;
            return;
        }
        this.products = response.data['hydra:member'];
    },
};
</script>
