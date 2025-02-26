<template>
    <div>
        <loading v-if="loading" />

        <div v-if="product">
            <title-component :text="product.name" />
        </div>

        <div
            v-if="product"
            :class="$style.product"
            class="row"
        >
            <div class="col-4 pt-3">
                <img
                    class="d-block"
                    :src="product.image"
                    :alt="product.name"
                >

                <div class="p-2">
                    <small>brought to you by </small>

                    <small
                        class="d-inline"
                        v-text="product.brand"
                    />
                </div>
            </div>

            <div class="col-8 p-3">
                <div v-text="product.description" />

                <div class="row mt-4 align-items-center">
                    <div class="col-4">
                        Price: <strong>${{ price }}</strong>
                    </div>

                    <div class="col-8 p-3">
                        <div class="d-flex align-items-center justify-content-center">
                            <color-selector
                                v-if="product.colors.length !== 0"
                            />

                            <input
                                v-model.number="quantity"
                                class="form-control mx-3"
                                type="number"
                                min="1"
                            >

                            <button
                                class="btn btn-info btn-sm"
                                :disabled="cart === null"
                                @click="addToCart"
                            >
                                Add to Cart
                                <i
                                    v-show="addToCartLoading"
                                    class="fas fa-spinner fa-spin"
                                />
                                <i
                                    v-show="addToCartSuccess"
                                    class="fas fa-check"
                                />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { fetchCart, addItemToCart } from '@/services/cart-service.js';
import formatPrice from '@/helpers/format-price';
import { fetchOneProduct } from '@/services/products-service';
import ColorSelector from '@/components/color-selector';
import Loading from '@/components/loading';
import TitleComponent from '@/components/title';

export default {
    name: 'ProductShow',
    components: {
        ColorSelector,
        Loading,
        TitleComponent,
    },
    props: {
        productId: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            cart: null,
            quantity: 1,
            addToCartLoading: false,
            addToCartSuccess: false,
            product: null,
            loading: true,
        };
    },
    computed: {
    /**
     * Returns a formatted price for the product
     * @returns {string}
     */
        price() {
            return formatPrice(this.product.price);
        },
    },
    async created() {
        fetchCart().then((cart) => {
            this.cart = cart;
        });

        try {
            this.product = (await fetchOneProduct(this.productId)).data;
        } finally {
            this.loading = false;
        }
    },
    methods: {
        async addToCart() {
            this.addToCartLoading = true;
            this.addToCartSuccess = false;
            await addItemToCart(this.cart, {
                product: this.product['@id'],
                color: null,
                quantity: this.quantity,
            });
            this.addToCartLoading = false;
            this.addToCartSuccess = true;
        },
    },
};
</script>

<style lang="scss" module>
@import '~styles/components/light-component';

.product {
  @include light-component;

  img {
    max-width:100%;
    max-height:100%;
  }

  input {
    width: 60px;
  }
}
</style>
