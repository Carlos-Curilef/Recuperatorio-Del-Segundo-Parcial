<?php

class ContratoViaWeb extends Contrato{
    // Atributos
    private $porcentajeDeDescuento;


    // Constructor
    public function __construct($fechaInicio, $fechaVencimiento, $objPlan,$costo,$seRennueva,$objCliente){
        parent::__construct($fechaInicio, $fechaVencimiento, $objPlan,$costo,$seRennueva,$objCliente);
        $this->porcentajeDeDescuento = 10;
    }

    // Método de acceso
    public function getPorcentajeDeDescuento(){
        return $this->porcentajeDeDescuento;
    }

    // Método de modificación
    public function setPorcentajeDeDescuento($porcentajeDeDescuento){
        $this->porcentajeDeDescuento = $porcentajeDeDescuento;
    }

    // Métodos toString
    public function __toString(){
        //string $cadena
        $cadena = parent::__toString();
        $cadena = $cadena. "Porcentaje de descuento: ".$this->getPorcentajeDeDescuento()."\n";

        return $cadena;
    }

    // Métodos propios
    public function calcularImporte(){
    }
}