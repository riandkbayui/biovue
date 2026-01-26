<template>
	<img :src="fullUrl" v-bind="$attrs" />
</template>

<script setup>
import { computed } from 'vue'
import { getFullUrl } from '@/utils/helpers.js'

const props = defineProps({
	src: {
		type: String,
		required: true
	}
})

const fullUrl = computed(() => getFullUrl(props.src))
</script>
