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
                logo: ['Quicksand', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'space': {
                    '50': '#f4f6f7',
                    '100': '#e3e8ea',
                    '200': '#c9d3d8',
                    '300': '#a4b4bc',
                    '400': '#778c99',
                    '500': '#5c717e',
                    '600': '#4f5f6b',
                    '700': '#44505a',
                    '800': '#3d454d',
                    '900': '#343a40', // original
                    '950': '#21262b',
                },
                'green-yellow': {
                    '50': '#f8ffe6',
                    '100': '#edffc8',
                    '200': '#dbff97',
                    '300': '#bffb5b',
                    '400': '#9ef01a', // original
                    '500': '#85d70b',
                    '600': '#66ac04',
                    '700': '#4d8308',
                    '800': '#40670d',
                    '900': '#365710',
                    '950': '#1a3102',
                },
                'elime': {
                    '50': '#fbffe4',
                    '100': '#f6ffc4',
                    '200': '#ebff90',
                    '300': '#d9ff50',
                    '400': '#ccff33', // original
                    '500': '#a7e600',
                    '600': '#81b800',
                    '700': '#618b00',
                    '800': '#4d6d07',
                    '900': '#415c0b',
                    '950': '#213400',
                },
                'bunker': {
                    '50': '#f7f8f8',
                    '100': '#edeef1',
                    '200': '#d8dbdf',
                    '300': '#b5bac4',
                    '400': '#8d94a3',
                    '500': '#6f7788',
                    '600': '#596070',
                    '700': '#494f5b',
                    '800': '#3f434d',
                    '900': '#373a43',
                    '950': '#141518',   // original
                },
                
            }
        },
    },

    plugins: [forms],
};
