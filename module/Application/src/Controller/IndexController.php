<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\MainForm;
use Application\Clases\Calculadora;

class IndexController extends AbstractActionController
{
    /**
     * @var \TCPDF
     */
    protected $tcpdf;
    
    /**
     * @var RendererInterface
     */
    protected $renderer;
    
    public function __construct($tspdf, $renderer)
    {
        $this->tcpdf = $tspdf;
        
        $this->renderer = $renderer;
    }
    
    public function indexAction(){
        
        return new ViewModel();
    }

    public function calculadoraAction(){
        
        $form = new MainForm();
        
        $form->get('submit')->setValue("Generar");
        
        return [
            'form' => $form
        ];
    }

    public function generarAction(){
       
        $postData = $this->getRequest()->getPost();
        
        $calculadora = new Calculadora($postData);
        
        $pdf = $this->tcpdf;
        
        $view = new ViewModel();
        
        $renderer = $this->renderer;
        
        $view->setTemplate('layout/pdf.phtml');
        
        $view->setVariable('nombre_completo', $_POST['nombres'].' '.$_POST['apellidos']);
        
        $view->setVariable('identificacion', $_POST['identificacion']);
        
        $view->setVariable('valor_solicitado', $_POST['valor']);
        
        $view->setVariable('plazo', $_POST['plazo']);
        
        $view->setVariable('periodo_gracia', $_POST['periodo_gracia']);
        
        $view->setVariable('amortizacion', $_POST['amortizacion']);
        
        $view->setVariable('efectivo_anual', $calculadora->getEfectivoAnual());
        
        $view->setVariable('nominal_anual', $calculadora->getNominalAnual());
        
        $view->setVariable('periodico', $calculadora->getPeriodico());
        
        $html = $renderer->render($view);
        
        $viewTable = new ViewModel();
        
        $viewTable->setTemplate('layout/table_pdf.phtml');
        
        if ($_POST['periodo_gracia'] == 0)
        
            $viewTable->setVariable('tableTittle', 'Cuadro de amortización cuota fija');
        
        else
            
            $viewTable->setVariable('tableTittle', 'Cuadro de amortización cuota fija con periodo de gracia');
        
        $viewTable->setVariable('tableContent', $calculadora->getTableAmortizacionCuotaFija());
        
        $htmlTable = $renderer->render($viewTable);
        
        $pdf->SetFont('arialnarrow', '', 12, '', false);
        
        $pdf->AddPage('LANDSCAPE');
        
        $pdf->writeHTML(($html.$htmlTable), true, false, true, false, '');
        
        $pdf->Output(dirname(__FILE__) .'../../../../../data/pdf/solicitud_credito_'.$_POST['identificacion'].'.pdf',"FD");
    }
}
