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
    
    public function indexAction()
    {
        return new ViewModel();
    }

    public function calculadoraAction()
    {
        $form = new MainForm();
        
        $form->get('submit')->setValue("Generar");
        
        return [
            'form' => $form
        ];
    }

    public function generarAction() 
    {
        $view = new ViewModel();
        
        $renderer = $this->renderer;
        
        $view->setTemplate('layout/pdf.phtml');
        
        $html = $renderer->render($view);
        
        $pdf = $this->tcpdf;
        
        $pdf->SetFont('arialnarrow', '', 12, '', false);
        
        $pdf->AddPage();
        
        $pdf->writeHTML($html, true, false, true, false, '');
        
        $pdf->Output();
    }
}
