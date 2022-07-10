/** @type {import('tailwindcss').Config} */

const colors = require('tailwindcss/colors')

// Default Theme color
color = 'blue'

// Theme gray scale
gray = 'slate'

// Darkmode color palette
dark = 'slate'

module.exports = {

    presets: [
        require('./src/styles/presets/essential')
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

            colors: require('./src/styles/presets/colors-default')(color, gray, dark),

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

            width: {
                card: '300px'
            },

            maxWidth: {
                prose: '70ch'
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
    },
}
