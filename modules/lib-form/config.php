<?php

return [
    '__name' => 'lib-form',
    '__version' => '0.3.0',
    '__git' => 'git@github.com:getmim/lib-form.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'modules/lib-form' => ['install','update','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'lib-validator' => NULL
            ],
            [
                'lib-view' => null
            ],
            [
                'lib-cache' => null
            ]
        ],
        'optional' => []
    ],
    'autoload' => [
        'classes' => [
            'LibForm\\Library' => [
                'type' => 'file',
                'base' => 'modules/lib-form/library'
            ],
            'LibForm\\Service' => [
                'type' => 'file',
                'base' => 'modules/lib-form/service'
            ]
        ],
        'files' => []
    ],
    'service' => [
        'form' => 'LibForm\\Service\\Form'
    ],

    'libForm' => [
        'forms' => [
            'std-empty' => [
                'none' => [
                    'label' => 'Unused',
                    'type' => 'text',
                    'rules' => []
                ]
            ]
        ]
    ]
];
