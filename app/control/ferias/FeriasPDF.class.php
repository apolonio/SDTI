<?php
/** 
 * Esser Relatorio exibi dados da tabela system_pacientes
 * @copyright (c) 2016, Apolonio S. S. Junior ICRIACOES Sistemas Web!s - 2ºSgt Santiago
 * @email apolocomputacao@gmail.com
 */
class FeriasPDF extends TPage
{
    private $form; // form

    function __construct()
    {
        parent::__construct();
        
        ini_set( 'display_errors', 0 );
        
        $this->form = new TForm('form_Ferias_Report');
        $this->form->class = 'tform'; // CSS class
        $table = new TTable;
        $table-> width = '650px';

        $this->form->add($table);

        $codF         = new TEntry('coF');
        $codMilitar    = new TDBCombo('codMilitar', 'permission', 'Militar', 'nome', 'nome');
        $ano = new TCombo('ano');
        $per1 = new TEntry('aper');
        $dataI = new TEntry('dataI');
        $dataT = new TEntry('dataT');
        $dataP = new TEntry('dataP');
        $dataA = new TEntry('dataA');
        $bol1 = new TEntry('bol1');
        $obs = new TEntry('obs');

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
        $ano->addItems($a);

        
        // Tela de Saída     
        $output_type  = new TRadioGroup('output_type');
        $options = array('html' => 'HTML', 'pdf' => 'PDF', 'rtf' => 'RTF');
        $output_type->addItems($options);
        $output_type->setValue('pdf');
        $output_type->setLayout('horizontal');
        
        // define the sizes
        $codMilitar->setSize(300);
        $ano->setSize(70);
        
        // add a row for the field name
        $row  = $table->addRowSet(new TLabel('Férias - Relatórios para Impressão'), '');
        $row->class = 'tformtitle'; // CSS class
        
        // add the fields into the table
        $table->addRowSet(new TLabel('Militar' . ': '), $codMilitar);
        $table->addRowSet(new TLabel('ano' . ': '), $ano);
        $table->addRowSet(new TLabel('Tipo Saída' . ': '), $output_type);
        
        // create an action button (save)
        $save_button=new TButton('generate');
        $save_button->setAction(new TAction(array($this, 'onGenerate')), 'Gerar');
        $save_button->setImage('ico_save.png');

        // add a row for the form action
        $row = $table->addRowSet($save_button, '');
        $row->class = 'tformaction';

        // define wich are the form fields
        //$this->form->setFields(array($name,$tipo_id,$tipo_name,$output_type,$save_button));
        $this->form->setFields(array($codF,$codMilitar,$ano,$per1,$dataI,$dataT,$dataP,$dataA,$bol1,$output_type,$save_button));
        
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
            // open a transaction with database 'samples'
            TTransaction::open('permission');
            
            // get the form data into an active record Customer
            $object = $this->form->getData();
            
           // var_dump($object);
            $repository = new TRepository('Ferias');
	

            $criteria   = new TCriteria;
            if ($object->codMilitar)
            {
                $criteria->add(new TFilter('codMilitar', '=', "{$object->codMilitar}"));
            }

            if ($object->ano)
            {
                $criteria->add(new TFilter('ano', '=', "{$object->ano}"));
            }
            
        
     
        
            $order = isset($param['order']) ? $param['order'] : 'codMilitar';          
            $criteria ->setProperty('order', $order);   

            $ferias = $repository->load($criteria);
            $format  = $object->output_type;
            
            if ($ferias)
            {                 //01-02-03--04-05-06-07-08-09
                $widths = array(30,60,150,40,90,120,60,60,60);
                
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
                    $tr->addStyle('title', 'Arial',  '10', '', '#d3d3d3', '#407B49');
                    $tr->addStyle('datap', 'Arial',  '8',  '', '#000000', '#869FBB');
                    $tr->addStyle('datai', 'Arial',  '8',  '', '#000000', '#ffffff');
                    $tr->addStyle('header', 'Times', '12',  '', '#000000', '#B5FFB4');
                    $tr->addStyle('footer', 'Times', '10',  '', '#2B2B2B', '#B5FFB4');
                    
                    // add a header row
                    $tr->addRow();
                    $tr->addCell('Relatório de Férias - DTI', 'center', 'header', 40);
                    
                    // add titles row
                    $tr->addRow();
                    $tr->addCell('Or', 'center', 'title');
                    $tr->addCell('ID', 'center', 'title');
                    $tr->addCell('Militar', 'center', 'title');
                    $tr->addCell('Ano', 'center', 'title');
                    $tr->addCell('Período', 'center', 'title');
                    $tr->addCell('DataI', 'center', 'title');
                    $tr->addCell('DataT', 'center', 'title');
                    $tr->addCell('DataP', 'center', 'title');
                    $tr->addCell('DataA', 'center', 'title');
                    $tr->addCell('Boletim', 'center', 'title');

                    // controls the background filling
                    $colour= FALSE;
                    $i=0;
                    // data rows
                    foreach ($ferias as $fer)
                    {
                        $i++;
                      //  $style = $colour ? 'datap' : 'datai';
                        $style = 'datai';
                        $tr->addRow();
                        $tr->addCell($i, 'center', $style);
                        $tr->addCell($fer->codF, 'center', $style);
                        $tr->addCell($fer->codMilitar, 'center', $style);
                        $tr->addCell($fer->ano, 'center', $style);
                        $tr->addCell($fer->per1, 'center', $style);
                        $tr->addCell($fer->DataI, 'center', $style);
                        $tr->addCell($fer->DataT, 'center', $style);
                        $tr->addCell($fer->DataP, 'center', $style);
                        $tr->addCell($fer->DataC, 'center', $style);
                        $tr->addCell($fer->obs, 'center', $style);

                        $colour = !$colour;
                    }
                    
                    $tr->addRow();
                    $tr->addCell(date('Y-m-d h:i:s'), 'center', 'footer', 15);
                    if (!file_exists("app/output/tabular.{$format}") OR is_writable("app/output/tabular.{$format}"))
                    {
                        $tr->save("app/output/tabular.{$format}");
                    }
                    else
                    {
                        throw new Exception(_t('Permission denied') . ': ' . "app/output/tabular.{$format}");
                    }
                    
                    parent::openFile("app/output/tabular.{$format}");
                    
                    new TMessage('info', 'Relatório gerado. Habilite o popup no seu navegador.');
                }
            }
            else
            {
                new TMessage('error', 'Registro não encontrado');
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


}
