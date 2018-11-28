<template>
    <div>
        <div class="container-banner">
            <ul class="list-unstyled m-2 pull-right">
                <li><a href="#"><img src="images/filtro_bann.png"></a></li>
                <li><a href="#"><img src="images/gota_bann.png"></a></li>
                <li><a href="#"><img src="images/truk_bann.png"></a></li>
            </ul>
        </div>

        <nav class="navbar navbar-expand-lg navbar-dark header-nav">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <router-link to="/home" tag="li" class="nav-item" exact>
                        <a class="nav-link"><strong>Home</strong></a>
                    </router-link>
                    <router-link to="/about-us" tag="li" class="nav-item">
                        <a class="nav-link"><strong>Nosotros</strong></a>
                    </router-link>
                    <router-link to="/brands" tag="li" class="nav-item">
                        <a class="nav-link"><strong>Marcas</strong></a>
                    </router-link>
                    <router-link to="/centers" tag="li" class="nav-item">
                        <a class="nav-link"><strong>Centros de lubricación</strong></a>
                    </router-link>
                    <router-link to="/promotions" tag="li" class="nav-item">
                        <a class="nav-link"><strong>Promociones</strong></a>
                    </router-link>
                    <router-link to="/politics" tag="li" class="nav-item">
                        <a class="nav-link"><strong>Politica de Apoyo Social</strong></a>
                    </router-link>
                    <router-link to="/terms" tag="li" class="nav-item">
                        <a class="nav-link"><strong>Términos y Condiciones</strong></a>
                    </router-link>
                    <router-link to="/contact-us" tag="li" class="nav-item">
                        <a class="nav-link"><strong>Contáctenos</strong></a>
                    </router-link>
                </ul>
            </div>
        </nav>
    </div>
</template>

<script>
    export default { }
</script>

<style scoped>
    .container-banner {
        background-image: url("/tienda/public/images/header.jpg");
        background-repeat: no-repeat;
        background-size: 100% 170px;
        height: 170px;
        width: 100%;
    }

    .header-nav {
        background: #39526E;
    }

    .header-nav li:hover {
        background: #fff;
    }

    .header-nav li a:hover, .header-nav li.active a.nav-link{
        color: #000 !important;
    }

    .header-nav li.active {
        background: #fff;
    }

    .header-nav li:last-child {
        border: none;
    }

    @media screen and (min-width: 992px) {
        .header-nav li {
            transform: skew(25deg);
            border-right: 2px solid white;
        }

        .header-nav li:hover {
            background: #fff;
            transform: skew(25deg);
        }

        .header-nav li a {
            transform: skew(-25deg);
            font-size: 13px;
            text-transform: uppercase;
        }
    }
</style>
