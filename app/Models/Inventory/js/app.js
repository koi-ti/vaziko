import Layout from './components/views/layouts/LayoutView'
import router from './routes'
import BootstrapVue from 'bootstrap-vue'

Vue.use(BootstrapVue);
Vue.config.productionTip = false
Vue.config.devtools = false

const app = new Vue({
    el: '#app',
    router,
    render: h => h(Layout)
});
