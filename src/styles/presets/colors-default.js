const colors = require('tailwindcss/colors')

module.exports = (color, gray, dark) => ({
    'primary': {
        DEFAULT: colors[color][800],
        dark: colors[color][500],
        ...colors[color]
    },
    'secondary': {
        DEFAULT: colors.white,
        dark: colors[dark][900]
    },
    'background': {
        DEFAULT: colors[gray][50],
        dark: colors[dark][900]
    },
    'foreground': {
        DEFAULT:  colors[gray][900],
        dark: colors[dark][50]
    },
    'frame-background': {
        DEFAULT: colors[gray][500],
        dark: colors[dark][500]
    },
    'light': {
        DEFAULT: colors[gray][300],
        dark: colors[dark][600]
    },
    'three': {
        DEFAULT: colors.red[800],
        dark: colors.red[800]
    },
    'four': {
        DEFAULT: colors.orange[700],
        dark: colors.orange[700]
    },
    'title-bg': {
        DEFAULT: colors[color][700],
        dark: colors[dark][700]
    },
    'title-text': {
        DEFAULT: colors.white,
        dark: colors.white
    },
    'footer-bg': {
        DEFAULT: colors[gray][700],
        dark:colors[dark][700]
    },
    'footer-text': {
        DEFAULT: colors.white,
        dark: colors.white
    },
    'footer-border': {
        DEFAULT: colors[gray][900],
        dark:  colors[dark][100]
    },
    'border': {
        DEFAULT: colors[gray][300],
        dark: colors[dark][400]
    },
    'muted': {
        DEFAULT: colors[gray][600],
        dark: colors[dark][200]
    },
    'gray': colors[gray],
    'dark': colors[dark],
    'nav': {
        DEFAULT: colors.white,
        dark: colors[dark][900]
    },
    'nav-text': {
        DEFAULT: colors[gray][900],
        dark: colors.white
    },
    'teaser': {
        DEFAULT: colors.red[700],
        dark: colors.red[500]
    },
    'card': {
        DEFAULT: colors.white,
        dark: colors[dark][800]
    },
    'card-text': {
        DEFAULT: colors[gray][900],
        dark: colors[dark][50]
    },
    'card-hover': {
        DEFAULT: colors[gray][200],
        dark: colors[dark][700]
    }
})
