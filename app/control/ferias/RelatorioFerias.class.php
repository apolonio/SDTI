<?php
/** 
 * Esser Relatorio exibi dados da tabela system_FERIAS e permiti exportar arquivo csv(excel)
 * class CustomerDataGridView extends TPage
 * @copyright (c) 2016, Apolonio S. S. Junior ICRIACOES Sistemas Web!s - 2ºSgt Santiago
 * @email apolocomputacao@gmail.com
 */
class RelatorioFerias extends TPage
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
        $codF=$this->datagrid->addQuickColumn('Id',    'codF',    'right', 30);
        $this->datagrid->addQuickColumn('Nome',    'codMilitar',    'left', 220);
        $this->datagrid->addQuickColumn('Ano',   'ano',    'left', 50);
        $this->datagrid->addQuickColumn('1ºPer.',   'per1',    'left', 50);
        $this->datagrid->addQuickColumn('2ºPer.',   'per2',    'left', 50);
        $this->datagrid->addQuickColumn('3ºPer.',   'per3',    'left', 50);
        $this->datagrid->addQuickColumn('4ºPer.',   'per4',    'left', 50);
        $this->datagrid->addQuickColumn('Data I',   'dataI',    'left', 100);
        $this->datagrid->addQuickColumn('Data T',   'dataT',    'left', 100);
        $this->datagrid->addQuickColumn('Boletim    ',   'bol1',    'left', 160);

       // DATE_FORMAT(data, '%d/%m/%y')
        
//        $this->datagrid->addQuickColumn('Telefone1',   'telefone1',    'left', 120);
//        $this->datagrid->addQuickColumn('Telefone2',   'telefone2',    'left', 120);
        
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
            $repository = new TRepository('Ferias');
            
            // creates a criteria, ordered by id
            $criteria = new TCriteria;
            $order    = isset($param['order']) ? $param['order'] : 'codF';
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
        new TMessage('info', "Férias : $key");
    }
    

}
?>
