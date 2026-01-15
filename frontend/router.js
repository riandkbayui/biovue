import { createRouter, createWebHistory } from 'vue-router'
import HelloWorld from '@/components/HelloWorld.vue'
import Login from '@/views/Login.vue' // Import the login component

const routes = [
  { path: '/', name: 'home', component: () => import('@/views/Home.vue') },
  { path: '/login', name: 'login', component: Login },
  { path: '/register', name: 'register', component: () => import('@/views/Register.vue') },
  { path: '/about', name: 'about', component: () => import('@/views/About.vue') },
  { path: '/blog', name: 'blog', component: () => import('@/views/Blog.vue') },
  { path: '/contact', name: 'contact', component: () => import('@/views/Contact.vue') },
  { path: '/privacy', name: 'privacy', component: () => import('@/views/Privacy.vue') },
  { path: '/terms', name: 'terms', component: () => import('@/views/Terms.vue') },
  { path: '/forgot-password', name: 'forgot-password', component: () => import('@/views/ForgotPassword.vue') },
  { path: '/reset-password', name: 'reset-password', component: () => import('@/views/ResetPassword.vue') },
  {
    path: '/member',
    component: () => import('@/layouts/MemberLayout.vue'),
    children: [
      { path: '', redirect: '/member/dashboard' },
      { path: 'dashboard', name: 'member-dashboard', component: () => import('@/views/member/Dashboard.vue') },
      { path: 'my-pages', name: 'member-pages', component: () => import('@/views/member/MyPages.vue') },
      { path: 'statistics', name: 'member-stats', component: () => import('@/views/member/Placeholder.vue') },
      { path: 'bills', name: 'member-bills', component: () => import('@/views/member/Placeholder.vue') },
      { path: 'tutorial', name: 'member-tutorial', component: () => import('@/views/member/Placeholder.vue') },
      { path: 'profile', name: 'member-profile', component: () => import('@/views/member/Placeholder.vue') },
      { path: 'page-builder', name: 'member-page-builder', component: () => import('@/views/member/PageBuilder.vue') },
      { path: 'page-builder/:id', name: 'member-page-builder-edit', component: () => import('@/views/member/PageBuilder.vue') },
    ]
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (to.hash) {
      return {
        el: to.hash,
        behavior: 'smooth',
      }
    }
    return { top: 0 }
  }
})

export default router