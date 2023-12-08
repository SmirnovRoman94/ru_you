import {createRouter, createWebHistory} from "vue-router";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/login',
            component: () => import('./components/Login.vue'),
            name: 'user.login'
        },
        {
            path: '/registration',
            component: () => import('./components/Registration.vue'),
            name: 'user.registration'
        },
        {
            path: '/personal',
            component: () => import('./components/Personal.vue'),
            name: 'user.personal'
        },
        {
            path: '/:catchAll(.*)',
            component: () => import('./components/NotFound.vue'),
            name: '404'
        }
    ]
});

router.beforeEach((to, from, next) => {
    const token = localStorage.access_token;
    if(!token){
        if(to.name === 'user.login' || to.name === 'user.registration'){
            return next()
        }else{
            return next({
                name: 'user.login'
            })
        }
    }

    if(to.name === 'user.login' || to.name === 'user.registration' && token){
        return next({
            name: 'user.personal'
        })
    }

    next()
})

export default router
