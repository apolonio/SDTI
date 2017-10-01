<?php

class CadastroSoftware extends TPage
{
    private $form;
    private $loaded;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->form = new TQuickForm;
        $notebook = new TNotebook(300, 300);
        $notebook->appendPage('GS - CCOMGEX - Cadastro Software!', $this->form);
        
        $codTipoSoft = new TDBCombo('codTipoSoft','permission','TipoSoftware','descricaoTipoSoft','descricaoTipoSoft');
        $tipoLicenca = new TDBCombo('codTipoSoftLicenca','permission','TipoLicencaSoftware','descricaoTipoLicencaSoft','descricaoTipoLicencaSoft');
        $descricao = new TEntry('descricao');
        $documento = new TEntry('documento');
        $boletim = new TEntry('boletim');
        $qtde = new TEntry('qtde');
        $vlr = new TEntry('valorUnitario');
        $serial = new TEntry('serial');
        $licenca = new TEntry('licenca');
        $versao = new TEntry('versao');
        $data = new TDate('dataCad');
        
        //$data->setMask('dd-mm-yyy');
        //$data->setMaskD('yyyy-mm-dd');
     
        
       // $vlr->setMask();
        
        $this->form->addQuickField( 'Tipo Software', $codTipoSoft,200);
        $this->form->addQuickField( 'Tipo Licença', $tipoLicenca, 200);
        $this->form->addQuickField( 'Descrição', $descricao, 300 );
        $this->form->addQuickField( 'Documento', $documento, 300);
        $this->form->addQuickField( 'Boletim', $boletim, 300 );
        $this->form->addQuickField( 'Licenca', $licenca, 300 );
        $this->form->addQuickField( 'Serial', $serial, 300 );
        $this->form->addQuickField( 'Versao', $versao,100 );
        $this->form->addQuickField( 'Qtde', $qtde, 100 );
        $this->form->addQuickField( 'Valor', $vlr, 100 );
        $this->form->addQuickField( 'Data', $data, 100);
        
        $this->form->addQuickAction(_t('Save'), new TAction(array($this, 'onSave')), 'fa:save');
        
         // Aplicando css na pagina view
        TPage::include_css('app/resources/styles.css');
        $html1 = new THtmlRenderer('app/resources/cadastroSoftware.html');

        $html1->enableSection('main', array());
        
        $panel1 = new TPanelGroup('INSTRUÇOES!');
        $panel1->add($html1);
        
        parent::add( TVBox::pack($panel1) );
        
        parent::add($notebook);
    }
    
      public function onSave()
    {
        try
        {
            TTransaction::open('permission');
            
            $category = $this->form->getData('Software');
            
            $category->store();
            
            TTransaction::close();
            
            new TMessage('info', 'Software  cadastrado com Sucesso!');

        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
            
            TTransaction::rollback();
        }
    }
    

       
}
