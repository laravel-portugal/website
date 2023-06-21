const defaultTheme = require('tailwindcss/defaultTheme')
const colors = require('tailwindcss/colors')

module.exports = {
    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
                roboto: ['RobotoBold',...defaultTheme.fontFamily.sans],
                robotoMono: ['RobotoMono', ...defaultTheme.fontFamily.mono],
            },
            blur: {
                xs: '2px',
                xxs: '1px',
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
    },
    variants: {
        extend: {
            backgroundColor: ['active'],
        }
    },
    content: [
        './app/**/*.php',
        './resources/**/*.html',
        './resources/**/*.js',
        './resources/**/*.jsx',
        './resources/**/*.ts',
        './resources/**/*.tsx',
        './resources/**/*.php',
        './resources/**/*.vue',
        './resources/**/*.twig',
    ],
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
}
