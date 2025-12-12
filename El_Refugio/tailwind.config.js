import defaultTheme from 'tailwindcss/defaultTheme'
import forms from '@tailwindcss/forms'

export default {
    content: [
        './resources/views/**/*.blade.php',
        './resources/views/components/**/*.blade.php',
        './resources/js/**/*.js',
        './resources/css/**/*.css',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
}
