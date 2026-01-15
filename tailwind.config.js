/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.php",
    "./frontend/**/*.{vue,js,ts,jsx,tsx}",
    "./statics/**/*.{vue,js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}

