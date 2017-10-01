<?php
/** 
 * Esser Relatorio exibi dados da tabela system_militar
 * @copyright (c) 2016, Apolonio S. S. Junior ICRIACOES Sistemas Web!s - 2ºSgt Santiago
 * @email apolocomputacao@gmail.com
 */
class RelatorioSoftware extends TStandardList
{
    protected $form;    
    protected $datagrid; 
    protected $pageNavigation;
    
    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct()
    {
        parent::__construct();
        
        parent::setDatabase('permission');                
        parent::setActiveRecord('Software');           
        parent::setDefaultOrder('codSoft', 'asc');          
        parent::addFilterField('codTipoSoft', 'like'); 
        parent::addFilterField('codTipoSoftLicenca', 'like'); 
        parent::addFilterField('descricao', 'like'); 

        
        // creates the form, with a table inside
        $this->form = new TQuickForm('form_search_software');
        $this->form->class = 'tform';
        $this->form->style = 'width: 650px';
        $this->form->setFormTitle('Software');
   

        //Criando os campos
        $codTipoSoft = new TEntry('codTipoSoft');
        $codTipoSoftLicenca = new TDate('codTipoSoftLicenca');
        $descricao = new TCombo('descricao');
        $documento = new TEntry('documento');
        $boletim = new TEntry('boletim');
        $qtde = new TEntry('qtde');
        $valorUnitario = new TEntry('valorUnitario');
        $serial = new TEntry('serial');
        $licenca = new TEntry('licenca');
        $versao = new TEntry('versao');
        
             
        // add a row for the filter field        
        $this->form->addQuickField('Tipo Soft', $codTipoSoft, 250);
        $this->form->addQuickField('Tipo Licença', $codTipoSoftLicenca, 100);
        $this->form->addQuickField('Descrição', $descricao, 250);
        $this->form->addQuickField('Documento', $documento, 250);
        $this->form->addQuickField('Boletim', $boletim, 250);
        $this->form->addQuickField('QTDE', $qtde, 250);
        $this->form->addQuickField('Valor', $valorUnitario, 250);
        $this->form->addQuickField('Serial', $serial, 250);
        $this->form->addQuickField('Licença', $licenca, 250);
        $this->form->addQuickField('Versão', $versao, 250);
        
        $this->form->setData( TSession::getValue('Product_filter_data') );
        $this->form->addQuickAction( _t('Find'), new TAction(array($this, 'onSearch')), 'ico_find.png');
        $this->form->addQuickAction( _t('New'),  new TAction(array('SoftwareForm', 'onEdit')), 'ico_new.png');
        
        // creates a DataGrid
        $this->datagrid = new TQuickGrid;
        $this->datagrid->setHeight(420);

        // creates the datagrid columns
        $id = $this->datagrid->addQuickColumn('ID', 'codigoPaciente', 'center', 50);
        $nome = $this->datagrid->addQuickColumn('Nome', 'nome', 'left', 300);
        $email = $this->datagrid->addQuickColumn('Data Nasc.', 'dataNascimento', 'left', 150);
        $email = $this->datagrid->addQuickColumn('Email', 'email', 'left', 150);
        $sexo = $this->datagrid->addQuickColumn('Sexo', 'sexo', 'left', 50);
        $peso = $this->datagrid->addQuickColumn('Peso', 'peso', 'left', 50);
        $estatura = $this->datagrid->addQuickColumn('Estatura', 'estatura', 'left', 50);
        $imc = $this->datagrid->addQuickColumn('IMC', 'imc', 'left', 50);
  
        // create the datagrid actions
        $edit_action   = new TDataGridAction(array('PacienteForm', 'onEdit'));
        $delete_action = new TDataGridAction(array($this, 'onDelete'));
        
        // add the actions to the datagrid
        $this->datagrid->addQuickAction(_t('Edit'), $edit_action, 'codigoPaciente', 'ico_edit.png');
        $this->datagrid->addQuickAction(_t('Delete'), $delete_action, 'codigoPaciente', 'ico_delete.png');
        
        // create the datagrid model
        $this->datagrid->createModel();
        
        // create the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());
        
        // create the page container
        $container = new TVBox;
        $container->add(new TXMLBreadCrumb('menu.xml', 'PesquisaPaciente'));
        $container->add($this->form);
        $container->add($this->datagrid);
        $container->add($this->pageNavigation);
        
        parent::add($container);
    }
}
?>


