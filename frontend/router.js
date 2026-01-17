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
      { path: 'statistics', name: 'member-stats', component: () => import('@/views/member/Statistics.vue') },
      { path: 'bills', name: 'member-bills', component: () => import('@/views/member/Bills.vue') },
      { path: 'tutorial', name: 'member-tutorial', component: () => import('@/views/member/Tutorial.vue') },
      { path: 'profile', name: 'member-profile', component: () => import('@/views/member/Profile.vue') },
      { path: 'page-builder', name: 'member-page-builder', component: () => import('@/views/member/PageBuilder.vue') },
      { path: 'page-builder/:id', name: 'member-page-builder-edit', component: () => import('@/views/member/PageBuilder.vue') },
    ]
  },
  {
    path: '/admin',
    component: () => import('@/layouts/AdminLayout.vue'),
    children: [
      { path: '', redirect: '/admin/dashboard' },
      { path: 'dashboard', name: 'admin-dashboard', component: () => import('@/views/admin/Dashboard.vue') },
      { path: 'users', name: 'admin-users', component: () => import('@/views/admin/users/Index.vue') },
      { path: 'users/create', name: 'admin-users-create', component: () => import('@/views/admin/users/Form.vue') },
      { path: 'users/:id/edit', name: 'admin-users-edit', component: () => import('@/views/admin/users/Form.vue') },
      { path: 'pages', name: 'admin-pages', component: () => import('@/views/admin/Pages.vue') },
      { path: 'faq', name: 'admin-faq', component: () => import('@/views/admin/Faq.vue') },
      { path: 'plans', name: 'admin-plans', component: () => import('@/views/admin/plans/Index.vue') },
      { path: 'plans/create', name: 'admin-plans-create', component: () => import('@/views/admin/plans/Form.vue') },
      { path: 'plans/:id/edit', name: 'admin-plans-edit', component: () => import('@/views/admin/plans/Form.vue') },
      { path: 'transactions', name: 'admin-transactions', component: () => import('@/views/admin/transactions/Index.vue') },
      { path: 'transactions/:id/edit', name: 'admin-transactions-edit', component: () => import('@/views/admin/transactions/Form.vue') },
      { path: 'notifications', name: 'admin-notifications', component: () => import('@/views/admin/Notifications.vue') },
      { path: 'profile', name: 'admin-profile', component: () => import('@/views/admin/Profile.vue') },
      { path: 'settings', name: 'admin-settings', component: () => import('@/views/admin/Settings.vue') },
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