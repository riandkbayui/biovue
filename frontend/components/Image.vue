<template>
	<img :src="fullUrl" v-bind="$attrs" />
</template>

<script setup>
import { computed } from 'vue'
import { env } from '@/env.js'

const props = defineProps({
	src: {
		type: String,
		required: true
	}
})

const fullUrl = computed(() => {
	if (!props.src) return ''

	// Jika src sudah berupa URL lengkap (http/https) atau base64, gunakan langsung
	if (props.src.startsWith('http') || props.src.startsWith('data:')) {
		return props.src
	}

	// Normalisasi assetUrl (hapus slash di akhir jika ada)
	const baseUrl = env.assetUrl.replace(/\/$/, '')
	
	// Normalisasi path src (hapus slash di awal jika ada)
	const path = props.src.replace(/^\//, '')

	return `${baseUrl}/${path}`
})
</script>
