import { useAuthStore } from '@/stores/auth'
import api from '@/utils/axios'
import NProgress from 'nprogress'
import 'nprogress/nprogress.css'

// Konfigurasi NProgress
NProgress.configure({ showSpinner: false })

let isFirstLoad = true

export const authMiddleware = async (to, from, next) => {
	const authStore = useAuthStore()
	
	// 1. Ambil meta data rute
	const requiresAuth = to.matched.some(record => record.meta.requiresAuth)
	const isGuestOnly = to.matched.some(record => record.meta.guestOnly)

	// 2. Jika user memiliki token, coba perbarui data profil dari API
	if (authStore.token) {
		const fetchProfile = async () => {
			try {
				const response = await api.get('/profile')
				if (response.data?.status || response.data?.code === 0) {
					// Update data user di store (menggunakan data terbaru dari DB)
					authStore.updateUser(response.data.data)
				}
			} catch (error) {
				console.error('Failed to sync profile:', error)
			}
		}

		if (isFirstLoad) {
			// Saat pertama kali buka aplikasi, tunggu respon API (Blocking)
			await fetchProfile()
			isFirstLoad = false
		} else {
			// Perpindahan halaman selanjutnya, jalankan loading bar
			NProgress.start()
			fetchProfile().finally(() => {
				NProgress.done()
			})
		}
	}

	// 3. Logika Proteksi Rute
	if (requiresAuth && !authStore.isAuthenticated) {
		// Butuh login tapi belum login
		return next({ name: 'login' })
	}

	if (isGuestOnly && authStore.isAuthenticated) {
		// Halaman guest tapi sudah login
		const redirectPath = authStore.user?.role === 'admin' ? '/admin/dashboard' : '/member/dashboard'
		return next(redirectPath)
	}

	if (requiresAuth && to.meta.role && authStore.user?.role !== to.meta.role) {
		// Salah role (Admin masuk Member atau sebaliknya)
		const fallbackPath = authStore.user?.role === 'admin' ? '/admin/dashboard' : '/member/dashboard'
		return next(fallbackPath)
	}

	// Lanjut ke halaman tujuan
	next()
}
