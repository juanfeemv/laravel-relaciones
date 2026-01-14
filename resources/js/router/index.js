import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '../stores/auth'
import Login from '../views/Login.vue'
import DashboardLayout from '../layouts/DashboardLayout.vue'
import Home from '../views/Home.vue'
import Users from '../views/Users.vue'
import Profiles from '../views/Profiles.vue'
import Posts from '../views/Posts.vue'
import Categories from '../views/Categories.vue'
import Tags from '../views/Tags.vue'
const routes = [
{ path: '/login', component: Login, meta: { guestOnly: true,
title: 'Login' } },
{
path: '/',
component: DashboardLayout,
meta: { requiresAuth: true },
children: [
{ path: '', component: Home, meta: { title: 'Dashboard' } },
{ path: 'users', component: Users, meta: { title: 'Users' }
},
{ path: 'profiles', component: Profiles, meta: { title:
'Profiles' } },
{ path: 'posts', component: Posts, meta: { title: 'Posts' }
},
{ path: 'categories', component: Categories, meta: { title:
'Categories' } },
{ path: 'tags', component: Tags, meta: { title: 'Tags' } },
],
},
]
const router = createRouter({
history: createWebHistory(),
routes,
})
router.beforeEach(async (to) => {
const auth = useAuthStore()
if (auth.token && !auth.user) {
await auth.me()
}
if (to.meta.requiresAuth && !auth.isAuthenticated) return
'/login'
if (to.meta.guestOnly && auth.isAuthenticated) return '/'
})
export default router