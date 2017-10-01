<?php

class MilitarForm extends Adianti\Control\TWindow
{
    private $form; // form

    function __construct()
    {
        parent::__construct();
        // creates the form
        $this->form = new TForm('form_militar');
        
        // creates a table
        $table_data    = new TTable;
        $table_contact = new TTable;
        //$table_skill   = new TTable;
        $notebook = new TNotebook(300, 250);
        // add the notebook inside the form
        $this->form->add($notebook);
        $notebook->appendPage('Alteração de dados do Militar', $table_data);
        $notebook->appendPage('Datas', $table_contact);
        
        // create the form fields
        $id = new TEntry('id');
        $postograd = new TDBCombo('pg','permission','Posto','sigla','sigla');
        $nome = new TEntry('nome');
        $arma = new TDBCombo('arma','permission','Arma','sigla','sigla');
        $guerra = new TEntry('nomeGuerra');
        $om = new TDBCombo('om','permission','Om','abreviatura','abreviatura');
        $om->setSize(160);
        $su = new TDBCombo('secao','permission','Su','sigla','sigla');
        $su->setSize(120);
        $subunidade = new TDBCombo('reparticao','permission','Subunidade','descricao','descricao');
        $subunidade->setSize(120);
        
        $identidade = new TEntry('identidade');
        $cpf = new TEntry('cpf');
        $preccp = new TEntry('preccp');
        
        $telefone1 = new TEntry('telefone1');
        $telefone2 = new TEntry('telefone2');
        $telefone1->setMask('(99)99999-9999');
        $telefone2->setMask('(99)99999-9999');
   
        $dataNascimento = new TDate('dataNascimento');
        $dataNascimento->setMask('dd/mm/yyyy');
        $dataNascimento->setDatabaseMask('yyyy-mm-dd');
        $dataNascimento->setSize(100);
        
        $dataPromocao = new TDate('dataPromocao');
        $dataPromocao->setMask('dd/mm/yyyy');
        $dataPromocao->setDatabaseMask('yyyy-mm-dd');
        $dataPromocao->setSize(100);

        $endereco = new TEntry('endereco');
        
        $dataApresentacao = new TDate('dataApresentacao');
        $dataApresentacao->setMask('dd/mm/yyyy');
        $dataApresentacao->setDatabaseMask('yyyy-mm-dd');
        $dataApresentacao->setSize(100);
        
        $dataGuarnicao = new TDate('dataGuarnicao');
        $dataGuarnicao->setMask('dd/mm/yyyy');
        $dataGuarnicao->setDatabaseMask('yyyy-mm-dd');
        $dataGuarnicao->setSize(100);
        
        $dataPraca1 = new TDate('dataPraca1');
        $dataPraca1->setMask('dd/mm/yyyy');
        $dataPraca1->setDatabaseMask('yyyy-mm-dd');
        $dataPraca1->setSize(100);
    
        $dataPraca2 = new TDate('dataPraca2');
        $dataPraca2->setMask('dd/mm/yyyy');
        $dataPraca2->setDatabaseMask('yyyy-mm-dd');
        $dataPraca2->setSize(100);
        
        // define some properties for the form fields
        $id->setEditable(FALSE);
        $postograd->setSize(80);
        $nome->setSize(350);
        $guerra->setSize(150);
        $endereco->setSize(400);
        
        
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
        $lbl_promocao->setSize(120);
        $lbl_guarnicao =  new TLabel('Data Guarnição');
        $lbl_guarnicao->setSize(120); 
        $lbl_nascimento =  new TLabel('Data Nascimento');
        $lbl_nascimento->setSize(140); 
        
        $lbl_data2 =  new TLabel('Data Praça 2');
        $lbl_data2->setSize(120); 
        
        // add a row for the field code
       
        $table_data->addRowSet(new TLabel('Id:'),   array($id, new TLabel('OMDs:'), $om));
        $table_data->addRowSet(new TLabel('Posto/Grad:'),   array($postograd, new TLabel('Nome:'), $nome));
        $table_data->addRowSet(new TLabel('Arma:'),   array($arma, new TLabel('N. Guerra:'), $guerra));
        $table_data->addRowSet(new TLabel('SU:'),   array($su, new TLabel('Subunidade:'), $subunidade));
        $table_data->addRowSet(new TLabel('Data Promoção'),   array($dataPromocao, new TLabel('Prec-CP:'), $preccp));
        $table_data->addRowSet(new TLabel('Identidade:'),   array($identidade, new TLabel('    CPF:'), $cpf));
        $table_data->addRowSet(new TLabel('Telefone 01'),   array($telefone1, new TLabel('Telefone 02:'), $telefone2));
        
        $table_data->addRowSet(new TLabel('Endereço:'), $endereco);
        
        
        $table_contact->addRowSet(new TLabel('Data Praça1'),   array($dataPraca1, new TLabel('Data Praça2:'), $dataPraca2));
        $table_contact->addRowSet(new TLabel('Data Apresentação'), array($dataApresentacao, new TLabel('Data Guarnição:'), $dataGuarnicao ));  
        
        
        // create an action button
        $button1=new TButton('action1');
        $button1->setAction(new TAction(array($this, 'onSave')), 'Atualizar');
        $button1->setImage('ico_save.png');
        
        // create an action button (go to list)
        $button2=new TButton('list');
        $button2->setAction(new TAction(array('PesquisaMilitar', 'onReload')), 'Relatorio');
        $button2->setImage('ico_datagrid.gif');
        
        // define wich are the form fields
        $this->form->setFields(array($id, $postograd, $arma, $nome, $guerra, $su, $om, $subunidade, $dataPromocao, $identidade, $preccp, $cpf, $telefone1, $telefone2, $dataPraca1, $dataPraca2, $endereco,
                                    $dataApresentacao, $dataGuarnicao, $dataNascimento, $button1, $button2));
        
        $subtable = new TTable;
        $row = $subtable->addRow();
        $row->addCell($button1);
        $row->addCell($button2);
        
        // wrap the page content
        $vbox = new TVBox;
        $vbox->add(new TXMLBreadCrumb('menu.xml', 'PesquisaMilitar'));
        $vbox->add($this->form);
        $vbox->add($subtable);
        
        // add the form inside the page
        parent::add($vbox);
    }
    
    /**
     * method onSave
     * Executed whenever the user clicks at the save button
     */
    function onSave()
    {
        try
        {
            // open a transaction with database 'samples'
            TTransaction::open('permission');
            
            $this->form->validate();
            // read the form data and instantiates an Active Record
            $customer = $this->form->getData('Militar');
            
            // stores the object in the database
            $customer->store();
            
            $this->form->setData($customer);
            
            // shows the success message
            new TMessage('info', 'Registro Salvo');
            
            TTransaction::close(); // close the transaction
        }
        catch (Exception $e) // in case of exception
        {
            // shows the exception error message
            new TMessage('error', '<b>Error</b>: ' . $e->getMessage());
            // undo all pending operations
            TTransaction::rollback();
        }
    }
    
    /**
     * method onEdit
     * Edit a record data
     */
    function onEdit($param)
    {
        try
        {
            if (isset($param['key']))
            {
                // open a transaction with database 'samples'
                TTransaction::open('permission');
                
                 // load the Active Record according to its ID
                $mil= new Militar($param['key']);
                
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
?>