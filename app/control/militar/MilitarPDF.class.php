<?php
/** 
 * Esser Relatorio exibi dados da tabela system_pacientes
 * @copyright (c) 2016, Apolonio S. S. Junior ICRIACOES Sistemas Web!s - 2ºSgt Santiago
 * @email apolocomputacao@gmail.com
 */
class MilitarPDF extends TPage
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

        $nome    = new TEntry('nome');
        $su    = new TDBCombo('secao', 'permission', 'Su', 'descricao', 'descricao');
        $subunidade = new TDBCombo('reparticao', 'permission', 'Subunidade', 'descricao', 'descricao');
        $pg = new TDBCombo('pg','permission','Posto','sigla','sigla');
        $guerra = new TEntry('guerra');
        $telefone = new TEntry('telefone1');
        $endereco = new TEntry('endereco');
        $cidade = new TEntry('cidade');
        $bairro = new TEntry('bairro');
        
        // Tela de Saída     
        $output_type  = new TRadioGroup('output_type');
        $options = array('html' => 'HTML', 'pdf' => 'PDF', 'rtf' => 'RTF');
        $output_type->addItems($options);
        $output_type->setValue('pdf');
        $output_type->setLayout('horizontal');
        
        // define the sizes
        $nome->setSize(300);
        
        // add a row for the field name
        $row  = $table->addRowSet(new TLabel('Militares - Relatórios para Impressão'), '');
        $row->class = 'tformtitle'; // CSS class
        
        // add the fields into the table
        $table->addRowSet(new TLabel('Militar' . ': '), $nome);
        $table->addRowSet(new TLabel('Posto/Grad.' . ': '), $pg);
        $table->addRowSet(new TLabel('Seção' . ': '), $subunidade);
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
        $this->form->setFields(array($nome,$pg,$su,$subunidade, $guerra, $telefone, $endereco, $bairro, $cidade, $output_type,$save_button));
        
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
            $repository = new TRepository('Militar');
	

            $criteria   = new TCriteria;
            if ($object->nome)
            {
                $criteria->add(new TFilter('nome', 'like', "%{$object->nome}%"));
            }

            if ($object->reparticao)
            {
                $criteria->add(new TFilter('reparticao', '=', "{$object->reparticao}"));
            }
            if ($object->pg)
            {
                $criteria->add(new TFilter('pg', 'like', "%{$object->pg}%"));
            }
            
               
        
     
        
            $order = isset($param['order']) ? $param['order'] : 'reparticao';          
            $criteria ->setProperty('order', $order);   

            $militar = $repository->load($criteria);
            $format  = $object->output_type;
            // print_r($militar);
            if ($militar)
            {                 //01-02-03--04-05-06-07-08-09
                $widths = array(30,40,180,60,60,80,200,50,50);
                
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
                    $tr->addStyle('datap', 'Arial',  '6',  '', '#000000', '#869FBB');
                    $tr->addStyle('datai', 'Arial',  '6',  '', '#000000', '#ffffff');
                    $tr->addStyle('header', 'Times', '12',  '', '#000000', '#B5FFB4');
                    $tr->addStyle('footer', 'Times', '10',  '', '#2B2B2B', '#B5FFB4');
                    
                    // add a header row
                    $tr->addRow();
                    $tr->addCell('Relatório Militares - Plano de Chamada', 'center', 'header', 40);
                    
                    // add titles row
                    $tr->addRow();
                    $tr->addCell('Or', 'center', 'title');
                    $tr->addCell('PG', 'center', 'title');
                    $tr->addCell('Guerra', 'center', 'title');
                    $tr->addCell('SU', 'center', 'title');
                    $tr->addCell('Seção', 'center', 'title');
                    $tr->addCell('telefone', 'center', 'title');
                    $tr->addCell('Endereço', 'center', 'title');
                    $tr->addCell('Bairro', 'center', 'title');
                    $tr->addCell('Cidade', 'center', 'title');

                    // controls the background filling
                    $colour= FALSE;
                    $i=0;
                    // data rows
                    foreach ($militar as $fer)
                    {
                        $i++;
                      //  $style = $colour ? 'datap' : 'datai';
                        $style = 'datai';
                        $tr->addRow();
                        $tr->addCell($i, 'center', $style);
                        $tr->addCell($fer->pg, 'center', $style);
                        $tr->addCell($fer->nome, 'center', $style);
                        $tr->addCell($fer->secao, 'center', $style);
                        $tr->addCell($fer->reparticao, 'center', $style);
                        $tr->addCell($fer->telefone1, 'center', $style);
                        $tr->addCell($fer->endereco, 'center', $style);
                        $tr->addCell($fer->bairro, 'center', $style);
                        $tr->addCell($fer->cidade, 'center', $style);

                        $colour = !$colour;
                    }
                    
                    $tr->addRow();
                    $tr->addCell(date('Y-m-d h:i:s'), 'center', 'footer', 15);
                    if (!file_exists("app/output/militar.{$format}") OR is_writable("app/output/militar.{$format}"))
                    {
                        $tr->save("app/output/militar.{$format}");
                    }
                    else
                    {
                        throw new Exception(_t('Permission denied') . ': ' . "app/output/militar.{$format}");
                    }
                    
                    parent::openFile("app/output/militar.{$format}");
                    
                    new TMessage('info', 'Relatório gerado. Habilite o popup no seu navegador.');
                }
            }
            else
            {
                new TMessage('error', 'Militar não encontrado');
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

