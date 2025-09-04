<?php
return [
    'general' =>  [
        'timezone' => 'America/Sao_Paulo',
        'language' => 'auto,pt', // auto pega idioma do navegador
        'application' => 'projeto1',
        'title' => 'Adianti Template 8.2',
        'theme' => 'adminbs5',
        'seed' => 'odfu6asnodf8as',
        'rest_key' => '123',
        'multiunit' => '1',
        'public_view' => '0',
        'public_entry' => 'PublicView', // classe padrão public
        'debug' => '1',
        /* (aumentar segurança)
        se tiver 'strict_request' => '1', deve extender/implementar classes:
            Controllers:
            - Classes filhas (extends) de TPage.
            - Classes filhas (extends) de Twindow.
            - Qualquer classe que implemente a interface AdiantiController
            (Ex. class MinhaController implements AdiantiController).

            Services:
            - Classes filhas (extends) de AdiantiRecordService.
            - Qualquer classe que implemente a interface AdiantiRestService.
            (Ex. class MinhaService implements AdiantiRestService).

            Jobs:
            - Classes filhas (extends) de Adianti Job.
            (Ex. class MeuJob implements Adianti Job).
        */
        'strict_request' => '0',
        'multi_lang' => '1', // habilita vários idiomas (user escolhe)
        'require_terms' => '1', // ativar termos de aceite
        'concurrent_sessions' => '1', // permite dois logins no mesmo user
        'lang_options' => [
          'pt' => 'Português',
          'en' => 'English',
          'es' => 'Español',
        ],
        'multi_database' => '0', // cada unit pode ter banco de dados associado
        'validate_strong_pass' => '1', // obriga senha forte
        'notification_login' => '1', // manda email quando loga
        'welcome_message' => 'Have a great jorney!',
        'request_log_service' => 'SystemRequestLogService', // classe de registro (request log)
        'request_log' => '0',
        'request_log_types' => 'cli,web,rest', // tipos de requisição p/ monitorar
        /*'password_renewal_interval' => '30',*/ // user precisa renovar senha a cada 30 dias
    ],
    'recaptcha' => [
        'enabled' => '0', // ativar recaptcha
        'key' => '...',
        'secret' => '...'
    ],
    'permission' =>  [ // permissão classes públicas
        'public_classes' => [
          'SystemRequestPasswordResetForm',
          'SystemPasswordResetForm',
          'SystemRegistrationForm',
          'SystemPasswordRenewalForm',
          'SystemConcurrentAccessView',
          'PublicView'
        ],
        'user_register' => '1', // permissão criar conta
        'reset_password' => '1', // permissão trocar senha
        'default_groups' => '2', // id padrão ao cadastrar user
        'default_screen' => '30', // id padrão ao entrar na aplicação
        'default_units' => '1',
    ],
    'highlight' => [
        'comment' => '#808080',
        'default' => '#FFFFFF',
        'html' => '#C0C0C0',
        'keyword' => '#62d3ea',
        'string' => '#FFC472',
    ],
    'login' => [
        'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/ce/Coca-Cola_logo.svg/800px-Coca-Cola_logo.svg.png', // imagem login
        'background' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/62/Solid_red.svg/512px-Solid_red.svg.png' // imagem background
    ],
    'template' => [
        'navbar' => [
            'has_program_search' => '1', // search
            'has_notifications' => '1',
            'has_messages' => '1',
            'has_docs' => '1',
            'has_contacts' => '1',
            'has_support_form' => '1',
            'has_wiki' => '1',
            'has_news' => '1',
            'has_menu_mode_switch' => '1', // permite temas claros e escuro menu
            'has_main_mode_switch' => '1', // permite temas claros e escuro main
            'has_master_menu' => '0', // ativa segunda barra lateral (deixa menu mais enxuto)
            'always_collapse' => '0', // fecha aba de menu ao selecionar
            'allow_page_tabs' => '0' // cria tab nav dentro do template (iframe)
        ],
        'dialogs' => [
            'use_swal' => '1'
        ],
        'theme' => [
            'menu_dark_color' => 'rgb(29 45 83)',
            'menu_mode'  => 'dark',
            'main_mode'  => 'light'
        ]
    ]
];
