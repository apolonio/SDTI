<?php
/** 
 * Esser Relatorio exibi dados da tabela system_militar
 * @copyright (c) 2016, Apolonio S. S. Junior ICRIACOES Sistemas Web!s - 2ºSgt Santiago
 * @email apolocomputacao@gmail.com
 */
class PesquisaMnt extends TStandardList
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
        parent::setActiveRecord('AcessoManutencao');           
        parent::setDefaultOrder('idMnt', 'desc');         
        parent::addFilterField('dti', 'like');
        parent::addFilterField('secao', '='); 
        parent::addFilterField('om', '='); 
        parent::addFilterField('solicitante', 'like'); 
        parent::addFilterField('tecnico', '='); 
        parent::addFilterField('tipo', '='); 
        parent::addFilterField('descricao', 'like'); 
        
        // creates the form, with a table inside
        $this->form = new TQuickForm('Hard_search_militar');
        $this->form->class = 'tform';
        $this->form->style = 'width: 650px';
        $this->form->setFormTitle('Dados da Manutenção');
   

        //Criando os campos
        
        $dti = new TDBCombo('dti','permission','Hardware','dti','dti');
        $dti->setSize(150);
        $os = new TEntry('os');
        $os->setSize(150);
        $solicitante = new TEntry('solicitante');
        $solicitante->setSize(250);
        $tecnico = new TCombo('tecnico');
        $tecnico->setSize(150);
        $localExecucao = new TCombo('localExecucao');
        $localExecucao->setSize(150);
        $om = new TDBCombo('om','permission','Om','abreviatura','abreviatura');
        $om->setSize(150);
        $secao = new TEntry('secao');
        $secao->setSize(150);
        $ramal = new TEntry('ramal');
        $ramal->setSize(100);
        $tipo = new TCombo('tipoMaterial');
        $tipo->setSize(150);
        $dataEntrada = new TDate('dataEntrada');
        $dataEntrada->setMask('dd/mm/yyyy');
        $dataEntrada->setDatabaseMask('yyyy-mm-dd');
        $dataEntrada->setSize(80);
        $descricao = new TEntry('descricao');
        $descricao->setSize(300);
        $defeito = new TText('defeito');
        $defeito->setSize(300);
        $procedimento = new TText('procedimento');
        $procedimento->setSize(300);
        $situacao = new TCombo('situacao');
        $situacao->setSize(200);
        $dataMnt = new TDate('dataMnt');
        $dataMnt->setMask('dd/mm/yyyy');
        $dataMnt->setDatabaseMask('yyyy-mm-dd');
        $dataMnt->setSize(80);
    
        $sit = array();
        $sit['Finalizado'] = 'Finalizado';
        $sit['Aguardando Parecer'] = 'Aguardando Parecer';
        $sit['Aguardando Peças'] = 'Aguardando Peças';
        $sit['Descarregado'] = 'Descarregado';
        $sit['Garantia'] = 'Garantia';
        $situacao->addItems($sit);
        
        $local = array();
        $local['Seção Sistemas'] = 'Seção Sistemas';
        $local['Seção Manutenção'] = 'Seção Manutenção';
        $local['Seção Suporte'] = 'Suporte';
        $local['Seção Redes'] = 'Seção Redes';
        $local['Seção Telefonia'] = 'Telefonia';
        $localExecucao->addItems($local);
        
        $tp = array();
        $tp['Computador'] = 'Computador';
        $tp['Notebook'] = 'Notebook';
        $tp['Impressora'] = 'Impressora';
        $tp['Scanner'] = 'Scanner';
        $tp['Estabilizador'] = 'Estabilizador';
        $tp['Nobreak'] = 'Nobreak';
        $tp['Projetor'] = 'Projetor';
        $tp['Telefone'] = 'Telefone';
        $tp['Tablet'] = 'Tablet';
        $tipo->addItems($tp);
        
        $t = array();
        $t['Ten Ismael'] = 'Ten Ismael';
        $t['Ten Alex Peral'] = 'Ten Alex Peral';
        $t['Ten William'] = 'Ten William';
        $t['Sgt Flausino'] = 'Sgt Flausino';
        $t['Sgt Santiago'] = 'Sgt Santiago';
        $t['Sgt Aldo'] = 'Sgt Aldo';
        $t['Sgt Carvalho'] = 'Sgt Carvalho';
        $t['Sgt Caio Cesar'] = 'Sgt Caio Cesar';
        $t['Sgt Menezes'] = 'Sgt Menezes';
        $t['Sgt Eny'] = 'Sgt Eny';
        $t['Sgt Emerson'] = 'Sgt Emerson';
        $t['Sgt Cabral'] = 'Sgt Cabral';
        $t['Cb Joaquim'] = 'Cb Santana';
        $t['Cb Simon'] = 'Cb Simon';
        $t['Cb Santana'] = 'Cb Santana';
        $t['Cb Amorim'] = 'Cb Amorim';
        $t['Sd Maciel'] = 'Sd Maciel';
        $t['Sd Paiva'] = 'Sd Paiva';
        $t['Sd Gregory'] = 'Sd Gregory';
        $t['Sd Lima Silva'] = 'Sd Lima Silva';
        $t['Sd Ribeiro'] = 'Sd Ribeiro';
        $t['Sd Anderson'] = 'Sd Anderson';
        $tecnico->addItems($t);

        // add a row for the filter field        
        $this->form->addQuickField('DTI', $dti, 200);
        $this->form->addQuickField('OM', $om, 200);
        $this->form->addQuickField('Local', $localExecucao, 200);
        $this->form->addQuickField('Solicitante', $solicitante, 200);
        $this->form->addQuickField('Técnico', $tecnico, 200);
        $this->form->addQuickField('Tipo', $tipo, 200);
        $this->form->addQuickField('Descrição', $descricao, 200);
        
        $this->form->setData( TSession::getValue('Hard_filter_data') );
        $this->form->addQuickAction( 'Pesquisar', new TAction(array($this, 'onSearch')), 'ico_find.png');
        $this->form->addQuickAction( 'Editar',  new TAction(array('ManutencaoForm', 'onEdit')), 'ico_new.png');
        
        // creates a DataGrid
        $this->datagrid = new TQuickGrid;
        $this->datagrid->setHeight(420);
        
      

        // creates the datagrid columns
        $idMnt = $this->datagrid->addQuickColumn('ID', 'idMnt', 'center', 50);
        $dti = $this->datagrid->addQuickColumn('DTI', 'dti', 'center', 50);
        $os= $this->datagrid->addQuickColumn('OS', 'os', 'center', 50);
        $localExecucao= $this->datagrid->addQuickColumn('Local.E', 'localExecucao', 'center', 60);
        $solicitante= $this->datagrid->addQuickColumn('Sol.', 'solicitante', 'center', 60);
        $tipo = $this->datagrid->addQuickColumn('Tipo', 'tipoMaterial', 'left', 100);
        $tecnico = $this->datagrid->addQuickColumn('Técnico', 'tecnico', 'left', 100);
        $om= $this->datagrid->addQuickColumn('OM', 'om', 'left', 100);
        $descricao = $this->datagrid->addQuickColumn('Descrição', 'descricao', 'left', 300);
        $defeito = $this->datagrid->addQuickColumn('Defeito', 'defeito', 'left', 300);
        $situacao = $this->datagrid->addQuickColumn('Situação', 'situacao', 'left', 300);
        $dataEntrada = $this->datagrid->addQuickColumn('Data E.', 'dataEntrada', 'left', 100);
        $dataMnt = $this->datagrid->addQuickColumn('Data M.', 'dataMnt', 'left', 100);
       

        // Criando o botão para a GRID
        $edit_action   = new TDataGridAction(array('ManutencaoForm', 'onEdit'));
        $delete_action = new TDataGridAction(array($this, 'onDelete'));
        
        // Adicionando a ação no Formulário
        $this->datagrid->addQuickAction(_t('Edit'), $edit_action, 'idMnt', 'ico_edit.png');
        $this->datagrid->addQuickAction(_t('Delete'), $delete_action, 'idMnt', 'ico_delete.png');
        
        // Criando a Model
        $this->datagrid->createModel();
        
        // Criando a Página
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());
        
        // create the page container
        $container = new TVBox;
        $container->add(new TXMLBreadCrumb('menu.xml', 'PesquisaMnt'));
        $container->add($this->form);
        $container->add($this->datagrid);
        $container->add($this->pageNavigation);
        
        parent::add($container);

    }
   
}

