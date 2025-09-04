<?php
/**
 * PublicView
 *
 */
class PublicView extends TPage
{
    public function __construct()
    {
        parent::__construct();
        
        $html = new THtmlRenderer('app/resources/public.html');

        // replace the main section variables
        $html->enableSection('main', array());
        
        $panel = new TPanelGroup('Public!');
        $panel->add($html);
        
        // add the template to the page
        parent::add( $panel );
    }
}
