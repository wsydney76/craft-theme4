module.exports = {

    darkMode: 'class',

    content: [
        './templates/**/*.twig',
        './templates/**/*.svg'
    ],

    theme: {

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
