<?php

class ManutencaoForm extends TPage
{
    private $form;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->form = new TQuickForm;
        $notebook = new TNotebook(300, 300);
        $notebook->appendPage('DTI - Editar Manutenção!', $this->form);
        
        $idMnt = new TEntry('idMnt');
        $dti = new TEntry('dti');
        $os= new TEntry('os');
        $os->setSize(200);
        $solicitante = new TEntry('solicitante');
        $solicitante->setSize(200);
        $tecnico = new TEntry('tecnico');
        $tecnico->setSize(200);
        $om = new TDBCombo('om','permission','Om','abreviatura','abreviatura');
        $om->setSize(200);
        $secao = new TEntry('secao');
        $secao->setSize(200);
        $ramal = new TEntry('ramal');
        $ramal->setSize(200);
        $localExecucao = new TEntry('localExecucao');
        $localExecucao->setSize(200);
        $tipoMaterial = new \Adianti\Widget\Form\TCombo('tipoMaterial');
        $tipoMaterial->setSize(200);
        $descricao = new \Adianti\Widget\Form\TText('descricao');
        $descricao->setSize(200);
        $defeito = new \Adianti\Widget\Form\TText('defeito');
        $defeito->setSize(200);
        $procedimento = new \Adianti\Widget\Form\TText('procedimento');
        $procedimento->setSize(200);
        $situacao = new TEntry('situacao');
        $situacao->setSize(200);
        $dataEntrada = new TDate('dataEntrada');
        $dataEntrada->setMask('dd/mm/yyyy');
        $dataEntrada->setDatabaseMask('yyyy-mm-dd');
        $dataEntrada->setSize(80);
        $dataMnt= new TDate('dataMnt');
        $dataMnt->setMask('dd/mm/yyyy');
        $dataMnt->setDatabaseMask('yyyy-mm-dd');
        $dataMnt->setSize(80);
        
        
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
        $tp['Switch'] = 'Switch';
        $tp['Servidor'] = 'Servidor';
        $tipoMaterial->addItems($tp);
        
        $sit = array();
        $sit['Finalizado'] = 'Finalizado';
        $sit['Aguardando Parecer'] = 'Aguardando Parecer';
        $sit['Aguardando Peças'] = 'Aguardando Peças';
        $sit['Descarregado'] = 'Descarregado';
        $sit['Garantia'] = 'Garantia';
        $situacao->addItems($sit);
        
        $lbl_idMnt =  new TLabel('ID');
        $lbl_idMnt->setSize(100);  
        $lbl_dti =  new TLabel('DTI');
        $lbl_dti->setSize(100);  
        $lbl_os =  new TLabel('OS');
        $lbl_os->setSize(100);  
        $lbl_solicitante =  new TLabel('Solicitante');
        $lbl_solicitante->setSize(100);  
        $lbl_tecnico =  new TLabel('Técnico');
        $lbl_tecnico->setSize(100);  
        $lbl_localExecucao =  new TLabel('Local E.');
        $lbl_localExecucao->setSize(100);  
        $lbl_om =  new TLabel('OM');
        $lbl_om->setSize(100);  
        $lbl_tipoMaterial =  new TLabel('Tipo');
        $lbl_tipoMaterial->setSize(100);  
        $lbl_secao =  new TLabel('Seção');
        $lbl_secao->setSize(100);  
        $lbl_ramal =  new TLabel('Ramal');
        $lbl_ramal->setSize(100);  
        $lbl_defeito=  new TLabel('Defeito');
        $lbl_defeito->setSize(100);  
        $lbl_descricao =  new TLabel('Descrição');
        $lbl_descricao->setSize(100);  
        $lbl_procedimento =  new TLabel('Procedimento');
        $lbl_procedimento->setSize(100);  
        $lbl_situacao=  new TLabel('Situação');
        $lbl_situacao->setSize(100);  
        $lbl_dataEntrada =  new TLabel('Data Entrada');
        $lbl_dataEntrada->setSize(100);  
        $lbl_dataMnt =  new TLabel('Data Mnt');
        $lbl_dataMnt->setSize(100);  
    
        $secao->setUpperCase(); 
        $localExecucao->setUpperCase(); 
        $idMnt->setEditable(FALSE);
      //  $tecnico->setEditable(FALSE);
        
        $this->form->addQuickFields('Número', array($lbl_idMnt,$idMnt, $lbl_dti, $dti, $lbl_os, $os ));
        $this->form->addQuickFields('Pessoal', array( $lbl_solicitante, $solicitante, $lbl_tecnico, $tecnico ));
        $this->form->addQuickFields('Local', array($lbl_om, $om, $lbl_secao, $secao,$lbl_ramal,$ramal));
        $this->form->addQuickFields('Material', array($lbl_tipoMaterial, $tipoMaterial,$lbl_descricao, $descricao));  
        $this->form->addQuickFields('Manutenção', array($lbl_defeito, $defeito,$lbl_procedimento,$procedimento));  
        $this->form->addQuickFields('Data Cadastro',      array($lbl_situacao,$situacao,$lbl_dataEntrada, $dataEntrada,$lbl_dataMnt, $dataMnt));
        
        
        $this->form->addQuickAction(_t('Save'), new TAction(array($this, 'onSave')), 'fa:save');
        $this->form->addQuickAction('Voltar', new TAction(array('PesquisaMnt', 'onReload')), 'ico_find.png');
        
        parent::add($notebook);
    }
    
      public function onSave()
    {
        try
        {
            TTransaction::open('permission');
            
            $mnt = $this->form->getData('AcessoManutencao');
            
            $mnt->store();
            
            $this->form->setData($mnt);
            
            TTransaction::close();
            
            new TMessage('info', 'Manutenção atualizada com Sucesso!');

        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
            
            TTransaction::rollback();
        }
    }
    
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
                TTransaction::open('permission');
                
                $mnt= new AcessoManutencao($param['key']);
                
                 $mnt->store();
                
                $this->form->setData($mnt);
                
                TTransaction::close();
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e) 
        {
            new TMessage('error', '<b>Error</b>' . $e->getMessage());
            TTransaction::rollback();
        }
    }

    
   
}
