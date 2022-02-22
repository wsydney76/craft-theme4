<?php

$useImager = Craft::$app->plugins->isPluginEnabled('imager-x');

return [

    // on, off, media, user
    'darkMode' => 'user',

    // fullwidth frame sidebar
    'layout' => 'fullwidth',

    // end start rowLeft rowCenter
    'headerStyle' => 'end',

    // null if no logo used
    'logoTransform' => ['height' => 45],

    'stickyNavbar' => true,

    // stickyNavbar only
    'showScrollIndicator' => true,

    // coverFull (fullwidth only) coverContent coverBoxed fullText fullTextColor imageText textImage text introImage
    'titleStyle' => 'introImage',

    // relative to width.full if cover...
    'titleImageHeight' => 650,

    // relative to fullWidthImageWidth
    'fullwidthImageHeight' => 600,

    // Use global featured Image on page headers if no individual featured image is set
    // Should be on and a global featured image should be set if 'titleStyle' places the title on the image
    'useFallbackImage' => false,

    'headerWidth' => 'xl',

    // same as max-width-header, if titleStyle != fullwidth
    'titleImageWidth' => 'xl',

    'titleWidth' => 'lg',

    'pageWidth' => 'lg',

    // breakpoint for default/mobile menu can be always (always show hamburger menu) / never (never show hamburger menu)
    'mobileBreakpoint' => 'sm',

    'defaultBlockWidth' => 'lg',

    // Required for image/gallery, add other block types as needed
    'defaultBlockTypeWidth' => [
        'image' => 'xl',
        'gallery' => 'xl'
    ],

    'defaultIndexWidth' => 'xl',

    // set max-w-prose on text blocks
    'useProse' => true,

    'sidebarLayoutWidth' => 'xl',


    'defaultAspectRatio' => '16:9',

    // full for fullwidth
    'footerWidth' => 'full',
    'footerInnerWidth' => 'xl',
    'footerBorder' => false,

    // Output format for image transforms
    'defaultImageFormat' => 'webp',

    // Effects for image transforms (requires imager plugin)
    'defaultImageEffects' => ['sharpen' => true],

    // Don't create srcset for images smaller than
    'minResponsiveWidth' => 400,

    // Create srcset for this widths
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
    'cardImageTransform' => $useImager ? 'cardImage' : ['width' => 300, 'height' => 200, 'format' => 'webp'],

    'defaultIndexImageTransform' => $useImager ? 'defaultIndexImage' : ['width' => 350, 'height' => 200, 'format' => 'webp'],

    // set null if first image shall not be fullwidth
    'defaultIndexFirstImageTransform' => $useImager ? 'defaultIndexFirstImage' : ['width' => 768, 'height' => 432, 'format' => 'webp'],

    // default index template
    'cardletImageTransform' => ['width' => 300, 'height' => 225, 'format' => 'webp'],

    'galleryThumbTransform' => ['width' => 200, 'height' => 200, 'format' => 'webp'],

    'galleryFullWidthTransform' => ['width' => 1280, 'height' => 960, 'format' => 'webp'],

    'carouselImageTransform' => ['width' => 500, 'height' => 350, 'format' => 'webp'],

    'lightboxImageTransform' => ['height' => 800, 'format' => 'webp'],

    'featuredArticleTransform' => ['width' => 1280, 'height' => 700, 'format' => 'webp'],

    'defaultArticleTransform' => ['width' => 400, 'height' => 250, 'format' => 'webp'],

    // titleStyle = introImage
    'introImageTransform' => ['width' => 640],

    'entriesPerIndexPage' => 6,
    'entriesInSearchResults' => 6,

    'cookieConsent' => true,

    'fontUrl' => '',

    // Template for members only content
    'membersTemplate' => '_partials/members',

    // Show intro text on article pages
    'showArticleIntro' => true,
];
