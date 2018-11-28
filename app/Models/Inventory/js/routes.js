import FilterView from './components/views/filters/FilterView'
import HomeView from './components/views/home/HomeView'
import SearchView from './components/views/home/SearchView'
import ProductHome from './components/views/home/ProductHome'
import ProductView from './components/views/home/ProductView'
import AccessView from './components/views/home/AccessView'

Vue.use(VueRouter)

export default new VueRouter({
    linkActiveClass: "active",
    routes: [{
            path: '/',
            component: FilterView
        },
        {
            path: '/home',
            component: HomeView,
            children: [
                {
                    path: '/',
                    name: 'home',
                    component: SearchView
                },
                {
                    path: 'product',
                    component: ProductHome,
                    props: (route) => ({ query: route.query.q }),
                    children: [{
                            path: '/',
                            name: 'product',
                            component: ProductView
                        },
                        {
                            path: 'access',
                            name: 'access',
                            component: AccessView,
                            props: true,
                    }]
                }
            ]
        }
    ]
})
