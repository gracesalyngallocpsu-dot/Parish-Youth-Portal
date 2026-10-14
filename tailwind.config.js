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
                    50: '#FCF7EF',
                    100: '#F7EBD5',
                    200: '#EFD5A8',
                    300: '#E8BC7C',
                    400: '#E6A962',
                    500: '#DB9346',
                    600: '#C47A32',
                    700: '#A05E28',
                    800: '#7A4620',
                    900: '#5A351E',
                    950: '#3A2B1D',
                },
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
