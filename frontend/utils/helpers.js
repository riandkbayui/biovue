import { env } from '@/env.js'

/**
 * Get full URL from a relative or absolute path based on assetUrl
 * @param {string} path
 * @returns {string}
 */
export const getFullUrl = (path) => {
	if (!path) return ''

	// If path is already a full URL (http/https) or base64, return as is
	if (path.startsWith('http') || path.startsWith('data:')) {
		return path
	}

	// Normalize assetUrl (remove trailing slash)
	const baseUrl = env.assetUrl.replace(/\/$/, '')

	// Normalize path (remove leading slash)
	const cleanPath = path.replace(/^\//, '')

	return `${baseUrl}/${cleanPath}`
}
