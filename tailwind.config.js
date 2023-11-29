import defaultTheme from 'tailwindcss/defaultTheme';
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
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            maxHeight: {
                '730px': '730px',
            },
            minHeight: {
                '730px': '730px', // ここに追加
            },
            maxWidth: {
                '375px': '375px',
            },
            minWidth: {
                '375px': '375px', // ここに追加
            },
        },
    },

    plugins: [forms],
};
