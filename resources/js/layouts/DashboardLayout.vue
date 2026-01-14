<script setup>
//definir valores reactivos derivados
import { computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
//importa el store de Pinia
import { useAuthStore } from '../stores/auth'
const route = useRoute()
const router = useRouter()
const auth = useAuthStore()
//definición del menú
const links = [
    { label: 'Home', to: '/' },
    { label: 'Users', to: '/users' },
    { label: 'Profiles', to: '/profiles' },
    { label: 'Posts', to: '/posts' },
    { label: 'Categories', to: '/categories' },
    { label: 'Tags', to: '/tags' },
]
//saber qué ruta está activa y marcarla en el menú
const activePath = computed(() => route.path)
const doLogout = async () => {
    await auth.logout()
    router.replace('/login')
}
</script>
<template>
    <div class="layout">
        <aside class="sidebar">
            <div class="brand">Blog Admin</div>
            <nav class="nav">
                <router-link v-for="l in links" :key="l.to" :to="l.to" class="nav-link"
                    :class="{ active: activePath === l.to }">
                    {{ l.label }}
                </router-link>
            </nav>
            <div class="sidebar-footer">
                <div v-if="auth.user" class="user">
                    <div class="user-name">{{ auth.user.name }}</div>
                    <div class="user-email">{{ auth.user.email }}</div>
                </div>
                <button class="btn" @click="doLogout">Logout</button>
            </div>
        </aside>
        <main class="main">
            <header class="topbar">
                <h1 class="title">{{ route.meta.title ?? 'Dashboard'
                }}</h1>
            </header>
            <section class="content">
                <router-view />
            </section>
        </main>
    </div>
</template>
<style scoped>
.layout {
    display: flex;
    min-height: 100vh;
    font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial,
        sans-serif;
}

/* Sidebar */
.sidebar {
    width: 260px;
    background: #111827;
    /* gris oscuro */
    color: #e5e7eb;
    display: flex;
    flex-direction: column;
}

.brand {
    padding: 18px 16px;
    font-weight: 700;
    letter-spacing: 0.4px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
}

.nav {
    padding: 12px 8px;
    display: flex;
    flex-direction: column;
    gap: 4px;
    flex: 1;
}

.nav-link {
    padding: 10px 12px;
    border-radius: 8px;
    color: inherit;
    text-decoration: none;
    opacity: 0.9;
}

.nav-link:hover {
    background: rgba(255, 255, 255, 0.08);
    opacity: 1;
}

.nav-link.active {
    background: rgba(255, 255, 255, 0.14);
}

/* Footer */
.sidebar-footer {
    padding: 12px 12px 16px 12px;
    border-top: 1px solid rgba(255, 255, 255, 0.08);
}

.user {
    margin-bottom: 10px;
}

.user-name {
    font-weight: 600;
}

.user-email {
    font-size: 12px;
    opacity: 0.8;
}

.btn {
    width: 100%;
    padding: 10px 12px;
    border: 0;
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.14);
    color: #fff;
    cursor: pointer;
}

.btn:hover {
    background: rgba(255, 255, 255, 0.22);
}

/* Main */
.main {
    flex: 1;
    background: #f3f4f6;
    color: #111827;
    display: flex;
    flex-direction: column;
}

.topbar {
    background: #fff;
    padding: 14px 18px;
    border-bottom: 1px solid #e5e7eb;
}

.title {
    margin: 0;
    font-size: 18px;
}

.content {
    padding: 18px;
}
</style>