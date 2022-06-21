<?php

return [
    'fields' => [
        'bodyContent' => [

            // all blocks of a group should get a common color in cp_styles.css
            'groups' => [
                [
                    'label' => Craft::t('site', 'Media'),
                    'types' => ['gallery', 'imageAndText', 'embed', 'audio', 'playlist', 'video'],
                ], [
                    'label' => Craft::t('site', 'Special'),
                    'types' => ['articles', 'summary', 'columns', 'buttons', 'quote', 'faq', 'markdown', 'dynamicBlock']
                ]
            ],
            'types' => [
                'image' => [
                    'tabs' => [
                        [
                            'label' => Craft::t('site', 'Content'),
                            'fields' => ['image', 'caption']
                        ],
                        [
                            'label' => Craft::t('site', 'Layout'),
                            'fields' => ['aspectRatio', 'width', 'marginsY', 'styles']
                        ],
                        [
                            'label' => Craft::t('site', 'Image effects'),
                            'fields' => ['imageEffects']
                        ]

                    ]
                ],
                'gallery' => [
                    'tabs' => [
                        [
                            'label' => Craft::t('site', 'Content'),
                            'fields' => ['images',]
                        ],
                        [
                            'label' => Craft::t('site', 'Layout'),
                            'fields' => ['width', 'style', 'numberOfColumns', 'aspectRatio']
                        ]

                    ]
                ],
                'imageAndText' => [
                    'tabs' => [
                        [
                            'label' => Craft::t('site', 'Content'),
                            'fields' => ['image', 'heading', 'text']
                        ],
                        [
                            'label' => Craft::t('site', 'Layout'),
                            'fields' => ['width', 'style', 'aspectRatio', 'imageBackgroundColor', 'align', 'marginsY']
                        ]

                    ]
                ],
                'columns' => [
                    'tabs' => [
                        [
                            'label' => Craft::t('site', 'Content'),
                            'fields' => ['heading', 'columns']
                        ],
                        [
                            'label' => Craft::t('site', 'Layout'),
                            'fields' => ['backgroundColor', 'foregroundColor', 'width', 'marginsY']
                        ]

                    ]
                ],
                'faq' => [
                    'tabs' => [
                        [
                            'label' => Craft::t('site', 'Content'),
                            'fields' => ['items']
                        ],
                        [
                            'label' => Craft::t('site', 'Layout'),
                            'fields' => ['display']
                        ]

                    ]
                ],
                'audio' => [
                    'tabs' => [
                        [
                            'label' => Craft::t('site', 'Content'),
                            'fields' => ['audioFile']
                        ],
                        [
                            'label' => Craft::t('site', 'Layout'),
                            'fields' => ['style']
                        ]

                    ]
                ],
                'playlist' => [
                    'tabs' => [
                        [
                            'label' => Craft::t('site', 'Content'),
                            'fields' => ['audios']
                        ],
                        [
                            'label' => Craft::t('site', 'Layout'),
                            'fields' => ['style']
                        ]

                    ]
                ],
                'articles' => [
                    'tabs' => [
                        [
                            'label' => Craft::t('site', 'Content'),
                            'fields' => ['heading', 'articles', 'topic', 'articlesLimit', 'restrictToTopic']
                        ],
                        [
                            'label' => Craft::t('site', 'Layout'),
                            'fields' => ['width', 'style', 'showAuthorAndDate', 'addTopBorder']
                        ]

                    ]
                ],
            ]
        ]
    ]
];
