<?php

class SoftwareForm extends TStandardForm
{
    protected $form;
    
    function __construct()
    {
        parent::__construct();
        // creates the form
        $this->form = new TForm('form_Software');
        $this->form = new TQuickForm('form_Software');
        $this->form->class = 'tform'; // CSS class
        $this->form->style = 'width: 700px;';
   
        // defines the form title
        $this->form->setFormTitle('Sofware');
        
        // define the database and the Active Record
        parent::setDatabase('permission'); //banco
        parent::setActiveRecord('Software'); //tabela
        
    
        
        // create the form fields
        $codSoft                              = new TEntry('codSoft');
        $codTipoSoft                              = new TEntry('codTipoSoft');
        $codTipoSoftLicenca                              = new TEntry('codTipoSoftLicenca');
        $descricao                       = new TEntry('descricao');
        $documento                       = new TEntry('documento');
        $boletim                       = new TEntry('boletim');
        $qtde                       = new TEntry('qtde');
        $valorUnitario                       = new TEntry('valorUnitario');
        
        $versao = new TEntry('versao');
        $licenca = new TEntry('licenca');
        $serial = new TEntry('serial');
        $data                             = new TDate('dataCad');

        $codSoft->setEditable( FALSE );

        // add the form fields
        $this->form->addQuickField('ID', $codSoft,  50);
        $this->form->addQuickField('Tipo Software', $codTipoSoft,  300);
        $this->form->addQuickField('Tipo Licença', $codTipoSoftLicenca, 150);
        $this->form->addQuickField('Descrição', $descricao,  250);
        $this->form->addQuickField('Documento', $documento,  250);
        $this->form->addQuickField('Boletim', $boletim,  300);
        $this->form->addQuickField('Versao', $versao,  120);
        $this->form->addQuickField('Serial', $serial,  250); 
        $this->form->addQuickField('Licença', $licenca,  120);
        $this->form->addQuickField('Data', $data,  100);
   
        // add the actions
        $this->form->addQuickAction(_t('Save'), new TAction(array($this, 'onSave')), 'ico_save.png');
        $this->form->addQuickAction(_t('New'), new TAction(array($this, 'onEdit')), 'ico_new.png');
        $this->form->addQuickAction(_t('Find'), new TAction(array('PesquisaSoftware', 'onReload')), 'ico_back.png');

        $vbox = new TVBox;
        $vbox->add(new TXMLBreadCrumb('menu.xml', 'PesquisaSoftware'));
        $vbox->add($this->form);

        parent::add($vbox);
    }
    
    /**
     * Overloaded method onSave()
     * Executed whenever the user clicks at the save button
     */
    public function onSave()
    {
        // first, use the default onSave()
        $object = parent::onSave();
        
        // if the object has been saved
//        if ($object instanceof Voo)
//        {
//         //   $source_file   = 'tmp/'.$object->photo_path;
//         //   $target_file   = 'images/' . $object->photo_path;
//         //   $finfo = new finfo(FILEINFO_MIME_TYPE);
//            
//            // if the user uploaded a source file
//            if (file_exists($source_file) AND $finfo->file($source_file) == 'image/png')
//            {
//                // move to the target directory
//              //  rename($source_file, $target_file);
//                
//                try
//                {
//                    TTransaction::open($this->database);
//                    // update the photo_path
//                 //   $object->photo_path = 'images/'.$object->photo_path;
//                    $object->store();
//                    TTransaction::close();
//                }
//                catch (Exception $e) // in case of exception
//                {
//                    new TMessage('error', '<b>Error</b> ' . $e->getMessage());
//                    TTransaction::rollback();
//                }
//            }
//        }
    }
  
}
?>


