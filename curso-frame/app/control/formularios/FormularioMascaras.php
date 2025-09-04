<?php
class FormularioMascaras extends TPage
{
    public function __construct()
    {
        parent::__construct();
        

        $this->form = new BootstrapFormBuilder;
        $this->form->setFormTitle('Máscaras de digitação');
        
        $element1 = new TEntry('element1');
        $element2 = new TEntry('element2');
        $element3 = new TEntry('element3');
        $element4 = new TEntry('element4');
        $element5 = new TEntry('element5');
        $element6 = new TEntry('element6');
        $element7 = new TEntry('element7');
        $element8 = new TEntry('element8');
        $element9 = new TEntry('element9');
        $element10= new TEntry('element10');
        $element11= new TEntry('element11');
        $element12= new TEntry('element12');
        $element13= new TEntry('element13');
        $element14= new TEntry('element14');
        
        
        $element1->setMask('99.999-999');
        $element2->setMask('99.999-999', true);
        $element3->setMask('99.999.999/9999-99');
        $element4->setMask('99.999.999/9999-99', true);
        $element5->setMask('A!');
        $element6->setMask('AAA');
        $element7->setMask('S!');
        $element8->setMask('SSS');
        $element9->setMask('9!');
        $element10->setMask('999');
        $element11->setMask('SSS-9A99');
        $element12->forceUpperCase();
        $element13->forceLowerCase();
        $element14->setNumericMask(2, ',', '.', true);
        
        $this->form->addFields( [new TLabel('Element 1')], [$element1] );
        $this->form->addFields( [new TLabel('Element 2')], [$element2] );
        $this->form->addFields( [new TLabel('Element 3')], [$element3] );
        $this->form->addFields( [new TLabel('Element 4')], [$element4] );
        $this->form->addFields( [new TLabel('Element 5')], [$element5] );
        $this->form->addFields( [new TLabel('Element 6')], [$element6] );
        $this->form->addFields( [new TLabel('Element 7')], [$element7] );
        $this->form->addFields( [new TLabel('Element 8')], [$element8] );
        $this->form->addFields( [new TLabel('Element 9')], [$element9] );
        $this->form->addFields( [new TLabel('Element 10')], [$element10] );
        $this->form->addFields( [new TLabel('Element 11')], [$element11] );
        $this->form->addFields( [new TLabel('Element 12')], [$element12] );
        $this->form->addFields( [new TLabel('Element 13')], [$element13] );
        $this->form->addFields( [new TLabel('Element 14')], [$element14] );
        
        
        $this->form->addAction( 'Enviar', new TAction( [$this, 'onSend'] ), 'fa:save');
        
        parent::add( $this->form );
    }
    
    public function onSend($param)
    {
        $data = $this->form->getData();
        $this->form->setData($data);
        
        new TMessage('info', str_replace(',', '<br>', json_encode($data)));
    }
}