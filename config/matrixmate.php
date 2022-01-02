<?php

return [
    'fields' => [
        'bodyContent' => [
            'groups' => [
                [
                    'label' => 'Medien',
                    'types' => ['image', 'gallery', 'embed', 'audio', 'playlist', 'video'],
                ], [
                    'label' => 'Spezial',
                    'types' => ['columns', 'buttons', 'quote', 'markdown', 'dynamicBlock']
                ]
            ],
            'types' => [
                'image' => [
                    'tabs' => [
                        [
                            'label' => 'Content',
                            'fields' => ['image', 'caption']
                        ],
                        [
                            'label' => 'Layout',
                            'fields' => ['aspectRatio', 'width', 'marginsY']
                        ]

                    ]
                ],
                'gallery' => [
                    'tabs' => [
                        [
                            'label' => 'Content',
                            'fields' => ['images', ]
                        ],
                        [
                            'label' => 'Layout',
                            'fields' => ['width']
                        ]

                    ]
                ],
                'columns' => [
                    'tabs' => [
                        [
                            'label' => 'Content',
                            'fields' => ['heading', 'columns']
                        ],
                        [
                            'label' => 'Layout',
                            'fields' => ['backgroundColor', 'foregroundColor', 'width', 'marginsY']
                        ]

                    ]
                ]
            ]
        ]
    ]
];
