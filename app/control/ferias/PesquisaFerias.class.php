<?php
/** 
 * Esser Relatorio exibi dados da tabela system_militar
 * @copyright (c) 2016, Apolonio S. S. Junior ICRIACOES Sistemas Web!s - 2ºSgt Santiago
 * @email apolocomputacao@gmail.com
 */
class PesquisaFerias extends TStandardList
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
        parent::setActiveRecord('Ferias');            
        parent::setDefaultOrder('codF', 'desc');         
        parent::addFilterField('codMilitar', 'like'); 
        parent::addFilterField('ano', '='); 
//        parent::addFilterField('nomeGuerra', 'like'); 
//        parent::addFilterField('om', '='); 
//        parent::addFilterField('secao', 'like'); 
//        parent::addFilterField('reparticao', 'like');
        
        // creates the form, with a table inside
        $this->form = new TQuickForm('form_search_ferias');
        $this->form->class = 'tform';
        $this->form->style = 'width: 650px';
        $this->form->setFormTitle('Tela de Pesquisa de Férias');

        //Criando os campos
        $codMilitar    = new TEntry('codMilitar');
        $ano = new TCombo('ano');
        
            //Escolha do Ano
        $a = array();
        $a['2016'] = '2016';
        $a['2017'] = '2017';
        $a['2018'] = '2018';
        $a['2019'] = '2019';
        $a['2020'] = '2020';
        $a['2021'] = '2021';
        $a['2022'] = '2022';
        $a['2023'] = '2023';
        $a['2024'] = '2024';
        $a['2025'] = '2025';
        $a['2026'] = '2026';
        $a['2027'] = '2027';
        $ano->addItems($a);

        // add a row for the filter field        $this->form->addQuickField('SU', $su, 200);
        $this->form->addQuickField('Militar', $codMilitar, 200);
        $this->form->addQuickField('Ano', $ano, 70);
//        $this->form->addQuickField('Guerra', $guerra, 200);
//        $this->form->addQuickField('SU', $su, 200);
//        $this->form->addQuickField('Subunidade', $subunidade, 200);
        
        $this->form->setData( TSession::getValue('Ferias_filter_data') );
        $this->form->addQuickAction( _t('Find'), new TAction(array($this, 'onSearch')), 'ico_find.png');
       // $this->form->addQuickAction( _t('New'),  new TAction(array('PesquisaFerias', 'onEdit')), 'ico_new.png');
        
        // creates a DataGrid
        $this->datagrid = new TQuickGrid;
        $this->datagrid->setHeight(420);

        // creates the datagrid columns
        $this->datagrid->addQuickColumn('ID', 'codF', 'center', 50);
        $this->datagrid->addQuickColumn('Militar', 'codMilitar', 'left', 300);
        $this->datagrid->addQuickColumn('Ano  ', 'ano', 'left', 150);
        $this->datagrid->addQuickColumn('Período', 'per1', 'left', 100);
        $this->datagrid->addQuickColumn('DataI', 'dataI', 'left', 100);
        $this->datagrid->addQuickColumn('DataT', 'dataT', 'left', 100);
        $this->datagrid->addQuickColumn('DataP', 'dataP', 'left', 100);
        $this->datagrid->addQuickColumn('DataC', 'dataA', 'left', 100);
        
        // create the datagrid actions
        $edit_action   = new TDataGridAction(array('FeriasForm', 'onEdit'));
        $delete_action = new TDataGridAction(array($this, 'onDelete'));
        
        // add the actions to the datagrid
        $this->datagrid->addQuickAction(_t('Edit'), $edit_action, 'codF', 'ico_edit.png');
        $this->datagrid->addQuickAction(_t('Delete'), $delete_action, 'codF', 'ico_delete.png');
        
        // create the datagrid model
        $this->datagrid->createModel();
        
        // create the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());
        
        // create the page container
        $container = new TVBox;
        $container->add(new TXMLBreadCrumb('menu.xml', 'PesquisaFerias'));
        $container->add($this->form);
        $container->add($this->datagrid);
        $container->add($this->pageNavigation);
        
        parent::add($container);
    }
}
?>


