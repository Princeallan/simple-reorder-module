import {createRouter, createWebHistory} from 'vue-router';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            component: () => import('./pages/auth/Login.vue')
        },
        {
            path: '/home',
            props: true,
            component: () => import('./pages/Home.vue')
        },
        {
            path: '/orders',
            component: () => import('./pages/OrderList.vue')
        },
        {
            path: '/pending-orders',
            component: () => import('./pages/PendingReOrders.vue')
        },
        {
            path: '/fulfilled-orders',
            component: () => import('./pages/FulfilledReOrders.vue')
        },
        {
            path: '/create-product',
            name: 'create-product',
            props: true,
            component: () => import('./pages/CreateProduct.vue')
        },
        {
            path: '/product/edit/:id',
            name: 'edit-product',
            props: true,
            component: () => import('./pages/EditProduct.vue')
        }
    ],
})
router.beforeEach((to, from, next) => {
    if (to.path !== '/' && !isAuthenticated()) {
        return next({path: '/'})
    }
    return next()
})

function isAuthenticated() {
    return Boolean(localStorage.getItem('APP_USER_TOKEN'))
}

export default router;
