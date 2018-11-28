<template>
    <div>
        <div class="row my-3">
            <div class="col-12 col-sm-12 col-md-12 col-lg-4">
                <div class="card card-default">
                    <div class="card-header">
                        Resumen de compra
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 col-sm-4 col-lg-4">
                                <p><b>Marca:</b></p>
                            </div>
                            <div class="col-6 col-sm-8 col-lg-8 text-right">
                                <p>{{ producto.marca }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-sm-4 col-lg-5">
                                <p><b>Referencia:</b></p>
                            </div>
                            <div class="col-6 col-sm-8 col-lg-7 text-right">
                                <p>{{ producto.referencia }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-sm-4 col-lg-4">
                                <p><b>Cantidad:</b></p>
                            </div>
                            <div class="col-6 col-sm-8 col-lg-8 text-right">
                                <p>{{ producto.cantidad }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-sm-4 col-lg-4">
                                <p><b>Precio:</b></p>
                            </div>
                            <div class="col-6 col-sm-8 col-lg-8 text-right">
                                <p>$ {{ producto.precio }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-sm-4 col-lg-4">
                                <p><b>IVA {{ producto.iva_porcentaje }}%:</b></p>
                            </div>
                            <div class="col-6 col-sm-8 col-lg-8 text-right">
                                <p>$ {{ producto.iva }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-sm-4 col-lg-6">
                                <p><b>Precio final:</b></p>
                            </div>
                            <div class="col-6 col-sm-8 col-lg-6 text-right">
                                <p>$ {{ producto.total }} </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <select class="form-control" v-model="sucursal">
                            <option value selected hidden disabled>Punto de entrega</option>
                            <optgroup v-for="regional in producto.sucursales" :label="regional.regional">
                                <option v-for="sucursal in regional.sucursales" :value="sucursal.id">{{ sucursal.nombre }}</option>
                            </optgroup>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-7 offset-lg-1">
                <div class="card card-producto">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-7">
                                <img :src="producto.imagen" alt="Ver producto" width="100%">
                            </div>
                            <div class="col-sm-5" v-if="image">
                                <img :src="image" alt="Ver sucursal" width="100%" height="100%" @click="showModal">

                                <div>
                                    <b-modal :id="'resourceImage_'+this.producto.sirvea_id" hide-footer size="sm" v-model="modalShow">
                                        <img :src="image" alt="Ver sucursal" width="100%" height="100%">
                                    </b-modal>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <p>Imágenes de referencia sujetas a cambio sin previo aviso-Los pagos serán verificados y este proceso puede tardar según el sistema - verifique previamente horarios de atención en nuestro listado de centros de lubricación para reclamar sus productos</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['producto'],
        data() {
            return {
                sucursal: '',
                image: '',
                modalShow: false
            }
        },
        methods: {
            showModal() {
                this.modalShow = true;
            }
        },
        watch: {
            sucursal( sucursal ) {
                const params = {
                    sirvea_id: this.producto.sirvea_id,
                    sucursal: sucursal,
                    iva_porcentaje: this.producto.iva_porcentaje
                }

                this.$emit('prepare', params);

                axios.get('api/sucursales', {params})
                    .then(resp => {
                        this.image = resp.data.image;
                        this.modalShow = true;
                    });
            }
        }
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
