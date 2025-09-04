<?php

use Adianti\Database\TFilter;
use Adianti\Registry\TSession;

class TesteView extends TPage {
    public function __construct() {
        parent::__construct();

        // TRADUÇÃO:
        // _t traduz de acordo com ApplicationTranslator.php
        /* parent::add(new TLabel( _t('City') )); */

        // NOTIFICAÇÃO:
        // com action (carrega classe)
        SystemNotification::register(1,
                                    'Notícia nova',
                                    'Tem notícia nova',
                                    'class=SystemPostFeedView',
                                    'Ver',
                                    'fa fa-rss');
        // executa método da classe     
        SystemNotification::register(1,
                                    'Notícia nova',
                                    'Tem notícia nova',
                                    new TAction(['SystemPostFeedView', 'onReload']),
                                    'Ver',
                                    'fa fa-rss');

        // sem action
        SystemNotification::register(1,
                                    'Novo documento',
                                    'Tem novo documento',
                                    '',
                                    'Ok',
                                    'fa fa-check');

        // MULTI UNIDADES:
        parent::add(TSession::getValue('userunitid'));
        parent::add(TSession::getValue('userunitname'));
        parent::add(TSession::getValue('userunitcustomcode'));
        // exemplo de como usar: colocar campo em tabela para filtrar unit
        $criteria = new TCriteria;
        $criteria->add(new TFilter('id_unidade', '=', TSession::getValue('userunitcustomcode')));
        parent::setCriteria($criteria);
    }
}