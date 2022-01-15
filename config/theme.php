<?php

return [
    // fullwidth frame
    'layout' => 'fullwidth',

    // end start rowLeft rowCenter
    'headerStyle' => 'end',

    // null if no logo used
    'logoTransform' => ['height' => 45],

    'stickyNavbar' => true,

    // stickyNavbar only
    'showScrollIndicator' => true,

    // coverFull (fullwidth only) coverContent coverBoxed fullText fullTextColor imageText textImage text
    'titleStyle' => 'fullTextColor',

    // relative to width.full if cover...
    'titleImageHeight' => 750,

    // relative to fullWidthImageWidth
    'fullwidthImageHeight' => 600,

    'useFallbackImage' => true,

    'pageWidth' => 'lg',

    'headerWidth' => 'xl',

    // breakpoint for default/mobile menu can be always (always show hamburger menu) / never (never show hamburger menu)
    'mobileBreakpoint' => 'sm',

    // same as max-width-header, if titleStyle != fullwidth
    'titleImageWidth' => 'xl',

    'defaultBlockWidth' => 'lg',

    // set max-w-prose on text blocks
    'useProse' => true,

    'sidebarLayoutWidth' => 'xl',

    'defaultImageWidth' => 'xl',

    'defaultAspectRatio' => '16:9',

    // full for fullwidth
    'footerWidth' => 'full',
    'footerInnerWidth' => 'xl',
    'footerBorder' => false,

    'responsiveWidths' => [2500, 1800, 1280, 1024, 768, 400],

    'widths' => [
        'sm' => 640,
        'md' => 768,
        'ml' => 896,
        'lg' => 1024,
        'xl' => 1280,
        '2xl' => 1536,
        'full' => 2500
    ],

    // should match w-card utility
    'cardImageTransform' => ['width' => 300, 'height' => 200, 'format' => 'webp'],

    // default index template
    'cardletImageTransform' => ['width' => 300, 'height' => 225, 'format' => 'webp'],

    'galleryThumbTransform' => ['width' => 200, 'height' => 200, 'format' => 'webp'],

    'galleryFullWidthTransform' => ['width' => 1280, 'height' => 960, 'format' => 'webp'],

    'carouselImageTransform' => ['width' => 500, 'height' => 350, 'format' => 'webp'],

    'lightboxImageTransform' => ['height' => 800, 'format' => 'webp'],

    'entriesPerIndexPage' => 6,
    'entriesInSearchResults' => 6,

    'cookieConsent' => true,

    'fontUrl' => '',
];
