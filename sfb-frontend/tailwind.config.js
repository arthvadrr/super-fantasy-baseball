/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './public/**/*.html',
        './src/**/*.{js,jsx,ts,tsx,vue}',
    ],
    theme: {
        extend: {
            colors: {
                'sfb-dark-orange': '#DF594E',
                'sfb-light-orange': '#F5AF64',
                'sfb-input-bg': '#F5FCFE',
                'sfb-blue': '#47C5E7',
                'sfb-link': '#2C4200',
                'sfb-text': '#000000',
            },
            fontFamily: {
                'sfb-heading': ['Baskerville SC', 'serif'],
                'sfb-body': ['Raleway', 'sans-serif'],
            },
        },
        borderRadius: {
            'large': '3rem'
        },
    },
    plugins: [],
}