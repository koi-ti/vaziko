<template>
    <div>
        <div class="background-content">
            <form @submit.prevent="searchProducts">
                <div class="row">
                    <div class="col-12 col-sm-8 col-md-6 col-lg-4 mt-sm-2 ml-sm-3"><br>
                        <h5><b>BUSCADOR PRODUCTO</b></h5>
                        <label for="control-label"><b>ENCUENTRE EL LUBRICANTE PARA SU VEHÍCULO</b></label>
                        <div class="form-group">
                            <select class="form-control" v-model="filtervehiculo" required>
                                <option value selected hidden disabled>Seleccione el tipo de vehiculos</option>
                                <option v-for="vehiculo in vehiculos" :value="vehiculo.id">{{ vehiculo.name }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-8 col-md-6 col-lg-4 ml-sm-3">
                        <div class="form-group has-feedback has-error">
                            <select class="form-control" v-model="filtermarca" required>
                                <option value selected hidden disabled>Selecciones el tipo de marca</option>
                                <option v-for="marca in marcas" :value="marca.id">{{ marca.name }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-8 col-md-6 col-lg-4 ml-sm-3">
                        <div class="form-group">
                            <select class="form-control" v-model="filtermodelo" required>
                                <option value selected hidden disabled>Selecciones el tipo de modelo</option>
                                <option v-for="modelo in modelos" :value="modelo.id">{{ modelo.name }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-8 col-md-6 col-lg-4 ml-sm-3">
                        <div class="form-group">
                            <select class="form-control" v-model="filterkilometraje" required>
                                <option value selected hidden disabled>Kilometraje</option>
                                <option v-for="kilometraje in kilometrajes" :value="kilometraje.range">{{ kilometraje.name }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-8 col-md-6 col-lg-4 ml-sm-3">
                        <button type="submit" class="btn btn-block btn-outline-primary">
                            Buscar...
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                filtervehiculo: '',
                vehiculos: [],
                filtermarca: '',
                marcas: [],
                filtermodelo: '',
                modelos: [],
                filterkilometraje: '',
                kilometrajes: [
                    {range: 1, name:'0 - 20.000'},
                    {range: 2, name:'50.000 km en adelante'}
                ]
            }
        },
        mounted() {
            this.initialize();
        },
        methods: {
            initialize() {
                axios.get('api/vehiculos')
                    .then(response => {
                        this.vehiculos = response.data
                    });
            },

            searchProducts() {
                const params = {
                        modelo: this.filtermodelo,
                        kilometraje: this.filterkilometraje
                }

                this.$router.push({name: 'product', query: params});
            }
        },
        watch: {
            filtervehiculo(vehiculo) {
                const params = { vehiculo: vehiculo }

                this.filtermarca = '';
                this.marcas = [];
                this.filtermodelo = '';
                this.modelos = [];

                axios.get('api/marcas', {params})
                    .then(response => {
                        if(response.data.length)
                            this.marcas = response.data
                    });
            },

            filtermarca(marca) {
                // Si existe la marca continue
                if( !marca )
                    return

                const params = { marca: marca }
                this.filtermodelo = '';
                this.modelos = [];

                axios.get('api/modelos', {params})
                    .then(response => {
                        if(response.data.length)
                            this.modelos = response.data
                    });
            }
        }
    }
</script>

<style scoped>
    .background-content {
        background: url('/tienda/public/images/bg_content.png');
        background-size: cover;
        height: 446px;
        width: 100%;
    }

    button {
        border-radius: 8px;
    }
</style>
