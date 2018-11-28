<template>
    <div class="container">
        <Header/>
        <router-view></router-view>
        <Footer/>
    </div>
</template>

<script>
    import Header from './HeaderView'
    import Footer from './FooterView'

    export default {
        components: { Header, Footer }
    }
</script>
