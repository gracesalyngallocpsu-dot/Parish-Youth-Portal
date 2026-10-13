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
            colors: {
                parish: {
                    50: '#FBF2EA',
                    100: '#F5E1CF',
                    200: '#EBC39D',
                    300: '#E0A06B',
                    400: '#D68145',
                    500: '#C7662E',
                    600: '#AC5225',
                    700: '#8A4221',
                    800: '#71361D',
                    900: '#5C2E19',
                    950: '#32170D',
                },
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
