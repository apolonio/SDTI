<?php

class HardwareForm extends TPage
{
    private $form;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->form = new TQuickForm;
        $notebook = new TNotebook(300, 300);
        $notebook->appendPage('DTI - Editar de Hardware!', $this->form);
        
        $id = new TEntry('id');
        $dti = new TEntry('dti');
        
        $patrimonio = new TEntry('patrimonio');
        $patrimonio->setSize(200);
        $ficha = new TEntry('ficha');
        $ficha->setSize(200);
        $nrSerie = new TEntry('nrSerie');
        $nrSerie->setSize(200);
        $om = new TDBCombo('om','permission','Om','abreviatura','abreviatura');
        $om->setSize(200);
        $secao = new TEntry('secao');
        $secao->setSize(200);
        $trem = new TEntry('trem');
        $trem->setSize(200);
        $boletim = new TEntry('boletim');
        $boletim->setSize(200);
        $diex = new TEntry('diex');
        $diex->setSize(300);
        $marca = new TEntry('marca');
        $marca->setSize(200);
        $modelo = new TEntry('modelo');
        $modelo->setSize(200);
        $descricao = new \Adianti\Widget\Form\TText('descricao');
        $descricao->setSize(200);
        $data = new TDate('dataHard');
        $data->setMask('dd/mm/yyyy');
        $data->setDatabaseMask('yyyy-mm-dd');
        $data->setSize(80);
        
        $lbl_id =  new TLabel('ID');
        $lbl_id->setSize(100);  
        $lbl_dti =  new TLabel('DTI');
        $lbl_dti->setSize(100);  
        $lbl_patrimonio =  new TLabel('Patrimônio');
        $lbl_patrimonio->setSize(100);  
        $lbl_ficha =  new TLabel('Ficha');
        $lbl_ficha->setSize(100);  
        $lbl_nrSerie =  new TLabel('Nr.Série');
        $lbl_nrSerie->setSize(100);  
        $lbl_boletim =  new TLabel('Boletim');
        $lbl_boletim->setSize(100);  
        $lbl_diex =  new TLabel('DIEx');
        $lbl_diex->setSize(30);  
        $lbl_trem =  new TLabel('TREM');
        $lbl_trem->setSize(100);  
        $lbl_marca =  new TLabel('Marca');
        $lbl_marca->setSize(100);  
        $lbl_om =  new TLabel('OM');
        $lbl_om->setSize(100);  
        $lbl_secao =  new TLabel('Seção');
        $lbl_secao->setSize(100);  
        $lbl_modelo=  new TLabel('Modelo');
        $lbl_modelo->setSize(100);  
        $lbl_descricao =  new TLabel('Descrição');
        $lbl_descricao->setSize(100);  
        $lbl_data =  new TLabel('');
        $lbl_data->setSize(100);  
    
        $modelo->setUpperCase(); 
        $marca->setUpperCase(); 
          $id->setEditable(FALSE);
        $this->form->addQuickFields('Número', array($lbl_id,$id, $lbl_dti, $dti, $lbl_nrSerie, $nrSerie ));
        $this->form->addQuickFields('Siscofis', array( $lbl_patrimonio, $patrimonio, $lbl_ficha, $ficha));
        $this->form->addQuickFields('Documentação', array($lbl_boletim, $boletim, $lbl_trem, $trem, $lbl_diex, $diex));
        $this->form->addQuickFields('Local', array($lbl_om, $om, $lbl_secao, $secao));
        $this->form->addQuickFields('Empresa', array($lbl_marca, $marca, $lbl_modelo, $modelo));
        $this->form->addQuickFields('Descrição', array($lbl_descricao, $descricao));  
        $this->form->addQuickFields('Data Cadastro',      array($lbl_data, $data));
        
        
        $this->form->addQuickAction(_t('Save'), new TAction(array($this, 'onSave')), 'fa:save');
        $this->form->addQuickAction('Voltar', new TAction(array('PesquisaHardware', 'onReload')), 'ico_find.png');
        
        parent::add($notebook);
    }
    
      public function onSave()
    {
        try
        {
            TTransaction::open('permission');
            
            $hard = $this->form->getData('Hardware');
            
            $hard->store();
            
            $this->form->setData($hard);
            
            TTransaction::close();
            
            new TMessage('info', 'Dispositivo atualizado com Sucesso!');

        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
            
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
    
    function onEdit($param)
    {
        try
        {
            if (isset($param['key']))
            {
                // open a transaction with database 'samples'
                TTransaction::open('permission');
                
                 // load the Active Record according to its ID
                $mil= new Hardware($param['key']);
                
                 $mil->store();
                
                // fill the form with the active record data
                $this->form->setData($mil);
                
                // close the transaction
                TTransaction::close();
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e) // in case of exception
        {
            // shows the exception error message
            new TMessage('error', '<b>Error</b>' . $e->getMessage());
            // undo all pending operations
            TTransaction::rollback();
        }
    }

    
   
}
