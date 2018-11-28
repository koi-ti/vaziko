<template>
    <div>
        <form @submit.prevent="sendProducts">
            <product
                v-for="(producto, index) in productos"
                :producto="producto"
                :key="index"
                @prepare="parentData"
            >
            </product>

            <div class="row mt-2">
                <div class="form-group col-sm-2 offset-sm-4">
                    <router-link :to="{ name: 'home'}" tag="button" class="btn btn-block btn-default">Regresar</router-link>
                </div>
                <div class="form-group col-sm-2">
                    <button type="submit" class="btn btn-block btn-primary">Continuar</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import Product from './ProductComponent'

    export default {
        data() {
            return {
                productos: [],
                childProductos: []
            }
        },
        mounted() {
            this.initialize();
        },
        methods: {
            initialize() {
                const params = this.$route.query;

                axios.get('api/productos', {params})
                    .then(response => {
                        if( response.data.productos.length ) {
                            this.productos = response.data.productos;
                        }
                    });
            },

            parentData(value) {
                const valid = this.childProductos.find(item => item.sirvea_id === value.sirvea_id);
                if( valid ) return;
                this.childProductos.push(value);
            },

            sendProducts() {
                // Validar que contengan items
                if (this.childProductos.length <= 0 ) {
                    return toastr.error('No ha ingresado ningun producto para continuar.');
                }

                const params = {
                    producto: this.childProductos
                }

                this.$router.push({name: 'access', params: params});
            }
        },
        components: { Product }
    }
</script>

<style scoped>
    .card-producto>.card-header, .card-producto>.card-footer {
        background: #39526E;
        color: #fff;
        font-weight: bold;
    }

    .card-producto>.card-footer {
        font-size: 10px;
    }
</style>
