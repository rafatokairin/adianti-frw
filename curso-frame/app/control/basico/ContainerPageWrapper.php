<?php
class ContainerPageWrapper extends TPage
{
    public function __construct()
    {
        parent::__construct();
        
        $page1 = new TPageWrapper;
        $page1->setClass('Calendario');
        $page1->setMethod('onReload');
        $page1->setSize('100%', '500');
        
        $page2 = new TPageWrapper;
        $page2->setClass('KanbanView');
        $page2->setMethod('onReload');
        $page2->setSize('100%', '500');
        
        $vbox = new TVBox;
        $vbox->style = 'width:100%';
        $vbox->add( new TXMLBreadCrumb('menu.xml', __CLASS__));
        $vbox->add($page1);
        $vbox->add($page2);
        
        parent::add($vbox);
    }
}