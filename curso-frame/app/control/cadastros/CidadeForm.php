<?php
class CidadeForm extends TPage
{
    private $form;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->form = new BootstrapFormBuilder;
        $this->form->setFormTitle('Cidade');
        // ativar validação (client side)
        $this->form->setClientValidation( true );
        
        $id  = new TEntry('id');
        $nome = new TEntry('nome');
        // dropdown
        $estado = new TDBCombo('estado_id', 'curso', 'Estado', 'id', 'nome');
        $id->setEditable(FALSE);
        
        /**
         * atributo default
         * $nome->setValue('default');
         */
        
        $this->form->addFields( [new TLabel('Id')], [$id] );
        $this->form->addFields( [new TLabel('Nome', 'red')], [$nome] );
        $this->form->addFields( [new TLabel('Estado', 'red')], [$estado] );
        // campos obrigatórios
        $nome->addValidation('Nome', new TRequiredValidator);
        $estado->addValidation('Estado', new TRequiredValidator);
        
        $this->form->addAction('Salvar', new TAction( [$this, 'onSave'] ), 'fa:save green');
        $this->form->addActionLink('Limpar', new TAction( [$this, 'onClear'] ), 'fa:eraser red');
        
        parent::add($this->form);
    }
    
    public function onClear()
    {
        // limpa campos form (true mantém atributos default)
        $this->form->clear(true);
    }
    
    public function onSave($param)
    {
        try
        {
            // conector
            TTransaction::open('curso');
            // obriga usuário preencher todos os campos
            $this->form->validate();
            
            $data = $this->form->getData();
            // classe
            $cidade = new Cidade;
            $cidade->fromArray( (array) $data);
            $cidade->store();
            // traz objeto com id (update)
            $this->form->setData( $cidade );
            
            new TMessage('info', 'Registro salvo com sucesso');
            
            TTransaction::close();
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
    }
    
    public function onEdit($param)
    {
        try
        {
            TTransaction::open('curso');
            // edita com parâmetro key na URL
            if (isset($param['key']))
            {
                $key = $param['key'];
                $cidade = new Cidade($key);
                $this->form->setData($cidade);
            }
            else
            {
                $this->form->clear(true);
            }
            
            TTransaction::close();
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
    }
}