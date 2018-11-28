<template>
    <div>
        <div class="banner mx-auto mb-3"></div>
        <div class="row container-lineas">
            <div class="col-sm-4 panel-lineas">
                <router-link to="/home" tag="a" exact>
                    <div class="header-lineas d-flex justify-content-center m-auto">
                        <img src="images/gota.png" class="align-items-center align-self-center" alt="Lubricantes">
                    </div>
                    <div class="body-lineas">
                        <h5>LUBRICANTES <br> AUTOMOTRICES</h5>
                        <p>ENCUENTRE AQUÍ EL LUBRICANTE PARA SU VEHÍCULO LUBRICANTES DE ALTA CALIDAD 100% ORIGINALES COMPRE EN LÍNEA DE FORMA 100% SEGURA</p>
                        <img src="images/payu.png" alt="PayU">
                        <p>RECLAME O INSTALE EN NUESTRA RED DE CENTROS DE LUBRICACIÓN MAS CERCANA A USTED</p>
                    </div>
                </router-link>
            </div>
            <div class="col-sm-4 panel-lineas">
                <router-link to="/">
                    <div class="header-lineas d-flex justify-content-center m-auto">
                        <img src="images/truk.png" class="align-self-center" alt="Repuestos">
                    </div>
                    <div class="body-lineas">
                        <h5>REPUESTOS <br> MAQUINARIA AMARILLA </h5>
                        <p>ENCUENTRE AQUÍ REPUESTOS DE RODAJE Y DESGASTE PARA TODO TIPO DE MARCA Y MAQUINARIA AMARILLA COMPRE EN LÍNEA DE FORMA 100% SEGURA</p>
                        <img src="images/payu.png" alt="PayU">
                        <p>SERVICIO DE ENTREGA A DOMICILIO</p>
                    </div>
                </router-link>
            </div>
            <div class="col-sm-4 panel-lineas">
                <router-link to="/">
                    <div class="header-lineas d-flex justify-content-center m-auto">
                        <img src="images/filtro.png" class="align-self-center" alt="Fitlracion">
                    </div>
                    <div class="body-lineas">
                        <h5>LÍNEA DE <br> FILTRACIÓN</h5>
                        <p>ENCUENTRE AQUÍ LOS FILTROS QUE REQUIERE SU VEHÍCULO FILTROS DE ALTA CALIDAD 100% ORIGINALES COMPRE DE FORMA 100% SEGURA</p>
                        <img src="images/payu.png" alt="PayU">
                        <p>SERVICIO DE ENTREGA A DOMICILIO</p>
                    </div>
                </router-link>
            </div>
        </div><br>

        <div class="row">
            <div class="col-sm-6 offset-sm-3">
                <h5 class="footer-text">GRACIAS A SU COMPRA APOYAMOS PROYECTOS DE EDUCACIÓN <br>EN LUGARES DE ALTA VULNERABILIDAD EN COLOMBIA</h5>
            </div>
        </div>
    </div>
</template>

<script>
    export default { }
</script>

<style scoped>
    .banner {
        background: url("/tienda/public/images/logo.png") no-repeat;
        background-size: cover;
        height: 149px;
        max-width: 592px;
        width: 100%;
    }

    a {
        text-decoration: none;
    }

    .panel-lineas {
        padding: 1.5rem;
        border-right: 2px solid #32546C;
        transition: 0.5s;
    }

    .footer-text {
        border: 2px solid #32546C;
        border-radius: 1rem;
        text-align: center;
        font-weight: bold;
    }

    .panel-lineas:last-child, .panel-lineas:last-child:hover{
        border-right: none;
    }

    .panel-lineas:hover  {
        background: #F1F4F7;
        box-shadow: 0px 0px 15px 5px #E2E2E2;
        border: 1px solid black;
        border: none;
    }

    .header-lineas {
        background: #438798;
        border: 4px solid #e2e2e2;
        height: 90px;
        width: 90px;
        border-radius: 50%;
    }

    .body-lineas  h5 {
        font-weight: bold;
        border: 4px solid #e2e2e2;
        border-radius: 1rem;
        background: #32546c;
        color: #fff;
    }

    .body-lineas p {
        color: #32546c;
    }

    #app .main-footer {
        background-color: red;
    }
</style>
