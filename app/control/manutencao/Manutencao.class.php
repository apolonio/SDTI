<?php


class Manutencao extends TStandardForm
{
    protected $form;
    private $loaded;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->form = new TQuickForm('form_Mnt');
        $this->form->class = 'tform';
        $this->form->setFormTitle('DTI - Realizar Manutenção!');
        parent::setDatabase('permission');
        parent::setActiveRecord('AcessoManutencao');
        
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
        $omMaterial = new TDBCombo('om','permission','Om','abreviatura','abreviatura');
        $omMaterial->setSize(150);
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
        $descricao = new TText('descricao');
        $descricao->setSize(300);
        $defeito = new TText('defeito');
        $defeito->setSize(300);
        $procedimento = new TText('procedimento');
        $procedimento->setSize(300);
        $situacao = new TCombo('situacao');
        $situacao->setSize(200);
        $data = new TDate('dataMnt');
        $data->setMask('dd/mm/yyyy');
        $data->setDatabaseMask('yyyy-mm-dd');
        $data->setSize(80);

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
                
        $lbl_dti =  new TLabel('-');
        $lbl_dti->setSize(100);  
        $lbl_tecnico =  new TLabel('-');
        $lbl_tecnico->setSize(100);  
       
        $lbl_solicitante =  new TLabel('-');
        $lbl_solicitante->setSize(100);  
        $lbl_localExecucao =  new TLabel('Local Execução');
        $lbl_localExecucao->setSize(100);  
       
        $lbl_om =  new TLabel('OM');
        $lbl_om->setSize(100);  
        $lbl_os =  new TLabel('Ordem Serviço');
        $lbl_os->setSize(100);  
        $lbl_secao =  new TLabel('Seção');
        $lbl_secao->setSize(100);  
        $lbl_ramal=  new TLabel('Ramal');
        $lbl_ramal->setSize(50);  
        $lbl_defeito =  new TLabel('');
        $lbl_defeito->setSize(100);  
        $lbl_mnt =  new TLabel('');
        $lbl_mnt->setSize(100);  
        $lbl_tipo =  new TLabel('');
        $lbl_tipo->setSize(100);  
        $lbl_descricao =  new TLabel('');
        $lbl_descricao->setSize(100);  
        $lbl_sit =  new TLabel('');
        $lbl_sit->setSize(100);  
        $lbl_entrada =  new TLabel('Data Entrada');
        $lbl_entrada->setSize(100);  
        $lbl_data =  new TLabel('');
        $lbl_data->setSize(100);  
    
        //  $guerra->setUpperCase(); 

        $this->form->addQuickFields('DTI', array($lbl_dti, $dti, $lbl_os, $os  ));
        $this->form->addQuickFields('Técnico', array( $lbl_tecnico, $tecnico, $lbl_localExecucao, $localExecucao));
        $this->form->addQuickFields('Solicitante', array( $lbl_solicitante, $solicitante));
        $row = $this->form->addRow();
        $row->class = 'tformsection';
        $row->addCell( new TLabel('Detalhes sobre origem do Material - Atenção ao Preenchimento'))->colspan = 2;
        $this->form->addQuickFields('Local Origem', array($lbl_om, $omMaterial, $lbl_secao, $secao, $lbl_ramal, $ramal));
        $this->form->addQuickFields('Tipo Material', array($lbl_tipo, $tipo, $lbl_entrada, $dataEntrada)); 
        $this->form->addQuickFields('Descrição Material', array($lbl_descricao, $descricao)); 
        $this->form->addQuickFields('Defeito', array($lbl_defeito, $defeito));
        $this->form->addQuickFields('Manutenção Realizada', array($lbl_mnt, $procedimento));  
        $this->form->addQuickFields('Situação', array($lbl_sit, $situacao));  
        $this->form->addQuickFields('Data Saída',      array($lbl_data, $data));
        $defeito->setSize(550,50);
        $procedimento->setSize(550,50);
        $descricao->setSize(550,50);
        
        $this->form->addQuickAction('Limpar', new TAction(array($this, 'onClear')), 'fa:eraser red' );
        $this->form->addQuickAction( 'Salvar', new TAction(array($this, 'onSave')), 'ico_save.png' );        
        $vbox = new TVBox;
        $vbox->add(new Adianti\Widget\Util\TXMLBreadCrumb('menu.xml', 'Manutencao'));
        $vbox->add($this->form);
        parent::add($vbox);
    }
    
         public function onSave()
    {
        $object = parent::onSave();
        if ($object instanceof AcessoManutencao)
        {
                try
                {
                    TTransaction::open($this->database);
                    $object->store();
                  
                    $this->onClear();
                    TTransaction::close();
                }
                catch (Exception $e)
                {
                    new TMessage('error', $e->getMessage());
                    TTransaction::rollback();
                }
        }else{
            
         new TMessage('info', 'Erro ao conectar com Base de Dados!');
        }
    
    }
    
    public function onClear()
    {
        $this->form->clear();
    }
   
    

       
   
}

