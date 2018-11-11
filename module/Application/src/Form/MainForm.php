<?php

namespace Application\Form;

use Zend\Form\Form;


class MainForm extends Form {
    
    public function __construct()
    {
        parent::__construct('formulario');
        
        $this->attributes['target'] = '_blank'; 
        
        $this->add([
            'name' => 'identificacion',
            'type' => 'text',
            'options' => [
                'label' => 'Indentifiación',
            ],
        ]);

        $this->add([
            'name' => 'nombres',
            'type' => 'text',
            'options' => [
                'label' => 'Nombres',
            ],
        ]);
        
        $this->add([
            'name' => 'apellidos',
            'type' => 'text',
            'options' => [
                'label' => 'Apellidos',
            ],
        ]);
        
        $this->add([
            'name' => 'valor',
            'type' => 'text',
            'options' => [
                'label' => 'Valor prestamo',
            ],
            'attributes' => [
                'id' => 'valor',
            ],
        ]);
        
        $this->add([
            'name' => 'tipo_prestamo',
            'type' => 'select',
            'attributes' => [
                'id' => 'tipo_prestamo',
            ],
            'options' => [
                'label' => 'Tipo de prestamo',
                'value_options' => [
                    'fija' => 'Cuota fija',
                    'gracia' => 'Periodo de gracia' ]
            ],
        ]);
        
        $this->add([
            'name' => 'periodo_gracia',
            'type' => 'text',
            'attributes' => [
                'id' => 'periodo_gracia',
                'value' => "0",
                'readonly' => 'readonly'
            ],
            'options' => [
                'label' => 'Efectiva anual',
            ],
        ]);
        
        $this->add([
            'name' => 'plazo',
            'type' => 'select',
            'attributes' => [
                'id' => 'plazo',
            ],
            'options' => [
                'label' => 'Plazo',
                'value_options' => [
                    '3' => '3 Años',
                    '4' => '4 Años',
                    '5' => '5 Años',
                    '6' => '6 Años',
                    '7' => '7 Años',
                ]
            ],
        ]);
        
        $this->add([
            'name' => 'amortizacion',
            'type' => 'select',
            'attributes' => [
                'id' => 'amortizacion',
            ],
            'options' => [
                'label' => 'Amortización',
                'value_options' => [
                    '30' => 'Mensual',
                    '90' => 'Trimestral',
                ]
            ],
        ]);
        
        
        $this->add([
            'name' => 'efectiva_anual',
            'type' => 'text',
            'options' => [
                'label' => 'Efectiva anual',
            ],
        ]);
        
        
        $this->add([
            'name' => 'nominal_anual',
            'type' => 'text',
            'options' => [
                'label' => 'Nominal anual',
            ],
        ]);
        
        
        $this->add([
            'name' => 'periodica',
            'type' => 'text',
            'options' => [
                'label' => 'Periodica',
            ],
        ]);
        
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Calcular',
                'id'    => 'submitbutton',
                'class' => 'btn btn-primary btn-lg btn-block',
            ],
        ]);
        
    }
    
}