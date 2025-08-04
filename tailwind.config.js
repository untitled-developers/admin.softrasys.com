import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        //https://github.com/laravel/vite-plugin/issues/324#issuecomment-2821579269
        // Had to add this to exclude the app directory from being scanned by Tailwind which was causing full page reloads
        '!./app/**/*.php',
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./resources/js/**/*.{vue,js,ts,jsx,tsx}",
        "./node_modules/kockatoos-admin-ui/src/**/*.vue",
    ],
    darkMode: 'selector',
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },
};
