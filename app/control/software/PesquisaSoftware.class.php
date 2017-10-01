<?php
/** 
 * Esser Relatorio exibi dados da tabela system_militar
 * @copyright (c) 2016, Apolonio S. S. Junior ICRIACOES Sistemas Web!s - 2ºSgt Santiago
 * @email apolocomputacao@gmail.com
 */
class PesquisaSoftware extends TStandardList
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
        
        parent::setDatabase('permission');                // defines the database
        parent::setActiveRecord('Software');            // defines the active record
        parent::setDefaultOrder('codSoft', 'asc');          // defines the default order
        parent::addFilterField('codTipoSoft', 'like'); // add a filter field
        parent::addFilterField('codTipoSoftLicenca', 'like'); // add a filter field
        parent::addFilterField('descricao', 'like'); // add a filter field

        
        // creates the form, with a table inside
        $this->form = new TQuickForm('form_search_software');
        $this->form->class = 'tform';
        $this->form->style = 'width: 650px';
        $this->form->setFormTitle('Pesquisando Software');
   
            //Criando os campos
        $codTipoSoft = new \Adianti\Widget\Wrapper\TDBCombo('codTipoSoft','permission','TipoSoftware','descricaoTipoSoft','descricaoTipoSoft');
        $codTipoLicencaSoft = new \Adianti\Widget\Wrapper\TDBCombo('codTipoSoftLicenca','permission','TipoLicencaSoftware','descricaoTipoLicencaSoft','descricaoTipoLicencaSoft');
        $descricao = new TEntry('descricao');
        $documento = new TEntry('documento');
        $boletim = new TEntry('boletim');
        $qtde = new TEntry('qtde');
        $valorUnitario = new TEntry('valorUnitario');
        $serial = new TEntry('serial');
        $licenca = new TEntry('licenca');
        $versao = new TEntry('versao');
        $data = new TEntry('dataCad');
        
        
           // Campos que aparecem na pesquisa
        $this->form->addQuickField('Tipo Soft', $codTipoSoft, 250);
        $this->form->addQuickField('Tipo Licença', $codTipoLicencaSoft, 250);
        $this->form->addQuickField('Descrição', $descricao, 250);
           
        $this->form->setData( TSession::getValue('Product_filter_data') );
        $this->form->addQuickAction( 'Pesquisar', new TAction(array($this, 'onSearch')), 'ico_find.png');
        $this->form->addQuickAction( 'Novo',  new TAction(array('SoftwareForm', 'onEdit')), 'ico_new.png');
        
        // Criação Datagrid
        $this->datagrid = new TQuickGrid;
        $this->datagrid->setHeight(420);

        // Colunas da Datagrid
        $codSoft = $this->datagrid->addQuickColumn('ID', 'codSoft', 'center', 50);
        $codTipoSoft = $this->datagrid->addQuickColumn('Tipo', 'codTipoSoft', 'center', 130);
        $codTipoLicencaSoft = $this->datagrid->addQuickColumn('Licença', 'codTipoSoftLicenca', 'center', 100);
        $descricao = $this->datagrid->addQuickColumn('Descrição', 'descricao', 'left', 200);
        $documento = $this->datagrid->addQuickColumn('Documento', 'documento', 'left', 100);
        $boletim = $this->datagrid->addQuickColumn('Boletim', 'boletim', 'left', 200);
        $qtde = $this->datagrid->addQuickColumn('QTD', 'qtde', 'left', 50);
        $versao = $this->datagrid->addQuickColumn('Versão', 'versao', 'left', 50);
        $licenca = $this->datagrid->addQuickColumn('Licença', 'licenca', 'left', 50);
        $serial = $this->datagrid->addQuickColumn('Serial', 'serial', 'left', 200);
        $data = $this->datagrid->addQuickColumn('Data', 'dataCad', 'left', 60);
  
       
        
        // create the datagrid actions
        $edit_action   = new TDataGridAction(array('SoftwareForm', 'onEdit'));
        $delete_action = new TDataGridAction(array($this, 'onDelete'));
        
        // add the actions to the datagrid
        $this->datagrid->addQuickAction(_t('Edit'), $edit_action, 'codSoft', 'ico_edit.png');
        $this->datagrid->addQuickAction(_t('Delete'), $delete_action, 'codSoft', 'ico_delete.png');
        
        // create the datagrid model
        $this->datagrid->createModel();
        
        // create the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());
        
        // create the page container
        $container = new TVBox;
        $container->add(new TXMLBreadCrumb('menu.xml', 'PesquisaSoftware'));
        $container->add($this->form);
        $container->add($this->datagrid);
        $container->add($this->pageNavigation);
        
        parent::add($container);
    }
}
?>



