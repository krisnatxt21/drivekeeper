import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

export default {
    darkMode: 'class', // dark mode pakai class, bukan system
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
            colors: {
                // Warna aksen utama: merah sporty
                primary: {
                    DEFAULT: '#e63946',
                    dark: '#c1121f',
                    light: '#ff6b6b',
                },
                // Warna surface dark mode
                surface: {
                    900: '#0d0d0d',
                    800: '#1a1a1a',
                    700: '#2a2a2a',
                    600: '#3a3a3a',
                },
            },
        },
    },
    plugins: [forms],
};
