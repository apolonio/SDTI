<?php
/** 
 * Esser Relatorio exibi dados da tabela system_militar
 * @copyright (c) 2016, Apolonio S. S. Junior ICRIACOES Sistemas Web!s - 2ºSgt Santiago
 * @email apolocomputacao@gmail.com
 */
class PesquisaHardware extends TStandardList
{
    protected $form;     // registration form
    protected $datagrid; // listing
    protected $pageNavigation;
    
    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct()
    {
        parent::__construct();
        
        parent::setDatabase('permission');                
        parent::setActiveRecord('Hardware');           
        parent::setDefaultOrder('id', 'desc');         
        parent::addFilterField('dti', 'like');
        parent::addFilterField('trem', 'like'); 
        parent::addFilterField('diex', 'like'); 
        parent::addFilterField('boletim', 'like'); 
        parent::addFilterField('om', 'like'); 
        parent::addFilterField('marca', 'like'); 
        parent::addFilterField('modelo', 'like'); 

 
     
        
        // creates the form, with a table inside
        $this->form = new TQuickForm('Hard_search_militar');
        $this->form->class = 'tform';
        $this->form->style = 'width: 650px';
        $this->form->setFormTitle('Dados do Material');
   

        //Criando os campos
        $dti = new TEntry('dti');
        $om = new TDBCombo('om','permission','Om','abreviatura','abreviatura');
        $om->setSize(200);
        $trem = new TEntry('trem');
        $trem->setSize(200);
        $boletim = new TEntry('boletim');
        $boletim->setSize(200);
        $diex = new TEntry('diex');
        $diex->setSize(200);
        $ficha = new TEntry('ficha');
        $ficha->setSize(200);
        $marca = new TEntry('marca');
        $marca->setSize(200);
        //$arma = new TDBCombo('arma','permission','Arma','sigla','sigla');
        //$arma->setSize(100);
        $modelo = new TEntry('modelo');
        $modelo->setSize(200);
        $descricao = new \Adianti\Widget\Form\TText('descricao');
        $descricao->setSize(200);
       
        
        $data = new TDate('dataHard');
        $data->setMask('dd/mm/yyyy');
        $data->setDatabaseMask('yyyy-mm-dd');
        $data->setSize(80);
        

        // add a row for the filter field        $this->form->addQuickField('SU', $su, 200);
        $this->form->addQuickField('DTI', $dti, 200);
        $this->form->addQuickField('TREM', $trem, 200);
        $this->form->addQuickField('Diex', $diex, 200);
        $this->form->addQuickField('OM', $om, 200);
        $this->form->addQuickField('Marca', $marca, 200);
        $this->form->addQuickField('Modelo', $modelo, 200);
//        $this->form->addQuickField('Data', $data, 100);
//        $this->form->addQuickField('Descrição', $descricao, 300);
        
        
        $this->form->setData( TSession::getValue('Hard_filter_data') );
        $this->form->addQuickAction( 'Pesquisar', new TAction(array($this, 'onSearch')), 'ico_find.png');
  //      $this->form->addQuickAction( 'Editar',  new TAction(array('HardwareForm', 'onEdit')), 'ico_new.png');
        
        // creates a DataGrid
        $this->datagrid = new TQuickGrid;
        $this->datagrid->setHeight(420);

        // creates the datagrid columns
        $id = $this->datagrid->addQuickColumn('ID', 'id', 'center', 50);
        $dti= $this->datagrid->addQuickColumn('DTI', 'dti', 'center', 50);
        $patrimonio= $this->datagrid->addQuickColumn('Patr', 'patrimonio', 'center', 60);
        $nrSerie= $this->datagrid->addQuickColumn('Nr.Série', 'nrSerie', 'center', 60);
        $ficha = $this->datagrid->addQuickColumn('Ficha', 'ficha', 'left', 100);
        $boletim = $this->datagrid->addQuickColumn('Boletim', 'boletim', 'left', 100);
        $trem = $this->datagrid->addQuickColumn('TREM', 'trem', 'left', 100);
        $diex = $this->datagrid->addQuickColumn('DIEx', 'diex', 'left', 100);
        $marca = $this->datagrid->addQuickColumn('OM', 'om', 'left', 300);
        $marca = $this->datagrid->addQuickColumn('Seção', 'secao', 'left', 300);
        $marca = $this->datagrid->addQuickColumn('Marca', 'marca', 'left', 300);
        $modelo = $this->datagrid->addQuickColumn('Modelo', 'modelo', 'left', 150);
        $data = $this->datagrid->addQuickColumn('Data', 'dataHard', 'left', 100);
        $descricao = $this->datagrid->addQuickColumn('Descrição', 'descricao', 'left', 100);
  
       
        
        // create the datagrid actions
        $edit_action   = new TDataGridAction(array('HardwareForm', 'onEdit'));
        $delete_action = new TDataGridAction(array($this, 'onDelete'));
        
        // add the actions to the datagrid
        $this->datagrid->addQuickAction(_t('Edit'), $edit_action, 'id', 'ico_edit.png');
        $this->datagrid->addQuickAction(_t('Delete'), $delete_action, 'id', 'ico_delete.png');
        
        // create the datagrid model
        $this->datagrid->createModel();
        
        // create the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());
        
        // create the page container
        $container = new TVBox;
        $container->add(new TXMLBreadCrumb('menu.xml', 'PesquisaHardware'));
        $container->add($this->form);
        $container->add($this->datagrid);
        $container->add($this->pageNavigation);
        
        parent::add($container);
    }
}
?>


