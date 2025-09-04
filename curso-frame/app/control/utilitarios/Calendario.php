<?php
class Calendario extends TPage
{
    private $calendario;
    
    public function __construct()
    {
        parent::__construct();
        // passando construct abre pelo mês
        $this->calendario = new TFullCalendar( date('Y-m-d'), 'month');
        $this->calendario->setTimeRange('06:00:00', '20:00:00');
        // popover em cima do evento
        $this->calendario->enablePopover('Médico: {medico}', '<b>Tipo:</b> {tipo} <br> <b>Cliente: </b> {cliente}');
        $this->calendario->enableFullHeight();
        
        $obj1 = (object) ['cliente' => 'Maria',    'medico' => 'Peter', 'tipo' => 'Oftalmo' ];
        $obj2 = (object) ['cliente' => 'Pedro',    'medico' => 'John',  'tipo' => 'Gastro' ];
        $obj3 = (object) ['cliente' => 'João',     'medico' => 'Mary',  'tipo' => 'Ortopédico' ];
        $obj4 = (object) ['cliente' => 'Cristina', 'medico' => 'Elton', 'tipo' => 'Oftalmo' ];
        
        $this->calendario->addEvent( 1, 'Evento 1', '2025-08-10 12:00:00', '2025-08-10 14:00:00', null, '#C04747', $obj1);
        $this->calendario->addEvent( 2, 'Evento 2', '2025-08-10 16:00:00', '2025-08-10 18:00:00', null, '#668Bc6', $obj2);
        $this->calendario->addEvent( 3, 'Evento 3', '2025-08-12 12:00:00', '2025-08-12 14:00:00', null, '#FF0000', $obj3);
        $this->calendario->addEvent( 4, 'Evento 4', '2025-08-12 16:00:00', '2025-08-12 18:00:00', null, '#5AB34B', $obj4);
        
        $this->calendario->setEventClickAction( new TAction([$this, 'onEventClick']));
        // ação dia vazio
        $this->calendario->setDayClickAction( new TAction([$this, 'onDayClick']));
        
        parent::add($this->calendario);
    }
    
    public static function onEventClick($param)
    {
        new TMessage('info', str_replace(',', ',<br>', json_encode($param)));
    }
    
    public static function onDayClick($param)
    {
        new TMessage('info', str_replace(',', ',<br>', json_encode($param)));
    }
}