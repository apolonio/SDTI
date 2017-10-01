<?php


class CadastroFerias extends TStandardForm
{
    protected $form;     
    private $loaded;

    public function __construct()
    {
        parent::__construct();
          
        $this->form = new TQuickForm('form_Ferias');
        $this->form->class = 'tform';
        $this->form->setFormTitle('Cadastro de Férias');
        parent::setDatabase('permission');
        parent::setActiveRecord('Ferias');

        $codMilitar    = new TDBCombo('codMilitar', 'permission', 'Militar', 'nome', 'nome');
        $codMilitar->setSize(350);
        
        $dataI= new TDate('dataI');
        $dataI->setMask('dd/mm/yyyy');
        $dataI->setDatabaseMask('yyyy-mm-dd');
        $dataI->setSize(70);
        
        $dataT= new TDate('dataT');
        $dataT->setMask('dd/mm/yyyy');
        $dataT->setDatabaseMask('yyyy-mm-dd');
        $dataT->setSize(70);
        
        $dataP= new TDate('dataP');
        $dataP->setMask('dd/mm/yyyy');
        $dataP->setDatabaseMask('yyyy-mm-dd');
        $dataP->setSize(70);
        
        $dataA= new TDate('dataA');
        $dataA->setMask('dd/mm/yyyy');
        $dataA->setDatabaseMask('yyyy-mm-dd');
        $dataA->setSize(70);
        
        
     
        $dataI2= new TDate('dataI2');
        $dataI2->setMask('dd/mm/yyyy');
        $dataI2->setDatabaseMask('yyyy-mm-dd');
        $dataI2->setSize(70);
        
        $dataT2= new TDate('dataT2');
        $dataT2->setMask('dd/mm/yyyy');
        $dataT2->setDatabaseMask('yyyy-mm-dd');
        $dataT2->setSize(70);
        
        $dataP2= new TDate('dataP2');
        $dataP2->setMask('dd/mm/yyyy');
        $dataP2->setDatabaseMask('yyyy-mm-dd');
        $dataP2->setSize(70);
        
        $dataA2= new TDate('dataA2');
        $dataA2->setMask('dd/mm/yyyy');
        $dataA2->setDatabaseMask('yyyy-mm-dd');
        $dataA2->setSize(70);
        
        $dataI3= new TDate('dataI3');
        $dataI3->setMask('dd/mm/yyyy');
        $dataI3->setDatabaseMask('yyyy-mm-dd');
        $dataI3->setSize(70);
        
        $dataT3= new TDate('dataT3');
        $dataT3->setMask('dd/mm/yyyy');
        $dataT3->setDatabaseMask('yyyy-mm-dd');
        $dataT3->setSize(70);
        
        $dataP3= new TDate('dataP3');
        $dataP3->setMask('dd/mm/yyyy');
        $dataP3->setDatabaseMask('yyyy-mm-dd');
        $dataP3->setSize(70);
        
        $dataA3= new TDate('dataA3');
        $dataA3->setMask('dd/mm/yyyy');
        $dataA3->setDatabaseMask('yyyy-mm-dd');
        $dataA3->setSize(70);
        
        $dataI4= new TDate('dataI4');
        $dataI4->setMask('dd/mm/yyyy');
        $dataI4->setDatabaseMask('yyyy-mm-dd');
        $dataI4->setSize(70);
        
        $dataT4= new TDate('dataT4');
        $dataT4->setMask('dd/mm/yyyy');
        $dataT4->setDatabaseMask('yyyy-mm-dd');
        $dataT4->setSize(70);
        
        $dataP4= new TDate('dataP4');
        $dataP4->setMask('dd/mm/yyyy');
        $dataP4->setDatabaseMask('yyyy-mm-dd');
        $dataP4->setSize(70);
        
        $dataA4= new TDate('dataA4');
        $dataA4->setMask('dd/mm/yyyy');
        $dataA4->setDatabaseMask('yyyy-mm-dd');
        $dataA4->setSize(70);
        
        
     
        $ano = new TCombo('ano');
        $ano->setSize(100);
        $obs = new TText('obs');
        
        $per1 = new TEntry('1per');
        $per1->setSize(70);
        $per2 = new TEntry('2per');
        $per2->setSize(70);
        $per3 = new TEntry('3per');
        $per3->setSize(70);
        $per4 = new TEntry('4per');
        $per4->setSize(70);
        $bol1 = new TEntry('bol1');
        $bol1->setSize(70);
        $bol2 = new TEntry('bol2');
        $bol2->setSize(70);
        $bol3 = new TEntry('bol3');
        $bol3->setSize(70);
        $bol4 = new TEntry('bol4');
        $bol4->setSize(70);
      
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
  
        
        $lbl_dias=  new TLabel('');
        $lbl_dias->setSize(50); 
        $lbl_dias2=  new TLabel('');
        $lbl_dias2->setSize(50); 
        $lbl_dias3=  new TLabel('');
        $lbl_dias3->setSize(50); 
        $lbl_dias4=  new TLabel('');
        $lbl_dias4->setSize(50); 
        $lbl_bol=  new TLabel('Boletim 1º Período');
        $lbl_bol->setSize(50); 
        $lbl_bol2=  new TLabel('Boletim 2º Período');
        $lbl_bol2->setSize(50); 
        $lbl_bol3=  new TLabel('Boletim 3º Período');
        $lbl_bol3->setSize(50); 
        $lbl_bol4=  new TLabel('Boletim 4º Período');
        $lbl_bol4->setSize(50); 
    
        $lbl_dataP=  new TLabel(' ');
        $lbl_dataP->setSize(10); 
        $lbl_dataP2=  new TLabel(' ');
        $lbl_dataP2->setSize(10); 
        $lbl_dataP3=  new TLabel(' ');
        $lbl_dataP3->setSize(10); 
        $lbl_dataP4=  new TLabel(' ');
        $lbl_dataP4->setSize(10); 
        $lbl_dataA=  new TLabel(' ');
        $lbl_dataA->setSize(10); 
        $lbl_dataA2=  new TLabel(' ');
        $lbl_dataA2->setSize(10); 
        $lbl_dataA3=  new TLabel(' ');
        $lbl_dataA3->setSize(10); 
        $lbl_dataA4=  new TLabel(' ');
        $lbl_dataA4->setSize(10); 
        $lbl_dataI =  new TLabel(' ');
        $lbl_dataI->setSize(10); 
        $lbl_dataI2 =  new TLabel(' ');
        $lbl_dataI2->setSize(10); 
        $lbl_dataI3 =  new TLabel(' ');
        $lbl_dataI3->setSize(10); 
        $lbl_dataI4 =  new TLabel(' ');
        $lbl_dataI4->setSize(10); 
        $lbl_dataT =  new TLabel(' ');
        $lbl_dataT->setSize(10); 
        $lbl_dataT2 =  new TLabel(' ');
        $lbl_dataT2->setSize(10); 
        $lbl_dataT3 =  new TLabel(' ');
        $lbl_dataT3->setSize(10); 
        $lbl_dataT4 =  new TLabel(' ');
        $lbl_dataT4->setSize(10);
        
        $this->form->addQuickField('Militar',$codMilitar,350);   
        $this->form->addQuickField('Ano',$ano,100);   
        
        $row = $this->form->addRow();
        $row->class = 'tformsection';
        $row->addCell( new TLabel('FÉRIAS'))->colspan = 2;
        $row = $this->form->addRow();
        $row->class = 'tformsection';
        $row->addCell( new TLabel('FÉRIAS --------------------------------------------------- DIAS ----- DATA PARTIDA --- DATA APRES. --- DATA ÍNICIO -- DATA TÉRMINO'))->colspan = 2;
        $this->form->addQuickFields('1º Período',  array($lbl_dias,$per1,$lbl_dataP,$dataP, $lbl_dataA, $dataA, $lbl_dataI, $dataI, $lbl_dataT, $dataT ));
        $this->form->addQuickFields('2º Período',  array($lbl_dias2,$per2,$lbl_dataP2,$dataP2, $lbl_dataA2, $dataA2, $lbl_dataI2, $dataI2, $lbl_dataT2, $dataT2 ));
        $this->form->addQuickFields('3º Período',  array($lbl_dias3,$per3,$lbl_dataP3,$dataP3, $lbl_dataA3, $dataA3, $lbl_dataI3, $dataI3, $lbl_dataT3, $dataT3 ));
        $this->form->addQuickFields('4º Período',  array($lbl_dias4,$per4,$lbl_dataP4,$dataP4, $lbl_dataA4, $dataA4, $lbl_dataI4, $dataI4, $lbl_dataT4, $dataT4 ));
        $this->form->addQuickField('Boletim 1º Período',$bol1,400);    
        $this->form->addQuickField('Boletim 2º Período',$bol2,400);    
        $this->form->addQuickField('Boletim 3º Período',$bol3,400);    
        $this->form->addQuickField('Boletim 4º Período',$bol4,400);    
        $this->form->addQuickField('Obs',$obs);    
        $obs->setSize(550,50);

       $this->form->addQuickAction('Limpar', new TAction(array($this, 'onClear')), 'fa:eraser red' );
       
        //Acoes do Botao 
        $this->form->addQuickAction( 'Salvar', new TAction(array($this, 'onSave')), 'ico_save.png' );
        $vbox = new TVBox;
        $vbox->add(new Adianti\Widget\Util\TXMLBreadCrumb('menu.xml', 'CadastroFerias'));
        $vbox->add($this->form);
        parent::add($vbox);
        
    }
    
      public function onSave()
    {
        $object = parent::onSave();
        if ($object instanceof Ferias)
        {
                try
                {
                    TTransaction::open($this->database);
                    $object->store();
                  
                    //$this->onClear();
                 
           
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
   


   
}//fim da classe

?>


