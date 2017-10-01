<?php
/** 
 * Esser Relatorio exibi dados da tabela system_militar e permiti exportar arquivo csv(excel)
 * class CustomerDataGridView extends TPage
 * @copyright (c) 2016, Apolonio S. S. Junior ICRIACOES Sistemas Web!s - 2ºSgt Santiago
 * @email apolocomputacao@gmail.com
 */
class RelatorioMilitar extends TPage
{
    private $datagrid;
    
    public function __construct()
    {
        parent::__construct();
        
        // creates one datagrid
        $this->datagrid = new TQuickGrid;
        $this->datagrid->setHeight(320);
        
        // define the CSS class
        $this->datagrid->class='tdatagrid_table customized-table';
        // import the CSS file
        parent::include_css('app/resources/custom-table.css');

        // add the columns
        $this->datagrid->addQuickColumn('Id',    'id',    'right', 30);
        $this->datagrid->addQuickColumn('P/G',    'pg',    'left', 100);
        $this->datagrid->addQuickColumn('Arma',    'arma',    'left', 100);
        $this->datagrid->addQuickColumn('Nome',    'nome',    'left', 220);
        $this->datagrid->addQuickColumn('Guerra', 'nomeGuerra', 'left', 180);
        
       // $this->datagrid->addQuickColumn('Força',   'forca',    'left', 160);
        $this->datagrid->addQuickColumn('SU',   'secao',    'left', 160);
        $this->datagrid->addQuickColumn('Fração',   'reparticao',    'left', 160);
        
        
        $this->datagrid->addQuickColumn('identidade',   'identidade',    'left', 160);
        $this->datagrid->addQuickColumn('CPF',   'cpf',    'left', 160);
        $this->datagrid->addQuickColumn('Prec-CP',   'preccp',    'left', 160);
        $this->datagrid->addQuickColumn('Nascimento',   'dataNascimento',    'left', 100);
        $this->datagrid->addQuickColumn('Promoção',   'dataPromocao',    'left', 100);
       // DATE_FORMAT(data, '%d/%m/%y')
        
        $this->datagrid->addQuickColumn('Telefone1',   'telefone1',    'left', 120);
        $this->datagrid->addQuickColumn('Telefone2',   'telefone2',    'left', 120);
        
        //$this->datagrid->addQuickAction('View',   new TDataGridAction(array($this, 'onView')),   'nome', 'ico_find.png');
                
        // creates the datagrid model
        $this->datagrid->createModel();
        
        // wrap the page content using vertical box
        $vbox = new TVBox;
        $vbox->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $vbox->add($this->datagrid);

        parent::add($vbox);
    }
    
     function onReload($param = NULL)
    {
        try
        {
            // open a transaction with database 'samples'
            TTransaction::open('permission');
            
            // creates a repository for Category
            $repository = new TRepository('Militar');
            
            // creates a criteria, ordered by id
            $criteria = new TCriteria;
            $order    = isset($param['order']) ? $param['order'] : 'id';
            $criteria->setProperty('order', $order);
            
            // load the objects according to criteria
            $categories = $repository->load($criteria);
            $this->datagrid->clear();
            if ($categories)
            {
                // iterate the collection of active records
                foreach ($categories as $category)
                {
                    // add the object inside the datagrid
                    $this->datagrid->addItem($category);
                }
            }
            // close the transaction
            TTransaction::close();
            $this->loaded = true;
        }
        catch (Exception $e) // in case of exception
        {
            // shows the exception error message
            new TMessage('error', '<b>Error</b> ' . $e->getMessage());
            // undo all pending operations
            TTransaction::rollback();
        }
    }
        
    /**
     * method show()
     * Shows the page e seu conteúdo
     */
    function show()
    {
        // check if the datagrid is already loaded
        if (!$this->loaded)
        {
            $this->onReload( func_get_arg(0) );
        }
        parent::show();
    }

    /**
     * method onView()
     * Executed when the user clicks at the view button
     */
    function onView($param)
    {
        // get the parameter and shows the message
        $key=$param['key'];
        new TMessage('info', "Militar : $key");
    }
    

}
?>
