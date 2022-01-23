const colors = require('tailwindcss/colors')

module.exports = {

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
            },

            fontSize: {
                'custom': '1.125rem',
                'h1': ['2.5rem', '3rem'],
                'h2': '2rem',
            },

            colors: {
                primary: {
                    DEFAULT: colors.blue[800],
                    ...colors.blue
                },
                secondary: colors.white,
                background: colors.slate[50],
                foreground: colors.slate[900],
                'frame-background': colors.slate[500],
                light: colors.slate[300],
                three: colors.red[800],
                four: colors.orange[700],
                'title-bg': colors.blue[700],
                'title-text': colors.white,
                'footer-bg': colors.slate[700],
                'footer-text': colors.white,
                'footer-border': colors.slate[900],
                border: colors.slate[300],
                muted: colors.slate[600],
                gray: colors.slate,
                nav: colors.white
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
            pattern: /(bg|text)-(primary|secondary|background|foreground|frame-background|black|white|light|three|four|title-bg|title-text|footer-bg|footer-text|footer-border|border|muted)/
        },

        // dynamic col spans

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

    ],

    plugins: [
        require('@tailwindcss/forms'),
        require("@tailwindcss/aspect-ratio")
    ],


}
