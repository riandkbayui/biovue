import axios from 'axios'
import env from '@/env.js'
import router from '@/router.js'

// Buat instance axios
const api = axios.create({
	baseURL: env.apiUrl,
	timeout: 10000,
	headers: {
		'Content-Type': 'application/json',
		'Accept': 'application/json'
	}
})

// Request Interceptor: Tambahkan Bearer Token dari LocalStorage
api.interceptors.request.use(
	(config) => {
		const token = localStorage.getItem('token')
		if (token) {
			config.headers.Authorization = `Bearer ${token}`
		}
		return config
	},
	(error) => {
		return Promise.reject(error)
	}
)

// Response Interceptor: Tangani redirect jika sesi habis (401)
api.interceptors.response.use(
	(response) => {
		return response
	},
	(error) => {
		// Jika status 401 (Unauthorized) atau pesan error menunjukkan sesi habis
		if (error.response && (error.response.status === 401 || error.response.data?.message === 'no session')) {
			// Hapus token yang mungkin sudah expired
			localStorage.removeItem('token')
			localStorage.removeItem('user')

			// Redirect ke halaman login
			router.push('/login')
		}
		return Promise.reject(error)
	}
)

export default api
