<?php

namespace Application\Form;

use Zend\Form\Form;


class MainForm extends Form {
    
    public function __construct()
    {
        parent::__construct('formulario');
        
        
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
            'name' => 'valor',
            'type' => 'text',
            'options' => [
                'label' => 'Valor prestamo',
            ],
        ]);
        
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Calcular',
                'id'    => 'submitbutton',
            ],
        ]);
        
    }
    
}