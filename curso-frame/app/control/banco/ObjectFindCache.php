<?php
class ObjectFindCache extends TPage
{
    public function __construct()
    {
        parent::__construct();
        
        try
        {
            TTransaction::open('curso');
            TTransaction::dump();
            
            // Cidade::preCache( Cidade::all() );
            
            $clientes = Cliente::all();
            
            if ($clientes)
            {
                foreach ($clientes as $cliente)
                {
                    echo $cliente->nome . ' - ';
                    $cidade = Cidade::findCache($cliente->cidade_id);
                    echo $cidade->nome;
                    echo '<br>';
                }
            }
            TTransaction::close();
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }
}