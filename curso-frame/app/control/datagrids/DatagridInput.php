<?php
class DatagridInput extends TPage
{
    private $form;
    private $datagrid;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->form = new TForm;
        
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->width = '100%';
        $this->datagrid->disableDefaultClick();
        
        $col_id      = new TDataGridColumn('id',     'Código', 'center', '10%');
        $col_nome    = new TDataGridColumn('nome',   'Nome',   'left',   '30%');
        $col_cidade  = new TDataGridColumn('cidade', 'Cidade', 'left',   '30%');
        $col_estado  = new TDataGridColumn('estado', 'Estado', 'left',   '30%');
        
        
        $this->datagrid->addColumn( $col_id );
        $this->datagrid->addColumn( $col_nome );
        $this->datagrid->addColumn( $col_cidade );
        $this->datagrid->addColumn( $col_estado );
        
        
        $action1 = new TDataGridAction( [$this, 'onView'],   ['id' => '{id}', 'nome' => '{nome_original}' ] );
        $action2 = new TDataGridAction( [$this, 'onDelete'], ['id' => '{id}', 'nome' => '{nome_original}' ] );
        
        $this->datagrid->addAction( $action1, 'Visualiza', 'fa:search blue');
        $this->datagrid->addAction( $action2, 'Exclui',    'fa:trash red');
        
        // após definir colunas, e ações... criar a estrutura
        
        $this->datagrid->createModel();
        
        
        $botao = TButton::create('salvar', [$this, 'onSave'], 'Salvar', 'fa:save green');
        $this->form->addField($botao);
        
        $panel = new TPanelGroup('Datagrid');
        $panel->add($this->datagrid);
        $panel->addFooter( $botao );
        
        $this->form->add($panel);
         
        parent::add($this->form);
    }
    
    public static function onView($param)
    {
        new TMessage('info', 'ID: '. $param['id'] . ' - Nome: ' . $param['nome'] );
    }
    
    public static function onDelete($param)
    {
        new TMessage('error', 'ID: '. $param['id'] . ' - Nome: ' . $param['nome'] );
    }
    
    public function onSave($param)
    {
        $data = $this->form->getData();
        
        $this->form->setData($data);
        
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
    
    public function onReload()
    {
        $this->datagrid->clear();
        
        $item = new stdClass;
        $item->id     = 1;
        $item->cidade = 'Memphis';
        $item->estado = 'Tenessee (US)';
        $item->pais   = 'Estados Unidos';
        $item->nome_original = 'Aretha Franklin';
        
        $item->nome = new TEntry('nome'. $item->id);
        $item->nome->setValue($item->nome_original);
        $item->nome->setSize('100%');
        $this->form->addField( $item->nome );
        $this->datagrid->addItem($item);
        
        $item = new stdClass;
        $item->id     = 2;
        $item->nome_original = 'Eric Clapton';
        
        $item->nome = new TEntry('nome'. $item->id);
        $item->nome->setValue($item->nome_original);
        $item->nome->setSize('100%');
        $this->form->addField( $item->nome );
        
        $item->cidade = 'Ripley';
        $item->estado = 'Surrey (UK)';
        $item->pais   = 'Reino Unido';
        $this->datagrid->addItem($item);
        
        $item = new stdClass;
        $item->id     = 3;
        $item->nome_original = 'B.B. King';
        $item->nome = new TEntry('nome'. $item->id);
        $item->nome->setValue($item->nome_original);
        $item->nome->setSize('100%');
        $this->form->addField( $item->nome );
        $item->cidade = 'Itta Bena';
        $item->estado = 'Mississipi (US)';
        $item->pais   = 'Estados Unidos';
        $this->datagrid->addItem($item);
        
        $item = new stdClass;
        $item->id     = 4;
        $item->nome_original = 'Janis Joplin';
        $item->nome = new TEntry('nome'. $item->id);
        $item->nome->setValue($item->nome_original);
        $item->nome->setSize('100%');
        $this->form->addField( $item->nome );
        $item->cidade = 'Port Arthur';
        $item->estado = 'Texas (US)';
        $item->pais   = 'Estados Unidos';
        $this->datagrid->addItem($item);
    }
    
    public function show()
    {
        $this->onReload();
        parent::show();
    }
}