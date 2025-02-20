const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Merriweather', ...defaultTheme.fontFamily.sans],
                nunito: ['Nunito', ...defaultTheme.fontFamily.sans],
                merriweather: ['Merriweather', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                primary: {
                    DEFAULT: '#bf7709',
                    '50': '#fef3e6',
                    '100': '#fde6cc',
                    '200': '#fbcd99',
                    '300': '#f9b366',
                    '400': '#f79a33',
                    '500': '#bf7709',
                    '600': '#966006',
                    '700': '#6c4404',
                    '800': '#432803',
                    '900': '#1a0f01'
                }
            }
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
