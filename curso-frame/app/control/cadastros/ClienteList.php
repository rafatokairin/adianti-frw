<?php
class ClienteList extends TPage
{
    private $datagrid;
    private $pageNavigation;
    
    use Adianti\Base\AdiantiStandardListTrait;    
    
    public function __construct()
    {
        parent::__construct();
        
        $this->setDatabase('curso');
        $this->setActiveRecord('Cliente');
        $this->setDefaultOrder('id', 'asc');
        // relaciona search com colunas
        $this->addFilterField('id', '=', 'id');
        $this->addFilterField('nome', 'like', 'nome');
        $this->addFilterField('endereco', 'like', 'endereco');
        $this->addFilterField('genero', '=', 'genero');
        $this->addFilterField('(SELECT nome from cidade where cidade.id = cidade_id)', 'like', 'cidade');
        // subselect para order
        $this->setOrderCommand('city->name', '(select nome from cidade where cidade_id = cidade.id)');
        
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'width:100%';
        
        $col_id       = new TDataGridColumn('id', 'Cód', 'center', '10%');
        $col_nome     = new TDataGridColumn('nome', 'Nome', 'left', '28%');
        $col_endereco = new TDataGridColumn('endereco', 'Endereço', 'left', '28%');
        // usando get_cidade
        $col_cidade   = new TDataGridColumn('{cidade->nome} ({cidade->estado->nome})', 'Cidade', 'left', '28%');
        $col_genero   = new TDataGridColumn('genero', 'Gênero', 'center', '6%');
        
        $col_id->setAction( new TAction([$this, 'onReload']), ['order' => 'id'] );
        $col_nome->setAction( new TAction([$this, 'onReload']), ['order' => 'nome'] );
        $col_endereco->setAction( new TAction([$this, 'onReload']), ['order' => 'endereco'] );
        // usar setOrderCommand() para ele saber nome da cidade
        $col_cidade->setAction( new TAction([$this, 'onReload']), ['order' => 'city->name'] );
        
        $this->datagrid->addColumn($col_id);
        $this->datagrid->addColumn($col_nome);
        $this->datagrid->addColumn($col_endereco);
        $this->datagrid->addColumn($col_cidade);
        $this->datagrid->addColumn($col_genero);
        
        // função lambda de transformação
        $col_genero->setTransformer( function($genero) {
            return $genero == 'F' ? 'Feminino' : 'Masculino';
        });
        
        // criar cortina edit, que vem da classe ClienteForm (register_state: false mantém na mesma página)
        $action1 = new TDataGridAction( ['ClienteForm', 'onEdit'], ['key' => '{id}', 'register_state' => 'false'] );
        // criar botão delete
        $action2 = new TDataGridAction( [$this, 'onDelete'], ['key' => '{id}']);
        
        $this->datagrid->addAction($action1, 'Editar', 'fa:edit blue');
        $this->datagrid->addAction($action2, 'Excluir', 'fa:trash-alt red');
        
        // criando estrutura datagrid
        $this->datagrid->createModel();
        
        // encapsulando em form simples
        $this->form = new TForm;
        $this->form->add($this->datagrid);
        
        $id       =  new TEntry('id');
        $nome     =  new TEntry('nome');
        $endereco =  new TEntry('endereco');
        $cidade   =  new TEntry('cidade');
        $genero   =  new TCombo('genero');
        
        $genero->addItems( [ 'M' => 'Masculino', 'F' => 'Feminino' ] );
        
        // sai dos campos após Enter
        $id->exitOnEnter();
        $nome->exitOnEnter();
        $endereco->exitOnEnter();
        $cidade->exitOnEnter();
        
        $id->setSize('100%');
        $nome->setSize('100%');
        $endereco->setSize('100%');
        $cidade->setSize('100%');
        
        // não muda para outro campo após Enter
        $id->tabindex = -1;
        $nome->tabindex = -1;
        $endereco->tabindex = -1;
        $cidade->tabindex = -1;
        $genero->tabindex = -1;
        
        // dispara busca para um campo (quando ele sai)
        $id->setExitAction( new TAction( [ $this, 'onSearch' ], ['static' => '1']) );
        $nome->setExitAction( new TAction( [ $this, 'onSearch' ], ['static' => '1']) );
        $endereco->setExitAction( new TAction( [ $this, 'onSearch' ], ['static' => '1']) );
        $cidade->setExitAction( new TAction( [ $this, 'onSearch' ], ['static' => '1']) );
        $genero->setChangeAction( new TAction( [ $this, 'onSearch' ], ['static' => '1']) );
        
        // tabela para campos search
        $tr = new TElement('tr');
        // cria linha separação
        $this->datagrid->prependRow($tr);
        $tr->add( TElement::tag('td', '') );
        $tr->add( TElement::tag('td', '') );
        $tr->add( TElement::tag('td', $id) );
        $tr->add( TElement::tag('td', $nome) );
        $tr->add( TElement::tag('td', $endereco) );
        $tr->add( TElement::tag('td', $cidade) );
        $tr->add( TElement::tag('td', $genero) );
        
        $this->form->addField($id);
        $this->form->addField($nome);
        $this->form->addField($endereco);
        $this->form->addField($cidade);
        $this->form->addField($genero);
        
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );
        
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction( new TAction( [$this, 'onReload'] ));
        $this->pageNavigation->enableCounters();
        
        $panel = new TPanelGroup('Clientes');
        $panel->add($this->form);
        $panel->addFooter($this->pageNavigation);
        
        // Trait aplica métodos export
        $dropdown = new TDropDown('Exportar', 'fa:list');
        $dropdown->setButtonClass('btn btn-default waves-effect dropdown-toggle');
        $dropdown->addAction( 'Salvar como CSV', new TAction([$this, 'onExportCSV'], ['register_state' => 'false', 'static'=>'1']), 'fa:table fa-fw blue' );
        $dropdown->addAction( 'Salvar como PDF', new TAction([$this, 'onExportPDF'], ['register_state' => 'false', 'static'=>'1']), 'far:file-pdf fa-fw red' );
        $dropdown->addAction( 'Salvar como XML', new TAction([$this, 'onExportXML'], ['register_state' => 'false', 'static'=>'1']), 'fa:code fa-fw green' );
        
        $panel->addHeaderWidget($dropdown);
        $panel->addHeaderActionLink('Novo', new TAction(['ClienteForm', 'onClear'], ['register_state'=>'false']), 'fa:plus green');
        
        parent::add( $panel );
    }
}