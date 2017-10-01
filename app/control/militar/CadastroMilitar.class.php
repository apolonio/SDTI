<?php

class CadastroMilitar extends TPage
{
    private $form;
    private $loaded;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->form = new TQuickForm;
        $notebook = new TNotebook(300, 300);
        $notebook->appendPage('DTI - Cadastro de Militares!', $this->form);
        
        $nome = new TEntry('nome');
        $nomeGuerra = new TEntry('nomeGuerra');
        $arma = new TDBCombo('arma','permission','Arma','sigla','sigla');
        $arma->setSize(100);
        $pg = new TDBCombo('pg','permission','Posto','sigla','sigla');
        $pg->setSize(80);
        $om = new TDBCombo('om','permission','Om','abreviatura','abreviatura');
        $om->setSize(120);
        $secao = new TDBCombo('secao','permission','Su','sigla','sigla');
        $secao->setSize(140);
        $reparticao = new TDBCombo('reparticao','permission','Subunidade','descricao','descricao');
        $reparticao->setSize(120);
       
        $endereco = new TEntry('endereco');
        $endereco->setSize(250);
        
        $bairro = new TDBCombo('bairro','permission','Bairro','bairro','bairro');
        $bairro->setSize(120);
        
        $cidade = new TDBCombo('cidade','permission','Cidade','descricao','descricao');
        $cidade->setSize(140);
        
        $uf = new TDBCombo('uf','permission','Uf','sigla','sigla');
        $uf->setSize(60);
        
        $cpf = new TEntry('cpf');
        $cpf->setMask('999.999.999-99');
        $cpf->setSize(120);
        $identidade = new TEntry('identidade');
        $preccp = new TEntry('preccp');
        $preccp->setMask('99.999.999-9');
        $preccp->setSize(120);
        
         $dataPromocao = new TDate('dataPromocao');
         $dataPromocao->setMask('dd/mm/yyyy');
         $dataPromocao->setDatabaseMask('yyyy-mm-dd');
         $dataPromocao->setSize(80);
        
        $dataApresentacao = new TDate('dataApresentacao');
        $dataApresentacao->setMask('dd/mm/yyyy');
        $dataApresentacao->setDatabaseMask('yyyy-mm-dd');
        $dataApresentacao->setSize(80);
        
        $dataGuarnicao = new TDate('dataGuarnicao');
        $dataGuarnicao->setMask('dd/mm/yyyy');
        $dataGuarnicao->setDatabaseMask('yyyy-mm-dd');
        $dataGuarnicao->setSize(80);
        
        $dataPraca1 = new TDate('dataPraca1');
        $dataPraca1->setMask('dd/mm/yyyy');
        $dataPraca1->setDatabaseMask('yyyy-mm-dd');
        $dataPraca1->setSize(80);
    
        $dataPraca2 = new TDate('dataPraca2');
        $dataPraca2->setMask('dd/mm/yyyy');
        $dataPraca2->setDatabaseMask('yyyy-mm-dd');
        $dataPraca2->setSize(80);
        
        $dataNascimento = new TDate('dataNascimento');
        $dataNascimento->setMask('dd/mm/yyyy');
        $dataNascimento->setDatabaseMask('yyyy-mm-dd');
        $dataNascimento->setSize(80);
        
         $telefone1 = new TEntry('telefone1');
         $telefone1->setMask('(99)99999-9999');
         $telefone1->setSize(120);
         
         $telefone2 = new TEntry('telefone2');
         $telefone2->setMask('(99)99999-9999');
         $telefone2->setSize(100);
        
        $lbl_arma =  new TLabel('Arma');
        $lbl_arma->setSize(60);
        $lbl_guerra =  new TLabel('Nome Guerra');
        $lbl_guerra->setSize(100);
        
        
        $lbl_secao =  new TLabel('SU');
        $lbl_secao->setSize(100);  // Aqui voce controla o tamanho dos Labels
        $lbl_reparticao =  new TLabel('Subunidade');
        $lbl_reparticao->setSize(100);
        
        $lbl_bairro =  new TLabel('Bairro');
        $lbl_bairro->setSize(100);  // Aqui voce controla o tamanho dos Labels
        $lbl_cidade =  new TLabel('Cidade');
        $lbl_cidade->setSize(100);
        $lbl_estado =  new TLabel('UF');
        $lbl_estado->setSize(100);  // Aqui voce controla o tamanho dos Labels
        
        $lbl_identidade =  new TLabel('Identidade');
        $lbl_identidade->setSize(100);
        $lbl_cpf =  new TLabel('CPF');
        $lbl_cpf->setSize(60); 
        $lbl_promocao = new \Adianti\Widget\Form\TLabel('Data Promoção');
        $lbl_promocao->setSize(140);
        $lbl_guarnicao =  new TLabel('Data Guarnição');
        $lbl_guarnicao->setSize(120); 
        $lbl_nascimento =  new TLabel('Data Nascimento');
        $lbl_nascimento->setSize(140); 
        
        $lbl_data2 =  new TLabel('Data Praça 2');
        $lbl_data2->setSize(120); 

        //  $guerra->setUpperCase(); 
        $this->form->addQuickField('Nome',$nome,450);
        $this->form->addQuickFields('Posto/Grad',      array($pg, $lbl_arma, $arma, $lbl_guerra, $nomeGuerra));
        $this->form->addQuickFields('OM', array($om, $lbl_secao, $secao, $lbl_reparticao, $reparticao));  
        $this->form->addQuickFields('Bairro', array($bairro, $lbl_cidade, $cidade, $lbl_estado, $uf));
        $this->form->addQuickField('Endereço',$endereco,400);
        $this->form->addQuickFields('PREC-CP', array($preccp, $lbl_identidade, $identidade,$lbl_cpf,$cpf));  
        $this->form->addQuickFields('Data Apresentação', array($dataApresentacao, $lbl_guarnicao,  $dataGuarnicao,$lbl_nascimento, $dataNascimento ));     
        $this->form->addQuickFields('Data Praça 1',      array($dataPraca1, $lbl_data2, $dataPraca2, $lbl_promocao, $dataPromocao ));
        $this->form->addQuickFields('Telefone 1', array($telefone1, new TLabel('Telefone 2'), $telefone2));
        
        
        $this->form->addQuickAction(_t('Save'), new TAction(array($this, 'onSave')), 'fa:save');
        
         // Aplicando css na pagina view
//        TPage::include_css('app/resources/styles.css');
//        $html1 = new THtmlRenderer('app/resources/cadastroMilitar.html');
//
//        $html1->enableSection('main', array());
//        
//        $panel1 = new TPanelGroup('INSTRUÇOES!');
//        $panel1->add($html1);
//        
//        parent::add( TVBox::pack($panel1) );
        
        parent::add($notebook);
    }
    
      public function onSave()
    {
        try
        {
            TTransaction::open('permission');
            
            $category = $this->form->getData('Militar');
            
            $category->store();
            
            TTransaction::close();
            
            new TMessage('info', 'Militar  cadastrado com Sucesso!');

            $this->onReload();
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
            
            TTransaction::rollback();
        }
    }
    

        function onReload($param = NULL)
    {
        try
        {
            TTransaction::open('permission');
            
            $repository = new TRepository('Militar');

            $criteria = new TCriteria;
            $order    = isset($param['order']) ? $param['order'] : 'id';
            $criteria->setProperty('order', $order);
        //    $criteria->add(new TFilter('situacao','!=','Finalizado');
            // load the objects according to criteria
            $categories = $repository->load($criteria);
            //$this->datagrid->onClear();
            if ($categories)
            {
                // iterate the collection of active records
                foreach ($categories as $category)
                {
                    // add the object inside the datagrid
                    //$this->datagrid->addItem($category);
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
     * Clear form
     */
    public function onClear()
    {
        $this->form->clear();
    }
    
    function show()
    {
        if (!$this->loaded)
        {
            $this->onReload( func_get_arg(0) );
        }
        parent::show();
    }
   
}
