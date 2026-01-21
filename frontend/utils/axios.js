import axios from 'axios'
import env from '@/env.js'
import router from '@/router.js'

// Buat instance axios
const api = axios.create({
	baseURL: env.apiUrl,
	timeout: 10000,
	headers: {
		'Accept': 'application/json'
	}
})

// Helper untuk konversi objek ke FormData (mendukung nested object/array)
const toFormData = (obj, form, namespace) => {
	const fd = form || new FormData()
	let formKey

	for (const property in obj) {
		if (Object.prototype.hasOwnProperty.call(obj, property)) {
			if (namespace) {
				formKey = namespace + '[' + property + ']'
			} else {
				formKey = property
			}

			// Jika property adalah objek dan bukan File, lakukan rekursi
			if (typeof obj[property] === 'object' && !(obj[property] instanceof File) && obj[property] !== null) {
				toFormData(obj[property], fd, formKey)
			} else {
				// Jika null, kirim string kosong atau abaikan (tergantung kebutuhan backend)
				fd.append(formKey, obj[property] === null ? '' : obj[property])
			}
		}
	}
	return fd
}

// Request Interceptor: Tambahkan Bearer Token & Konversi ke FormData untuk POST
api.interceptors.request.use(
	(config) => {
		const token = localStorage.getItem('token')
		if (token) {
			config.headers.Authorization = `Bearer ${token}`
		}

		// Otomatis ubah POST data menjadi FormData
		if (config.method === 'post' && config.data && !(config.data instanceof FormData)) {
			config.data = toFormData(config.data)
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
