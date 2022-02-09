<?php

return [
    'cardImage' => [
        'displayName' => 'Card Image Transform',
        'transforms' => [
            'width' => 300, 'height' => 200, 'format' => 'webp', 'mode' => 'crop', 'effects' => ['sharpen' => true]
        ]
    ],
    'defaultIndexImage' => [
        'displayName' => 'Default Index Image Transform',
        'transforms' => [
            'width' => 350, 'height' => 200, 'format' => 'webp', 'mode' => 'crop', 'effects' => ['sharpen' => true],
        ]
    ],
    'defaultIndexFirstImage' => [
        'displayName' => 'Default First Image Transform',
        'transforms' => [
            'width' => 768, 'height' => 432, 'format' => 'webp', 'mode' => 'crop', 'effects' => ['sharpen' => true],
        ]
    ]
];
