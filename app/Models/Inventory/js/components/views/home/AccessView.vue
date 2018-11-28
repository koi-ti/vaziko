<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-sm-8 offset-sm-4">
                <div class="form-group col-sm-6">
                    <label class="control-label">Ingrese su documento</label>
                    <input type="text" v-model="usuario.documento" placeholder="Documento" class="form-control" maxlength="10" required @change="changeDocumento">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card card-default">
                    <form @submit.prevent="submitForm" class="needs-validation">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <input type="text" placeholder="Nombres" class="" class="form-control" :class="{'is-invalid': isValidNames}" maxlength="100" required v-model="usuario.names">
                                    <div class="invalid-feedback">{{ isValidNames }}</div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <input type="text" placeholder="Apellidos" class="form-control" :class="{'is-invalid': isValidLastNames}" maxlength="100" required v-model="usuario.last_names">
                                    <div class="invalid-feedback">{{ isValidLastNames }}</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <div class="input-group">
                                        <input type="email" placeholder="Correo" class="form-control" :class="{'is-invalid': isValidEmail}" required v-model="usuario.email">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-at"></i></span>
                                        </div>
                                        <div class="invalid-feedback">{{ isValidEmail }}</div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <input type="text" placeholder="Dirección" class="form-control" :class="{'is-invalid': isValidAddress}" maxlength="200" required v-model="usuario.address">
                                    <div class="invalid-feedback">{{ isValidAddress }}</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <div class="input-group">
                                        <input type="text" placeholder="Teléfono fijo" class="form-control" :class="{'is-invalid': isValidPhone}" maxlength="7" required v-model="usuario.phone">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                        </div>
                                        <div class="invalid-feedback">{{ isValidPhone }}</div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <div class="input-group">
                                        <input type="text" placeholder="Teléfono celular" class="form-control" :class="{'is-invalid': isValidCellPhone}" maxlength="10" required v-model="usuario.cell_phone">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-mobile"></i></span>
                                        </div>
                                        <div class="invalid-feedback">{{ isValidCellPhone }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2 offset-sm-5">
                                    <button type="submit" class="btn btn-block btn-primary">Facturar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                &nbsp;
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                usuario: {
                    names: '',
                    last_names: '',
                    documento: '',
                    email: '',
                    address: '',
                    phone: '',
                    cell_phone: ''
                },
                errors: false
            }
        },
        mounted() {
            // Validar que contenga params
            if( !this.$route.params.producto ) return this.$router.go(-1);
        },
        computed: {
            isValidNames() {
                var value = this.usuario.names;
                if( value == ''){
                    this.errors = true;
                    return "El campo de nombres es requerido."
                }
            },
            isValidLastNames() {
                var value = this.usuario.last_names;
                if( value == ''){
                    this.errors = true;
                    return "El campo de apellidos es requerido."
                }
            },
            isValidEmail() {
                var value = this.usuario.email;
                if( value == ''){
                    this.errors = true;
                    return "El campo de correo es requerido."
                }
            },
            isValidAddress() {
                var value = this.usuario.address;
                if( value == ''){
                    this.errors = true;
                    return "El campo de dirección es requerido."
                }
            },
            isValidPhone() {
                var value = this.usuario.phone;
                if( value == ''){
                    this.errors = true;
                    return "El campo de teléfono es requerido."
                }
                if ( value.length < 7) {
                    this.errors = true;
                    return "El campo de teléfono no es valido.";
                }

                if( !$.isNumeric(value) ) {
                    this.errors = true;
                    return "El campo de teléfono no es valido.";
                }
            },
            isValidCellPhone() {
                var value = this.usuario.cell_phone;
                if( value == ''){
                    this.errors = true;
                    return "El campo de teléfono movil es requerido."
                }
                if ( value.length < 10) {
                    this.errors = true;
                    return "El campo de teléfono movil no es valido.";
                }

                if( !$.isNumeric(value) ) {
                    this.errors = true;
                    return "El campo de teléfono movil no es valido.";
                }
            }
        },
        methods: {
            changeDocumento() {
                const params = {
                    documento: this.usuario.documento
                }

                axios.get('api/usuarios', {params})
                .then(resp => {
                    this.errors = resp.data.success;

                    if( !resp.data.success ){
                        this.usuario.names = '';
                        this.usuario.last_names = '';
                        this.usuario.email = '';
                        this.usuario.address = '';
                        this.usuario.phone = '';
                        this.usuario.cell_phone = '';
                        return toastr.warning(resp.data.error);
                    }

                    this.usuario.names = resp.data.usuario.names;
                    this.usuario.last_names = resp.data.usuario.last_names;
                    this.usuario.email = resp.data.usuario.email;
                    this.usuario.address = resp.data.usuario.address;
                    this.usuario.phone = resp.data.usuario.phone;
                    this.usuario.cell_phone = resp.data.usuario.cell_phone;
                });
            },

            submitForm() {
                // Validate form
                if( !this.errors ){
                    return toastr.error("Verifique la información del formulario.");
                }

                const data = $.extend({}, this.$route.params, this.usuario);

                axios.post('api/usuarios', {data})
                    .then(resp => {
                        if( !resp.data.success )
                            return toastr.error( resp.data.errors )

                        toastr.success( resp.data.msg );
                        this.$router.push( {name: 'home'} );
                    })
                    .catch(e => {
                        return toastr.error( resp.data.errors )
                    });
            }
        },
    }
</script>
