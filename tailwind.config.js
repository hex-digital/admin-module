const colors = require('tailwindcss/colors')

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/filament/**/*.blade.php',
    ],
    theme: {
        extend: {
            colors: {
                danger: colors.rose,
                primary: colors.blue,
                success: colors.green,
                warning: colors.yellow,
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
}

