<?php
/** 
 * Esse Relatorio exibi dados da tabela system_manutencao
 * @copyright (c) 2016, Apolonio S. S. Junior ICRIACOES Sistemas Web!s - 2ºSgt Santiago
 * @email apolocomputacao@gmail.com
 */
class ManutencaoPDF extends TPage
{
    private $form; // form

    function __construct()
    {
        parent::__construct();
        
        ini_set( 'display_errors', 0 );
        
        $this->form = new TForm('Relatório de Manutenção - DTI');
        $this->form->class = 'tform'; // CSS class
        $table = new TTable;
        $table-> width = '650px';

        $this->form->add($table);

        $idMnt = new TEntry('idMnt');
        $dti = new TEntry('dti');
        $os= new TEntry('os');
        $os->setSize(100);
        $solicitante = new TEntry('solicitante');
        $solicitante->setSize(200);
        $tecnico = new TEntry('tecnico');
        $tecnico->setSize(200);
        $localExecucao= new TCombo('localExecucao');
        $localExecucao->setSize(200);
        $tipoMaterial= new TEntry('tipoMaterial');
        $tipoMaterial->setSize(200);
        $om = new TDBCombo('om','permission','Om','abreviatura','abreviatura');
        $om->setSize(200);
        $secao = new TEntry('secao');
        $secao->setSize(200);
        $ramal= new TEntry('ramal');
        $ramal->setSize(120);
        $dataEntrada = new TDate('dataEntrada');
        $dataEntrada->setSize(200);
        $descricao = new TEntry('descricao');
        $descricao->setSize(200);
        $defeito = new TEntry('defeito');
        $defeito->setSize(200);
        $procedimento = new TEntry('procedimento');
        $procedimento->setSize(200);
        $situacao = new TCombo('situacao');
        $situacao->setSize(200);
        $dataMnt = new TDate('dataMnt');
        $dataMnt->setSize(200);
        
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
        
      
        // Tela de Saída     
        $output_type  = new TRadioGroup('output_type');
        $options = array('html' => 'HTML', 'pdf' => 'PDF', 'rtf' => 'RTF');
        $output_type->addItems($options);
        $output_type->setValue('pdf');
        $output_type->setLayout('horizontal');
        
        
        // add a row for the field name
        $row  = $table->addRowSet(new TLabel('DTI - Relatório de Manutenção - Filtro'), '');
        $row->class = 'tformtitle'; // CSS class
        
        // add the fields into the table
        $table->addRowSet(new TLabel('DTI' . ': '), $dti);
        $table->addRowSet(new TLabel('OM' . ': '), $om);
     //   $table->addRowSet(new TLabel('Seção' . ': '), $secao);
       // $table->addRowSet(new TLabel('Tipo Material' . ': '), $tipo);
      // // $table->addRowSet(new TLabel('Descrição' . ': '), $descricao);
      //  $table->addRowSet(new TLabel('Data Mnt' . ': '), $dataMnt);
      //  $table->addRowSet(new TLabel('Situação' . ': '), $situacao);
        $table->addRowSet(new TLabel('Tipo Saída' . ': '), $output_type);
        
        $save_button=new TButton('generate');
        $save_button->setAction(new TAction(array($this, 'onGenerate')), 'Gerar');
        $save_button->setImage('ico_save.png');

        $row = $table->addRowSet($save_button, '');
        $row->class = 'tformaction';

        $this->form->setFields(array($idMnt,$dti, $os, $solicitante, $tecnico,
                                    $localExecucao, $om, $secao,$ramal, 
                                    $tipoMaterial, $descricao,$defeito, $procedimento, $situacao,
                                    $dataEntrada, $dataMnt,
                                    $output_type,$save_button));
        
        $vbox = new TVBox;
        $vbox->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $vbox->add($this->form);

        parent::add($vbox);
    }

    function onGenerate()
    {
        try
        {
            TTransaction::open('permission');
            
            $object = $this->form->getData();
           
            $repository = new TRepository('AcessoManutencao');

            $criteria   = new TCriteria;
            if ($object->dti)
            {
                $criteria->add(new TFilter('dti', 'like', "%{$object->dti}%"));
            }
      
            if ($object->om)
            {
                $criteria->add(new TFilter('om', '=', "{$object->om}"));
            }
        
            $order = isset($param['order']) ? $param['order'] : 'idMnt';          
            $criteria ->setProperty('order', $order);   
           
            $hard = $repository->load($criteria);
           
            $format  = $object->output_type;
            
            if ($hard)
            {                 //01-02-03-04-05-06-07-08-09-10-11-12-13-14-15-16-17
                $widths = array(25,30,30,50,40,40,40,30,60,60,60,70,60,70,70,70,80);
                
                switch ($format)
                {
                    case 'html':
                        $tr = new TTableWriterHTML($widths);
                        break;
                    case 'pdf':
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
                    $tr->addCell('Relatório Manutenção DTI', 'center', 'header', 40);
                    
                    // add titles row
                    $tr->addRow();
                    $tr->addCell('OR', 'center', 'title');
                    $tr->addCell('ID', 'center', 'title');
                    $tr->addCell('DTI', 'center', 'title');
                    $tr->addCell('OS.', 'center', 'title');
                    $tr->addCell('Solicitante', 'center', 'title');
                    $tr->addCell('Técnico.', 'center', 'title');
                    $tr->addCell('Local', 'center', 'title');
                    $tr->addCell('OM', 'center', 'title');
                    $tr->addCell('SEÇÃO', 'center', 'title');
                    $tr->addCell('Ramal', 'center', 'title');
                    $tr->addCell('Tipo', 'center', 'title');
                    $tr->addCell('Descrição', 'center', 'title');
                    $tr->addCell('Defeito', 'center', 'title');
                    $tr->addCell('Procedimento', 'center', 'title');
                    $tr->addCell('Situação', 'center', 'title');
                    $tr->addCell('DATA E.', 'center', 'title');
                    $tr->addCell('DATA S.', 'center', 'title');

                    $colour= FALSE;
                    $i=0;

                    foreach ($hard as $fer)
                    {
                        $i++;
                       $style = $colour ? 'datap' : 'datai';
                        $style = 'datai';
                        $tr->addRow();
                        $tr->addCell($i, 'center', $style);
                        $tr->addCell($fer->idMnt, 'center', $style);
                        $tr->addCell($fer->dti, 'center', $style);
                        $tr->addCell($fer->os, 'center', $style);
                        $tr->addCell($fer->solicitante, 'center', $style);
                        $tr->addCell($fer->tecnico, 'center', $style);
                        $tr->addCell($fer->localExecucao, 'center', $style);
                        $tr->addCell($fer->om, 'center', $style);
                        $tr->addCell($fer->secao, 'center', $style);
                        $tr->addCell($fer->ramal, 'center', $style);
                        $tr->addCell($fer->tipoMaterial, 'center', $style);
                        $tr->addCell($fer->descricao, 'center', $style);
                        $tr->addCell($fer->defeito, 'center', $style);
                        $tr->addCell($fer->procedimento, 'center', $style);
                        $tr->addCell($fer->situacao, 'center', $style);
                        $tr->addCell($fer->dataEntrada, 'center', $style);
                        $tr->addCell($fer->dataMnt, 'center', $style);

                        $colour = !$colour;
                    }
                    
                    $tr->addRow();
                    $tr->addCell(date('Y-m-d h:i:s'), 'center', 'footer', 15);
                    if (!file_exists("app/output/manutencao.{$format}") OR is_writable("app/output/manutencao.{$format}"))
                    {
                        $tr->save("app/output/manutencao.{$format}");
                    }
                    else
                    {
                        throw new Exception(_t('Permission denied') . ': ' . "app/output/manutencao.{$format}");
                    }
                    parent::openFile("app/output/manutencao.{$format}");
                    new TMessage('info', 'Relatório gerado. Habilite o popup no seu navegador.');
                }
            }
            else
            {
                new TMessage('error', 'Manutenção não encontrado');
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

