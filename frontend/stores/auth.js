import { defineStore } from 'pinia'
import { ref, computed } from 'vue'

const createDefaultUser = () => ({
	id: null,
	name: '',
	username: '',
	email: '',
	group: 'member',
	photo: '',
	plan: 'free',
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
		// Merge dengan default user untuk memastikan semua field ada
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

	return {
		user,
		token,
		isAuthenticated,
		userData,
		setAuth,
		clearAuth,
		updateUser
	}
})
