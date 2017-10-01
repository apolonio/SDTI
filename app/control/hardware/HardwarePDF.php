<?php
/** 
 * Esser Relatorio exibi dados da tabela system_hard
 * @copyright (c) 2016, Apolonio S. S. Junior ICRIACOES Sistemas Web!s - 2ºSgt Santiago
 * @email apolocomputacao@gmail.com
 */
class HardwarePDF extends TPage
{
    private $form; // form

    function __construct()
    {
        parent::__construct();
        
        ini_set( 'display_errors', 0 );
        
        $this->form = new TForm('form_Militar_Report');
        $this->form->class = 'tform'; // CSS class
        $table = new TTable;
        $table-> width = '650px';

        $this->form->add($table);

        $id = new TEntry('id');
        $dti = new TEntry('dti');
        $patrimonio = new TEntry('patrimonio');
        $patrimonio->setSize(200);
        $ficha = new TEntry('ficha');
        $ficha->setSize(200);
        $nrSerie = new TEntry('nrSerie');
        $nrSerie->setSize(200);
        $trem = new TEntry('trem');
        $trem->setSize(200);
        $boletim = new TEntry('boletim');
        $boletim->setSize(200);
        $diex = new TEntry('diex');
        $diex->setSize(300);
        $om = new TDBCombo('om','permission','Om','abreviatura','abreviatura');
        $om->setSize(200);
        $secao = new TEntry('secao');
        $secao->setSize(200);
        $marca = new TEntry('marca');
        $marca->setSize(200);
        $modelo = new TEntry('modelo');
        $modelo->setSize(200);
        $descricao = new \Adianti\Widget\Form\TText('descricao');
        $descricao->setSize(200);
        $dataHard = new TEntry('dataHard');
        $dataHard->setSize(200);
      
        // Tela de Saída     
        $output_type  = new TRadioGroup('output_type');
        $options = array('html' => 'HTML', 'pdf' => 'PDF', 'rtf' => 'RTF');
        $output_type->addItems($options);
        $output_type->setValue('pdf');
        $output_type->setLayout('horizontal');
        
        
        // add a row for the field name
        $row  = $table->addRowSet(new TLabel('DTI - Relatório de Materiais para Impressão'), '');
        $row->class = 'tformtitle'; // CSS class
        
        // add the fields into the table
        $table->addRowSet(new TLabel('DTI' . ': '), $dti);
        $table->addRowSet(new TLabel('OM' . ': '), $om);
        $table->addRowSet(new TLabel('Seção' . ': '), $secao);
        $table->addRowSet(new TLabel('Tipo Saída' . ': '), $output_type);
        
        // create an action button (save)
        $save_button=new TButton('generate');
        $save_button->setAction(new TAction(array($this, 'onGenerate')), 'Gerar');
        $save_button->setImage('ico_save.png');

        // add a row for the form action
        $row = $table->addRowSet($save_button, '');
        $row->class = 'tformaction';

        // define wich are the form fields
        $this->form->setFields(array($id, $dti, $patrimonio, $ficha, 
            $nrSerie, $trem, $boletim, $diex,$om, $secao, $marca, 
            $descricao, $dataHard, $output_type,$save_button));
        
        // wrap the page content using vertical box
        $vbox = new TVBox;
        $vbox->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $vbox->add($this->form);

        parent::add($vbox);
    }

    /**
     * method onGenerate()
     * Executed whenever the user clicks at the generate button
     */
    function onGenerate()
    {
        try
        {
            TTransaction::open('permission');
            
            $object = $this->form->getData();
            
            $repository = new TRepository('Hardware');

            $criteria   = new TCriteria;
            if ($object->secao)
            {
                $criteria->add(new TFilter('secao', 'like', "%{$object->secao}%"));
            }
            if ($object->descricao)
            {
                $criteria->add(new TFilter('descricao', 'like', "%{$object->descricao}%"));
            }

            if ($object->om)
            {
                $criteria->add(new TFilter('om', '=', "{$object->om}"));
            }
     
        
            $order = isset($param['order']) ? $param['order'] : 'id';          
            $criteria ->setProperty('order', $order);   
         
            $hard = $repository->load($criteria);
            
            $format  = $object->output_type;
            // print_r($militar);
            if ($hard)
            {                
                $widths = array(25,30,30,40,40,40,30,60,60,60,70,80,150,50);
                
                switch ($format)
                {
                    case 'html':
                        $tr = new TTableWriterHTML($widths);
                        break;
                    case 'pdf':
                        //alterei o parametro da classe para L paisagem
                        $tr = new TTableWriterPDF($widths,'L');
                        break;
                    case 'rtf':
                        if (!class_exists('PHPRtfLite_Autoloader'))
                        {
                            PHPRtfLite::registerAutoloader();
                        }
                        $tr = new TTableWriterRTF($widths);
                        break;
                }
                
                if (!empty($tr))
                {
                    // create the document styles
                    $tr->addStyle('title', 'Arial',  '6', '', '#d3d3d3', '#407B49');
                    $tr->addStyle('datap', 'Arial',  '6',  '', '#000000', '#869FBB');
                    $tr->addStyle('datai', 'Arial',  '6',  '', '#000000', '#ffffff');
                    $tr->addStyle('header', 'Times', '12',  '', '#000000', '#B5FFB4');
                    $tr->addStyle('footer', 'Times', '6',  '', '#2B2B2B', '#B5FFB4');
                    
                    // add a header row
                    $tr->addRow();
                    $tr->addCell('Relatório Materiais DTI 2017', 'center', 'header', 40);
                    
                    // add titles row
                    $tr->addRow();
                    $tr->addCell('OR', 'center', 'title');
                    $tr->addCell('ID', 'center', 'title');
                    $tr->addCell('DTI', 'center', 'title');
                    $tr->addCell('PATR.', 'center', 'title');
                    $tr->addCell('FICHA', 'center', 'title');
                    $tr->addCell('Nr.Série.', 'center', 'title');
                    $tr->addCell('DIEx', 'center', 'title');
                    $tr->addCell('TREM', 'center', 'title');
                    $tr->addCell('BOL', 'center', 'title');
                    $tr->addCell('OM', 'center', 'title');
                    $tr->addCell('SEÇÃO', 'center', 'title');
                    $tr->addCell('MARCA', 'center', 'title');
                    //$tr->addCell('MODELO', 'center', 'title');
                    $tr->addCell('DESCRIÇÃO', 'center', 'title');
                    $tr->addCell('DATA', 'center', 'title');

                    $colour= FALSE;
                    $i=0;
                    foreach ($hard as $fer)
                    {
                        $i++;
                      //  $style = $colour ? 'datap' : 'datai';
                        $style = 'datai';
                        $tr->addRow();
                        $tr->addCell($i, 'center', $style);
                        $tr->addCell($fer->id, 'center', $style);
                        $tr->addCell($fer->dti, 'center', $style);
                        $tr->addCell($fer->patrimonio, 'center', $style);
                        $tr->addCell($fer->ficha, 'center', $style);
                        $tr->addCell($fer->nrSerie, 'center', $style);
                        $tr->addCell($fer->diex, 'center', $style);
                        $tr->addCell($fer->trem, 'center', $style);
                        $tr->addCell($fer->boletim, 'center', $style);
                        $tr->addCell($fer->om, 'center', $style);
                        $tr->addCell($fer->secao, 'center', $style);
                        $tr->addCell($fer->marca, 'center', $style);
                     //   $tr->addCell($fer->modelo, 'center', $style);
                        $tr->addCell($fer->descricao, 'center', $style);
                        $tr->addCell($fer->dataHard, 'center', $style);

                        $colour = !$colour;
                    }
                    
                    $tr->addRow();
                    $tr->addCell(date('Y-m-d h:i:s'), 'center', 'footer', 15);
                    if (!file_exists("app/output/dispositivo.{$format}") OR is_writable("app/output/dispositivo.{$format}"))
                    {
                        $tr->save("app/output/dispositivo.{$format}");
                    }
                    else
                    {
                        throw new Exception(_t('Permission denied') . ': ' . "app/output/dispositivo.{$format}");
                    }
                    
                    parent::openFile("app/output/dispositivo.{$format}");
                    
                    new TMessage('info', 'Relatório gerado. Habilite o popup no seu navegador.');
                }
            }
            else
            {
                new TMessage('error', 'Dispositivo não encontrado');
            }
    
            $this->form->setData($object);
            
            TTransaction::close();
        }
        catch (Exception $e) 
        {
            new TMessage('error', '<b>Error</b> ' . $e->getMessage());
            
            TTransaction::rollback();
        }
    }
}
?>

