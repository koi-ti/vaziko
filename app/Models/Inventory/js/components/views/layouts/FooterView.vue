<template>
    <div>
        <div class="banner-marcas"></div>
        <div class="d-flex justify-content-end text-white text-center">
            <div class="p-2 contactus">
                <p>
                    <b>
                        Calle 94 No 72a-51<br>
                        (57)313-5977058)<br>
                        servicioalcliente@soligem.com<br>
                        Bogotá - Colombia<br>
                    </b>
                </p>
            </div>
            <div class="p-2 socialnetwork">
                <b>Síguenos en:<br></b>
                <i class="fa fa-facebook-official fa-2x"></i>
                <i class="fa fa-youtube-square fa-2x"></i>
                <i class="fa fa-instagram fa-2x"></i>
                <i class="fa fa-twitter-square fa-2x"></i>
            </div>
        </div>
    </div>
</template>

<script>
    export default { }
</script>

<style scoped>
    @media screen and (min-width: 554px) {
        .banner-marcas {
            background-image: url("/tienda/public/images/marcas/logos.jpg");
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
            height: 35px;
            width: 100%;
        }
    }

    div {
        background: #25516B;
        font-size: 10px;
    }

    .contactus {
        border-right: 2px solid white;
        margin: 0 10px;
    }

    .socialnetwork {
        margin: 0 10px 0 0;
    }
</style>
