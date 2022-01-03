<?php

return [
    // fullwidth frame
    'layout' => 'fullwidth',

    'pageWidth' => 'lg',
    'headerWidth' => 'xl',

    'stickyNavbar' => true,

    // stickyNavbar only
    'showScrollIndicator' => true,

    // full for fullwidth
    'footerWidth' => 'full',
    'footerInnerWidth' => '2xl',
    'footerBorder' => false,


    'defaultBlockWidth' => 'lg',
    'sidebarLayoutWidth' => 'xl',


    // coverFull coverContent coverBoxed fullText fullTextColor imageText textImage text
    'titleStyle' => 'coverBoxed',

    // same as max-width-header, if titleStyle != fullwidth
    'titleImageWidth' => 'xl',

    // set max-w-prose on text blocks
    'useProse' => true,

    // breakpoint for default/mobile menu can be always (always show hamburger menu) / never (never show hamburger menu)
    'mobileBreakpoint' => 'sm',

    // end start rowLeft rowCenter
    'headerStyle' => 'end',

    // null if no logo used
    'logoTransform' => ['height' => 45],

    // relative to width.full if cover...
    'titleImageHeight' => 750,
    // relative to fullWidthImageWidth
    'fullwidthImageHeight' => 600,

    'useFallbackImage' => true,

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

    'galleryThumbTransform' => ['width' => 200, 'height' => 200, 'format' => 'webp'],

    'lightboxImageTransform' => ['height' => 800, 'format' => 'webp'],

    'defaultImageWidth' => 'xl',
    'defaultAspectRatio' => '16:9',

    'entriesPerIndexPage' => 6,
    'entriesInSearchResults' => 6,

    'cookieConsent' => true,

    'fontUrl' => '',
];
