<?php
/** 
 * Esser Relatorio exibi dados da tabela system_militar
 * @copyright (c) 2016, Apolonio S. S. Junior ICRIACOES Sistemas Web!s - 2ºSgt Santiago
 * @email apolocomputacao@gmail.com
 */
class PesquisaMilitar extends TStandardList
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
        parent::setActiveRecord('Militar');           
        parent::setDefaultOrder('id', 'asc');         
        parent::addFilterField('nome', 'like'); 
        parent::addFilterField('nomeGuerra', 'like'); 
        parent::addFilterField('pg', '='); 
        parent::addFilterField('om', '='); 
        parent::addFilterField('arma', '='); 
        parent::addFilterField('secao', '='); 
        parent::addFilterField('reparticao', '='); 
        
        // creates the form, with a table inside
        $this->form = new TQuickForm('form_search_militar');
        $this->form->class = 'tform';
        $this->form->style = 'width: 650px';
        $this->form->setFormTitle('Dados Militar');
   

        //Criando os campos
        $nome = new TEntry('nome');
        $guerra = new TEntry('nomeGuerra');
        $pg = new TDBCombo('pg','permission','Posto','sigla','sigla');
        $arma = new TDBCombo('arma','permission','Arma','sigla','sigla');
        $om= new TDBCombo('abreviatura','permission','Om','id','abreviatura');
        $su = new Adianti\Widget\Wrapper\TDBCombo('sigla','permission','Su','id','sigla');
        $subunidade = new Adianti\Widget\Wrapper\TDBCombo('descricao','permission','Subunidade','id','descricao');
        

        // add a row for the filter field        $this->form->addQuickField('SU', $su, 200);
        $this->form->addQuickField('Nome', $nome, 200);
        $this->form->addQuickField('Guerra', $guerra, 200);
        $this->form->addQuickField('PG', $pg, 200);
        $this->form->addQuickField('Arma', $arma, 200);
        $this->form->addQuickField('OM', $om, 200);
        $this->form->addQuickField('SU', $su, 200);
        $this->form->addQuickField('Subunidade', $subunidade, 200);
        
        
        $this->form->setData( TSession::getValue('Militar_filter_data') );
        $this->form->addQuickAction( _t('Find'), new TAction(array($this, 'onSearch')), 'ico_find.png');
      //  $this->form->addQuickAction( _t('New'),  new TAction(array('MilitarForm', 'onEdit')), 'ico_new.png');
        
        // creates a DataGrid
        $this->datagrid = new TQuickGrid;
        $this->datagrid->setHeight(420);

        // creates the datagrid columns
        $id = $this->datagrid->addQuickColumn('ID', 'id', 'center', 50);
        $pg= $this->datagrid->addQuickColumn('P/G', 'pg', 'center', 50);
        $arma= $this->datagrid->addQuickColumn('Arma', 'arma', 'center', 60);
        $nome = $this->datagrid->addQuickColumn('Nome', 'nome', 'left', 300);
        $guerra = $this->datagrid->addQuickColumn('Guerra', 'nomeGuerra', 'left', 150);
        $om = $this->datagrid->addQuickColumn('OM', 'om', 'left', 100);
        $su = $this->datagrid->addQuickColumn('SU', 'secao', 'left', 100);
        $subunidade = $this->datagrid->addQuickColumn('Seção', 'reparticao', 'left', 100);
        $identidade = $this->datagrid->addQuickColumn('Identidade', 'identidade', 'left', 100);
        $cpf = $this->datagrid->addQuickColumn('CPF', 'cpf', 'left', 100);
        $preccp = $this->datagrid->addQuickColumn('Prec-CP', 'preccp', 'left', 100);
  
       
        
        // create the datagrid actions
        $edit_action   = new TDataGridAction(array('MilitarForm', 'onEdit'));
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
        $container->add(new TXMLBreadCrumb('menu.xml', 'PesquisaMilitar'));
        $container->add($this->form);
        $container->add($this->datagrid);
        $container->add($this->pageNavigation);
        
        parent::add($container);
    }
}
?>


