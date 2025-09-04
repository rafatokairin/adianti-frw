<?php
class CidadeList extends TPage
{
    private $form;
    private $datagrid;
    // paginação
    private $pageNavigation;
    private $loaded;
    
    public function __construct()
    {
        parent::__construct();
        
        // form de search
        $this->form = new BootstrapFormBuilder;
        $this->form->setFormTitle('Cidades');
        
        $nome = new TEntry('nome');
        // nome da sessão default (search)
        $nome->setValue( TSession::getValue('CidadeList_nome') );
        
        $this->form->addFields( [new TLabel('Nome')], [$nome] );
        
        $this->form->addAction('Buscar', new TAction([$this, 'onSearch']), 'fa:search blue');
        // muda a página sem fazer POST de novo (classe + método)
        $this->form->addActionLink('Novo', new TAction( ['CidadeForm', 'onClear']), 'fa:plus-circle green');
        
        
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->width = '100%';
        
        $col_id     = new TDataGridColumn('id', 'Cód', 'right', '10%');
        $col_nome   = new TDataGridColumn('nome', 'Nome', 'left', '60%');
        // get_estado()->nome: retorna nome do estado
        $col_estado = new TDataGridColumn('estado->nome', 'Estado', 'center', '30%');
        
        // ordernação
        $col_id->setAction( new TAction( [$this, 'onReload'] ), ['order' => 'id']);
        $col_nome->setAction( new TAction( [$this, 'onReload'] ), ['order' => 'nome']);
        
        $this->datagrid->addColumn($col_id);
        $this->datagrid->addColumn($col_nome);
        $this->datagrid->addColumn($col_estado);
        // id na posição key
        $action1 = new TDataGridAction( ['CidadeForm', 'onEdit'], [ 'key' => '{id}'] );
        $action2 = new TDataGridAction( [$this, 'onDelete'], [ 'key' => '{id}'] );
        
        $this->datagrid->addAction( $action1, 'Editar', 'fa:edit blue');
        $this->datagrid->addAction( $action2, 'Excluir', 'fa:trash-alt red');
        
        $this->datagrid->createModel();
        
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction( new TAction([$this, 'onReload'] ));
        
        
        $panel = new TPanelGroup;
        $panel->add($this->datagrid);
        $panel->addFooter($this->pageNavigation);
        
        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
        // dividindo search do datagrid
        $vbox->add($this->form);
        $vbox->add($panel);
        
        parent::add( $vbox );
    }
    
    public function onSearch($param)
    {
        // guarda search na sessão para que se mantenha mesmo com paginação
        $data = $this->form->getData();
        
        if (isset($data->nome))
        {
            $filter = new TFilter('nome', 'like', "%{$data->nome}%");
            // criando var de sessão
            TSession::setValue('CidadeList_filter', $filter);
            TSession::setValue('CidadeList_nome', $data->nome);
            // deixa preenchido após busca
            $this->form->setData($data);
        }
        
        $this->onReload( [] );
    }
    // carrega registros ao clicar na paginação
    public function onReload($param)
    {
        try
        {
            TTransaction::open('curso');
            
            $repository = new TRepository('Cidade');
            
            // verificar se vai usar ordem padrão (id asc)
            if (empty($param['order']))
            {
                $param['order'] = 'id';
                $param['direction'] = 'asc';
            }
            
            $limit = 10;
            
            $criteria = new TCriteria;
            $criteria->setProperty('limit', $limit);
            $criteria->setProperties($param);
            
            // verifica se tem conteúdo na sessão
            if (TSession::getValue('CidadeList_filter'))
            {
                $criteria->add(TSession::getValue('CidadeList_filter'));
            }
            
            $cidades = $repository->load( $criteria );
            
            $this->datagrid->clear();
            if ($cidades)
            {
                foreach ($cidades as $cidade)
                {
                    $this->datagrid->addItem($cidade);
                }
            }
            
            // limpa group, limit, order, offset p/ que conte todos registros (ñ apenas paginação)
            $criteria->resetProperties();
            $count = $repository->count($criteria);
            
            $this->pageNavigation->setCount($count);
            // configura todos parâmetros (limit, order, offset)
            $this->pageNavigation->setProperties($param);
            $this->pageNavigation->setLimit($limit);
            
            $this->loaded = true;
            TTransaction::close();
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }
    
    public static function onDelete($param)
    {
        $action = new TAction( [__CLASS__, 'Delete'] );
        // passando parâmetros para o método Delete()
        $action->setParameters($param);
        new TQuestion('Deseja excluir o registro?', $action);
    }
    
    public static function Delete($param)
    {
        try
        {
            TTransaction::open('curso');
            
            $key = $param['key'];
            
            $cidade = new Cidade;
            $cidade->delete($key);
            
            $pos_action = new TAction([__CLASS__, 'onReload']);
            // executa $pos_action (recarregar página) após OK
            new TMessage('info', 'Registro excluído', $pos_action);
            
            TTransaction::close();
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
    }
    
    function show()
    {
        // se não carregou datagrid: carregar
        if (!$this->loaded)
        {
            $this->onReload( func_get_arg(0) );
        }
        parent::show();
    }
}