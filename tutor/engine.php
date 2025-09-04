<?php
require_once 'init.php';

class TApplication extends AdiantiCoreApplication
{
    public static function run($debug = FALSE)
    {
        new TSession;
        
        if ($_REQUEST)
        {
            parent::run($debug);
        }
    }
}

TApplication::run(TRUE);

