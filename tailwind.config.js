import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                script: ['"Great Vibes"', 'cursive'],
            },
            colors: {
                pink: {
                600: '#B6487B',
                700: '#9E3F6E', // เฉดเข้มขึ้นเล็กน้อยไว้ใช้ตอน hover
                },
            },
        },
    },

    plugins: [forms],
};
