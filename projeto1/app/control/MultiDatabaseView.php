<?php

class MultiDatabaseView extends TPage {
    public function __construct() {
        parent::__construct();
        // aponta automático para unidade escolhida na interface
        $conn = TTransaction::open('unit_database');

        echo '<pre>';
        var_dump( TDatabase::getData($conn, 'SELECT * FROM people') );
        echo '</pre>';

        TTransaction::close();
    }
}