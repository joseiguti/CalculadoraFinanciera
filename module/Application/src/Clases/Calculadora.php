<?php

namespace Application\Clases;

class Calculadora {

    private $efectivoAnual = 0.00;
    
    private $nominalAnual = 0.00;
    
    private $periodico = 0.00;
    
    private $plazo = 0;
    
    private $amortizacion = 0;
    
    private $prestamo = 0;
    
    private $periodo_gracia = 0;
    
    public function __construct($dataForm){
        
        $this->plazo = $dataForm->plazo;
        
        $this->amortizacion = $dataForm->amortizacion;
        
        $this->prestamo = $dataForm->valor;
        
        $this->periodo_gracia = $dataForm->periodo_gracia;
        
        if ($dataForm->efectiva_anual != 0){
            
            $this->efectivoAnual = $dataForm->efectiva_anual;
            
            $this->periodico = (pow ((1 +  ($this->efectivoAnual/100) ),( $dataForm->amortizacion/360 )) -1)*100;
            
            $this->nominalAnual = $this->periodico * (360/$this->amortizacion);
        }
        
        if ($dataForm->nominal_anual != 0 && $dataForm->efectiva_anual == 0){
            
            $this->periodico = $dataForm->nominal_anual / (360/$this->amortizacion);
            
            $this->efectivoAnual = (pow((1 + ($this->periodico/100)),(360/$dataForm->amortizacion))-1)*100;
            
            $this->nominalAnual = $dataForm->nominal_anual;
        }
        
        if ($dataForm->periodica != 0 && $dataForm->nominal_anual == 0 && $dataForm->efectiva_anual == 0){
            
            $this->periodico = $dataForm->periodica;
            
            $this->nominalAnual = $this->periodico * (360/$this->amortizacion);
            
            $this->efectivoAnual =  (pow( (1 + ($this->periodico/100)),(360/$dataForm->amortizacion))-1)*100;
        }
        
    }
    
    public  function getTableAmortizacionCuotaFija (){
        
        $cantCuotasPeriodoGracia = ($this->periodo_gracia*12*30)/($this->amortizacion);
        
        $cantCuotas = (($this->plazo*12*30)/$this->amortizacion);
        
        $html = '';
        
        $saldoCapital = $this->prestamo;
        
        $amortizacionIntereses = 0;
        
        $sumaAmortizacionIntereses = 0;
        
        $amortizacionCapital = 0;
        
        $cuotaFija = 0;
        
        $flujoCaja = $this->prestamo;
        
        for ($i = 0; $i <= $cantCuotas; $i++){
        
            if ($i%2==0){
                $bgcolor ='#b5fff8';
            }else{
                $bgcolor = '';
            }
            
            $html .= '<tr>';
            
            $html .= '<td style="background-color: '.$bgcolor.'">'.$i.'</td>'.
                '<td style="background-color: '.$bgcolor.'">'.date("Y-m-d",strtotime("+".($i*($this->amortizacion/30))." months")) .'</td>'.
                    '<td style="background-color: '.$bgcolor.'">$'.number_format(abs($saldoCapital),2).'</td>'.
                    '<td style="background-color: '.$bgcolor.'">$'.number_format($amortizacionCapital,2).'</td>'.
                    '<td style="background-color: '.$bgcolor.'">$'.number_format($amortizacionIntereses,2).'</td>'.
                    '<td style="background-color: '.$bgcolor.'">$'.number_format( (($this->periodo_gracia!=0 && $i < $cantCuotasPeriodoGracia+1)?0:$cuotaFija), 2).'</td>'.
                    '<td style="background-color: '.$bgcolor.'">'.(($i!=0)?'(':'').'$'.number_format( $flujoCaja ,2).(($i!=0)?')':'').'</td>';
        
            $html .= '</tr>';

            $amortizacionIntereses = ($saldoCapital * ($this->periodico/100));
            
            if ($this->periodo_gracia!=0 && $i < $cantCuotasPeriodoGracia)
                
                $sumaAmortizacionIntereses = $sumaAmortizacionIntereses + $amortizacionIntereses;
            
            
            $cuotaFija = $this->calculateAmortizacion( ($this->prestamo+$sumaAmortizacionIntereses), $this->periodico, ($cantCuotas-$cantCuotasPeriodoGracia));
            
            
            
            if ($this->periodo_gracia!=0 && $i < $cantCuotasPeriodoGracia){
                
                $amortizacionCapital = 0;
                
            }else{
                
                $amortizacionCapital = $cuotaFija - $amortizacionIntereses;
            }

            if ($this->periodo_gracia!=0 && $i < $cantCuotasPeriodoGracia){
                
                $saldoCapital = $saldoCapital + $amortizacionIntereses;
                
            }else{
                
                $saldoCapital = $saldoCapital - $amortizacionCapital;
                
            }
            
            
            if ($this->periodo_gracia!=0 && $i < $cantCuotasPeriodoGracia){
                
                $flujoCaja = 0;
                
            }else{
            
                $flujoCaja = $amortizacionIntereses + $amortizacionCapital;
                
            }
        }
        
        return $html;
    }
    
    public function getEfectivoAnual (){
        
        return number_format($this->efectivoAnual,2);
    }
    
    public function getNominalAnual (){
        
        return number_format($this->nominalAnual,2);
    }
    
    public function getPeriodico (){
        
        return number_format($this->periodico,2);
    }
    
    private function calculateAmortizacion ($p, $ip, $n){
        
        $ip = $ip/100;
        
        return $p * (  
            
            ( pow( (1+ $ip ), $n) * $ip ) 
            / 
            ( pow( (1+ $ip ), $n) - 1)   
        );
    }
    
}