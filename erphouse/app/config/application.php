<?php
return [
    'general' =>  [
        'timezone' => 'America/Sao_Paulo',
        'language' => 'pt',
        'application' => 'erphouse',
        'title' => 'ERP House',
        'theme' => 'adminbs5',
        'seed' => 'losadfb',
        'rest_key' => '',
        'multiunit' => '1',
        'debug' => '1',
        'lang_options' => [
          'pt' => 'Português',
          'en' => 'English',
          'es' => 'Español',
        ],
        'validate_strong_pass' => '1',
        'welcome_message' => 'Have a great jorney!',
    ],
    'permission' =>  [
        'public_classes' => [
          'SystemRequestPasswordResetForm',
          'SystemPasswordResetForm',
          'SystemRegistrationForm',
          'SystemPasswordRenewalForm',
        ],
    ],
    'highlight' => [
        'comment' => '#808080',
        'default' => '#FFFFFF',
        'html' => '#C0C0C0',
        'keyword' => '#62d3ea',
        'string' => '#FFC472',
    ],
    'template' => [
        'navbar' => [
            'has_program_search' => '1',
            'has_notifications' => '1',
            'has_menu_mode_switch' => '1',
            'has_main_mode_switch' => '1'
        ],
        'dialogs' => [
            'use_swal' => '1'
        ],
        'theme' => [
            'menu_dark_color' => 'rgb(34 76 175)',
            'menu_mode'  => 'dark',
            'main_mode'  => 'light'
        ]
    ]
];
