import Vue from 'vue'
import VueRouter from 'vue-router'
import Store from './store'

import page from './page'
import home from './pages/Home'
import about from './pages/About'
import signin from './pages/SignIn'
import register from './pages/Register'
import dashboard from './pages/Dashboard'
import account from './pages/Account'
import profile from './pages/Profile'
import posts from './pages/Posts'
import page404 from './components/404'
import author from './components/Author'

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    // base: process.env.BASE_URL,
    routes: [
        {
            path: "*",
            redirect: "/"
        },
        {
            path: "/",
            component: page,
            children: [
                {
                    path: "/",
                    name: 'home',
                    component: home
                },
                {
                    path: "about",
                    name: 'about',
                    component: about
                },
                {
                    path: 'register',
                    name: 'register',
                    component: register,
                    beforeEnter(to, from, next) {
                        if (Store.getters['auth/authenticated']) {
                            next('/dashboard');
                        } else {
                            next()    
                        }
                    }
                },
                {
                    path: 'signin',
                    name: 'signin',
                    component: signin,
                    beforeEnter(to, from, next) {
                        if (Store.getters['auth/authenticated']) {
                            next('/dashboard');
                        } else {
                            next()    
                        }
                    }
                },
                {
                    path: "account",
                    name: 'account',
                    component: account,
                    meta: {
                        auth: true
                    }
                },
                {
                    path: "posts",
                    name: 'posts',
                    component: posts
                },
                {
                    path: "/404",
                    name: 'notfound',
                    component: page404
                },
                {
                    path: "/author",
                    name: 'author',
                    component: author
                },,
                {
                    path: ":fullname",
                    component: profile,
                    beforeEnter(to, from, next) {
                        // let fullName = to.params.fullname.split('.')
                        // // let requestPath = Store.state.auth.token ? 'user/getInfo' : 'user/getPublic';

                        // for (let i = 0; i < fullName.length; i++) {
                        //     fullName[i] = fullName[i].replace(/-/g," ");
                        // }

                        // switch (fullName.length) {
                        //     case 2: 
                        //         Store.dispatch('user/getInfo', {
                        //             first_name: fullName[0],
                        //             last_name: fullName[fullName.length-1]
                        //         })
                        //         .then(()=>{
                        //             next()
                        //         })
                        //         break;
                        //     case 3:
                        //         Store.dispatch('user/getInfo',{
                        //             first_name: fullName[0],
                        //             middle_name: fullName[1],
                        //             last_name: fullName[fullName.length-1]
                        //         })
                        //         .then(()=>{
                        //             next()
                        //         })
                        //         break;
                        //     default:
                                next()
                        //         break;
                        // }
                    }
                },
                // {
                //     path: ":random",
                //     component: page404,
                //     beforeEnter(to, from, next) { 
                //         next({name: 'routeCatcher', params: {fullname: to.params.random }})
                //     }
                //     // redirect: { name: 'routeCatcher', params: {fullName: this.$route.params.slug } }
                // }
            ]
        }
    ]
})

router.beforeEach((to, from, next) => {
    // console.log(Store.getters['auth/authenticated'].username);
    let user = Store.getters['auth/authenticated'];    
    if (to.meta.auth && !user) {
        next({
            name: 'signin'
        })
    } else {
        next()
    }
});

export default router