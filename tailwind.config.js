const colors = require('tailwindcss/colors')

const colorMode = 'dark'

module.exports = {

    darkMode: 'class',

    content: [
        './templates/**/*.twig',
        './templates/**/*.svg'
    ],

    theme: {

        transitionDuration: {
            DEFAULT: '300ms',
            'medium': '500ms',
            'long': '750ms'
        },

        extend: {

            screens: {
                'ml': '896px',
                'sh': {'raw': '(max-height: 450px)'}
            },

            fontFamily: {
                custom: ['"Open Sans"', 'sans-serif'],
                headings: ['Raleway', 'sans-serif'],
                serif: ['"PT Serif"', 'serif']
            },

            fontSize: {
                'custom': '1.125rem',
                'h1': ['2.5rem', '3rem'],
                'h2': '2rem',
            },

            colors:  {
                'primary': {
                    DEFAULT: colors.blue[800],
                    dark: colors.blue[500],
                    ...colors.blue
                },
                'secondary': {
                    DEFAULT: colors.white,
                    dark: colors.slate[900]
                },
                'background': {
                    DEFAULT: colors.slate[50],
                    dark: colors.slate[900]
                },
                'foreground': {
                    DEFAULT:  colors.slate[900],
                    dark: colors.slate[50]
                },
                'frame-background': {
                    DEFAULT: colors.slate[500],
                    dark: colors.slate[500]
                },
                'light': {
                    DEFAULT: colors.slate[300],
                    dark: colors.slate[600]
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
                    DEFAULT: colors.blue[700],
                    dark: colors.slate[700]
                },
                'title-text': {
                    DEFAULT: colors.white,
                    dark: colors.white
                },
                'footer-bg': {
                    DEFAULT: colors.slate[700],
                    dark:colors.slate[700]
                },
                'footer-text': {
                    DEFAULT: colors.white,
                    dark: colors.white
                },
                'footer-border': {
                    DEFAULT: colors.slate[900],
                    dark:  colors.slate[100]
                },
                'border': {
                    DEFAULT: colors.slate[300],
                    dark: colors.slate[400]
                },
                'muted': {
                    DEFAULT: colors.slate[600],
                    dark: colors.slate[200]
                },
                'gray': colors.slate,
                'dark': colors.slate,
                'nav': {
                    DEFAULT: colors.white,
                    dark: colors.slate[900]
                },
                'nav-text': {
                    DEFAULT: colors.slate[900],
                    dark: colors.white
                },
                'teaser': {
                    DEFAULT: colors.red[700],
                    dark: colors.red[500]
                },
                'card': {
                    DEFAULT: colors.white,
                    dark: colors.slate[800]
                },
                'card-text': {
                    DEFAULT: colors.slate[900],
                    dark: colors.slate[50]
                },
                'card-hover': {
                    DEFAULT: colors.gray[200],
                    dark: colors.slate[700]
                }
            },

            width: {
                card: '300px'
            },

            maxWidth: {
                prose: '75ch'
            },

            spacing: {
                'columns': '2rem',
                'block': '2rem'
            },

            animation: {
                'fadein': 'fadeInAnimation ease 1s forwards 1',
            },
            keyframes: {
                fadeInAnimation: {
                    '0%': {
                        opacity: 0
                    },
                    '100%': {
                        opacity: 1
                    }
                }
            }
        },

        // https://github.com/tailwindlabs/tailwindcss-aspect-ratio
        // Compatibility of aspect-ratio plugin with default aspect-ratio utilities (not yet supported in Safari < 15)
        aspectRatio: {
            auto: 'auto',
            square: '1 / 1',
            video: '16 / 9',
            1: '1',
            2: '2',
            3: '3',
            4: '4',
            5: '5',
            6: '6',
            7: '7',
            8: '8',
            9: '9',
            10: '10',
            11: '11',
            12: '12',
            13: '13',
            14: '14',
            15: '15',
            16: '16',
            21: '21',
        },

    },

    safelist: [

        // dynamic widths
        {
            pattern: /(max-w-screen|container)-(sm|md|ml|lg|xl|2xl)/
        },

        // dynamic colors
        {
            pattern: /(bg|text)-(primary|secondary|background|foreground|frame-background|black|white|light|three|four|title-bg|title-text|footer-bg|footer-text|footer-border|border|muted|teaser)/
        },
        {
            pattern: /(bg|text)-(primary-dark|secondary-dark|background-dark|foreground-dark|frame-background-dark|black|white|light-dark|three-dark|four-dark|title-bg-dark|title-text-dark|footer-bg-dark|footer-text-dark|footer-border-dark|border-dark|muted-dark|teaser-dark)/,
            variants: ['dark']
        },

        // dynamic col spans-dark
        {
            pattern: /col-span-(1|2|3|4|5|6|7|8|9|10|11|12)/,
            variants: ['lg']
        },


        // dynamic  paddings
        {
            pattern: /(py|pt|pb)-columns/
        },

        // dynamic block margins
        'my-0',
        {
            pattern: /(mb|mt|my)-block/
        },

        // gallery block columns
        {
            pattern: /grid-cols-(2|3|4|5|6)/,
            variants: ['md']
        }
    ],

    plugins: [
        require('@tailwindcss/forms'),
        require("@tailwindcss/aspect-ratio")
    ],

}
