/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './public/**/*.html',
    './src/**/*.{js,jsx,ts,tsx,vue}',
  ],
  theme: {
    extend: {},
    borderRadius: {
      'large': '3rem'
    },
    colors: {
      'blue-light': '#4EC5E1',
    }
  },
  plugins: [],
}