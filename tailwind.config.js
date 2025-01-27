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
            },
            animation: {
                emphasize: 'emphasize 1s ease-in-out infinite', // Duración suave y fluida
              },
              keyframes: {
                emphasize: {
                  '0%, 100%': { transform: 'scale(1)', opacity: '1' }, // Mantener el tamaño original al inicio y final
                  '50%': { transform: 'scale(1.05)', opacity: '0.9' }, // Aumentar el tamaño un poco y reducir la opacidad
                },
              },
        },
    },

    plugins: [forms, require('daisyui')],
    daisyui: {
        themes: [
            'light',
        ],
    },
};
