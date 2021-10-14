const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors')

module.exports = {
    mode: 'jit',
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            blur: {
                xs: '2px',
                xxs: '1px',
            }
        },
        colors: {
            transparent: 'transparent',
            current: 'currentColor',
            black: colors.black,
            white: colors.white,
            red: colors.red,
            yellow: colors.amber,
            green: colors.emerald,
            indigo: colors.indigo,
            blue: colors.blue,
            gray: colors.gray,
            primary: colors.red,
            cyan: colors.cyan,
            rose: colors.rose,
            sky: colors.sky,
            purple: colors.purple,
            teal: colors.teal,
            pink: colors.pink,
        },
    },

    plugins: [
        //require('@tailwindcss/forms'),
        // We will use our own Forms approach, to setup some colors
        require('./resources/js/Utils/Plugins/Tailwind/Forms'),
        require('@tailwindcss/typography'),
        require('@tailwindcss/aspect-ratio'),
    ],
};
