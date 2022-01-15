<?php

return [
    'fields' => [
        'bodyContent' => [
            'groups' => [
                [
                    'label' => Craft::t('site','Media'),
                    'types' => ['gallery', 'embed', 'audio', 'playlist', 'video'],
                ], [
                    'label' => Craft::t('site','Special'),
                    'types' => ['summary', 'columns', 'buttons', 'quote', 'faq', 'markdown', 'dynamicBlock']
                ]
            ],
            'types' => [
                'image' => [
                    'tabs' => [
                        [
                            'label' => Craft::t('site','Content'),
                            'fields' => ['image', 'caption']
                        ],
                        [
                            'label' => Craft::t('site','Layout'),
                            'fields' => ['aspectRatio', 'width', 'marginsY']
                        ]

                    ]
                ],
                'gallery' => [
                    'tabs' => [
                        [
                            'label' => Craft::t('site','Content'),
                            'fields' => ['images', ]
                        ],
                        [
                            'label' => Craft::t('site','Layout'),
                            'fields' => ['width', 'display']
                        ]

                    ]
                ],
                'columns' => [
                    'tabs' => [
                        [
                            'label' => Craft::t('site','Content'),
                            'fields' => ['heading', 'columns']
                        ],
                        [
                            'label' => Craft::t('site','Layout'),
                            'fields' => ['backgroundColor', 'foregroundColor', 'width', 'marginsY']
                        ]

                    ]
                ],
                'faq' => [
                    'tabs' => [
                        [
                            'label' => Craft::t('site','Content'),
                            'fields' => ['items', ]
                        ],
                        [
                            'label' => Craft::t('site','Layout'),
                            'fields' => ['display']
                        ]

                    ]
                ],
            ]
        ]
    ]
];
