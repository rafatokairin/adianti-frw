<?php
class ClienteForm extends TPage
{
    private $form;
    private $contatos;
    
    public function __construct()
    {
        parent::__construct();
        
        parent::setTargetContainer('adianti_right_panel');
        
        $this->form = new BootstrapFormBuilder('form_cliente');
        $this->form->setFormTitle('Cliente');
        
        $id   = new TEntry('id');
        $nome = new TEntry('nome');
        $endereco = new TEntry('endereco');
        $telefone  = new TEntry('telefone');
        $cidade_id  = new TDBUniqueSearch('cidade_id', 'curso', 'Cidade', 'id', 'nome');
        $nascimento = new TDate('nascimento');
        $email = new TEntry('email');
        $genero = new TRadioGroup('genero');
        $situacao = new TCombo('situacao');
        $categoria_id = new TDBCombo('categoria_id', 'curso', 'Categoria', 'id', 'nome');
        
        $genero->addItems( ['M' => 'Masculino', 'F' => 'Feminino'] );
        $situacao->addItems( [ 'Y' => 'Ativo', 'N' => 'Inativo' ] );
        $genero->setLayout('horizontal');
        $id->setEditable(false);
        $id->setSize('30%');
        $cidade_id->setSize('100%');
        $nascimento->setSize('100%');
        $situacao->setSize('100%');
        $genero->setSize('100%');
        $situacao->enableSearch();
        $categoria_id->enableSearch();
        $cidade_id->setMinLength(0);
        // botão invés de checkbox
        $genero->setUseButton();
        $cidade_id->setMask('{nome} <b> {estado->nome} </b>');
        
        // criando abas na cortina
        $this->form->appendPage('Dados básicos');
        $this->form->addFields( [new TLabel('Id')], [$id] );
        $this->form->addFields( [new TLabel('Nome')], [$nome] );
        $this->form->addFields( [new TLabel('Endereço')], [$endereco] );
        $this->form->addFields( [new TLabel('Cidade')], [$cidade_id] );
        $this->form->addFields( [new TLabel('Telefone')], [$telefone],
                                [new TLabel('Nascimento')], [$nascimento]);
        $this->form->addFields( [new TLabel('Situacao')], [$situacao],
                                [new TLabel('Email')], [$email]);
        $this->form->addFields( [new TLabel('Categoria')], [$categoria_id],
                                [new TLabel('Gênero')], [$genero]);
                                
        $this->form->appendPage('Habilidades');
        $habilidades = new TDBCheckGroup('lista_habilidades', 'curso', 'Habilidade', 'id', 'nome');
        $this->form->addFields( [new TLabel('Habilidades')], [$habilidades] );
        
        
        $this->form->appendPage('Contatos');
        // vetor de dados Field List
        $this->contatos = new TFieldList;
        $contato_tipo  = new TCombo('contato_tipo[]');
        $contato_valor = new TEntry('contato_valor[]');
        
        $contato_tipo->setSize('100%');
        $contato_valor->setSize('100%');
        $contato_tipo->addItems( ['email' => 'E-mail', 'telefone' => 'Telefone'] );
        
        $this->contatos->addField( '<b>Tipo</b>',   $contato_tipo,  ['width' => '50%'] );
        $this->contatos->addField( '<b>Valor</b>',  $contato_valor, ['width' => '50%'] );
        
        $this->form->addField( $contato_tipo );
        $this->form->addField( $contato_valor );
        $this->contatos->enableSorting();
        
        $this->form->addContent( [new TLabel('Contatos')], [$this->contatos] );
        
        $this->form->addAction( 'Salvar', new TAction([$this, 'onSave']), 'fa:save green');
        $this->form->addHeaderActionLink( 'Fechar', new TAction( [$this, 'onClose']), 'fa:times red');
        
        parent::add($this->form);
    
    }
    
    public static function onSave($param)
    {
        try
        {
            TTransaction::open('curso');
            $cliente = new Cliente;
            $cliente->fromArray( $param );
            $cliente->store();
            
            // deleta e salva de novo dados
            Contato::where('cliente_id', '=', $cliente->id)->delete();
            ClienteHabilidade::where('cliente_id', '=', $cliente->id)->delete();
            
            // checkbox vem no formato de lista e salva cada habilidade
            if (!empty($param['lista_habilidades']))
            {
                foreach ($param['lista_habilidades'] as $habilidade_id)
                {
                    $cliente_habilidade = new ClienteHabilidade;
                    $cliente_habilidade->habilidade_id = $habilidade_id;
                    $cliente_habilidade->cliente_id = $cliente->id;
                    $cliente_habilidade->store();
                }
            }
            
            if (!empty($param['contato_tipo']) && is_array($param['contato_tipo']))
            {
                foreach ($param['contato_tipo'] as $row => $contato_tipo)
                {
                    if ($contato_tipo)
                    {
                        $contato = new Contato;
                        $contato->cliente_id = $cliente->id;
                        $contato->tipo  = $contato_tipo;
                        // contato_tipo e contato_valor no mesmo índice
                        $contato->valor = $param['contato_valor'][$row];
                        $contato->store();
                    }
                }
            }
            
            // depois de gerar o id, mandar para tela
            $data = new stdClass;
            $data->id = $cliente->id;
            TForm::sendData('form_cliente', $data);
            
            // depois de salvar fecha panel cortina
            TScript::create('Template.closeRightPanel()');
            
            $pos_action = new TAction( ['ClienteList', 'onReload'] );
            
            new TMessage('info', 'Registro gravado com sucesso', $pos_action);
            
            TTransaction::close();
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }
    
    // limpar formulário
    public function onClear($param)
    {
        $this->form->clear();
        // criar Field List limpo
        $this->contatos->addHeader();
        $this->contatos->addDetail( new stdClass );
        // botão que clona linha (+)
        $this->contatos->addCloneAction();
    }
    
    public function onEdit($param)
    {
        try
        {
            if (isset($param['key']))
            {
                TTransaction::open('curso');
                
                $cliente = new Cliente($param['key']);
                
                $contatos = Contato::where('cliente_id', '=', $cliente->id)->load();
                
                // carregar dados Field List
                if ($contatos)
                {
                    $this->contatos->addHeader();
                    foreach ($contatos as $contato)
                    {
                        $objeto = new stdClass;
                        $objeto->contato_tipo  = $contato->tipo;
                        $objeto->contato_valor = $contato->valor;
                        $this->contatos->addDetail($objeto);
                    }
                    $this->contatos->addCloneAction();
                }
                else
                {
                    $this->onClear($param);
                }
                
                /**
                 * tenta buscar nome tabelas:
                 * INÍCIO: cliente
                 * MEIO (infere): cliente_habilidade - com campos cliente_id e habilidade_id
                 * PONTA: habilidade
                 * 
                 * obs: se for diferente, precisa preencher classe de JOIN e chave estrangeira
                 */
                $habilidades = $cliente->belongsToMany('Habilidade');
                
                $lista_habilidades = [];
                if ($habilidades)
                {
                    foreach ($habilidades as $habilidades)
                    {
                        $lista_habilidades[] = $habilidades->id;
                    }
                }
                
                $cliente->lista_habilidades = $lista_habilidades;
                $this->form->setData( $cliente );
                
                TTransaction::close();
            }
            else
            {
                $this->onClear($param);
            }
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }
    
    public static function onClose($param)
    {
        TScript::create('Template.closeRightPanel()');
    }
}
