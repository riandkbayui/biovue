import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import api from '@/utils/axios'

const createDefaultUser = () => ({
	id: null,
	name: '',
	username: '',
	email: '',
	role: 'member',
	photo: '',
	created_at: null
})

export const useAuthStore = defineStore('auth', () => {
	// State
	const user = ref(JSON.parse(localStorage.getItem('user')) || createDefaultUser())
	const token = ref(localStorage.getItem('token') || null)

	// Getters
	const isAuthenticated = computed(() => !!token.value && !!user.value.id)
	const userData = computed(() => user.value)

	// Actions
	const setAuth = (newUserData, newToken) => {
		user.value = { ...createDefaultUser(), ...newUserData }
		token.value = newToken

		localStorage.setItem('user', JSON.stringify(user.value))
		localStorage.setItem('token', newToken)
	}

	const clearAuth = () => {
		user.value = createDefaultUser()
		token.value = null

		localStorage.removeItem('user')
		localStorage.removeItem('token')
	}

	const updateUser = (newUserData) => {
		user.value = { ...user.value, ...newUserData }
		localStorage.setItem('user', JSON.stringify(user.value))
	}

    // API Actions
    const login = async (credential, password) => {
        try {
            const response = await api.post('/auth/login', { credential, password })
            const { data, success } = response.data
            
            if (success) {
                setAuth(data.user, data.token)
                return { success: true }
            }
            return { success: false, message: response.data.message }
        } catch (error) {
            return { 
                success: false, 
                message: error.response?.data?.messages?.error || error.response?.data?.message || 'Terjadi kesalahan saat login.' 
            }
        }
    }

    const register = async (formData) => {
        try {
            const response = await api.post('/auth/register', formData)
            return response.data // { success: true/false, message: ... }
        } catch (error) {
            // CI4 validation errors usually come in `messages` object inside response
            const errors = error.response?.data?.messages || {}
            // If it's a simple message
            const message = error.response?.data?.messages?.error || error.response?.data?.message || 'Gagal mendaftar.'
            
            return { success: false, message, errors }
        }
    }

    const logout = async () => {
        try {
            await api.post('/auth/logout')
        } catch (error) {
            console.error('Logout failed on server', error)
        } finally {
            clearAuth()
        }
    }

    const fetchUser = async () => {
        if (!token.value) return
        try {
            const response = await api.get('/auth/me')
            const { user: backendUser } = response.data
            updateUser(backendUser)
        } catch (error) {
            console.error('Fetch user failed', error)
            clearAuth()
        }
    }

	return {
		user,
		token,
		isAuthenticated,
		userData,
		setAuth,
		clearAuth,
		updateUser,
        login,
        register,
        logout,
        fetchUser
	}
})
