import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            colors: {
                'sfb-light-orange': '#F5AF64',
                'sfb-dark-orange': '#DF594E',
                'sfb-bg-orange': '#FEF3ED',
                'sfb-dark-blue': '#334F5E',
                'sfb-input-bg': '#F5FCFE',
                'sfb-brown': '#C1A289',
                'sfb-blue': '#47C5E7',
                'sfb-link': '#2C4200',
                'sfb-text': '#000000',
            },
            fontFamily: {
                'sfb-heading': ['Baskerville SC', 'serif'],
                'sfb-body': ['Raleway', 'sans-serif'],
            },
            borderRadius: {
                'sfb-l': '3.8rem',
                'sfb-xl': '4.5rem',
                'sfb-xxl': '6rem',
            },
        },
    },

    plugins: [forms],
};
