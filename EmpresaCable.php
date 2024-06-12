<?php

class EmpresaCable{
    // atributos
    private $colPlanes;
    private $colContratos;

    // Constructor
    public function __construct($colPlanes, $colContratos){
        $this->colPlanes = $colPlanes;
        $this->colContratos = $colContratos;
    }

    // Métodos de acceso
    public function getColPlanes(){
        return $this->colPlanes;
    }
    public function getColContratos(){
        return $this->colContratos;
    }

    // Métodos de modificación
    public function setColPlanes($colPlanes){
        $this->colPlanes = $colPlanes;
    }
    public function setColContratos($colContratos){
        $this->colContratos = $colContratos;
    }

    // Métodos toString
    public function __toString(){
        //string $cadena
        $cadena = "Colección de planes: \n\n";
        $cadena .= $this->mostrarArray($this->colPlanes)."\n\n";
        $cadena.= "Colección de contratos: \n\n";
        $cadena.= $this->mostrarArray($this->colContratos)."\n\n";

        return $cadena;
    }

    private function mostrarArray($coleccion){
        $cadena = "";
        foreach ($coleccion as $unElementoCol) {
            $cadena = $cadena. " ". $unElementoCol. "\n";
        }
        return $cadena;
    }


    // Métodos de la clase

    public function incorporarPlan($objPlan){
        $estaElPlanRepetido = false;
        $contador = 0;
        $planes = $this->colPlanes;
        $cantPlanes = count($planes);

        $estaElPlanRepetido = true;

        while(!($estaElPlanRepetido) && $contador < $cantPlanes){
            if ($planes[$contador]->getColCanales() == $objPlan->getColCanales()){
                if($planes[$contador]->getIncluyeMG() == $objPlan->getIncluyeMG()){
                    $estaElPlanRepetido = true;
                }
            }else{
                $contador++;
            }
        }

        if(!$estaElPlanRepetido){
            array_push($planes, $objPlan);
            $this->setColPlanes($planes);
        }
    }

    public function incorporarContrato($fechaInicio, $fechaVencimiento, $objPlan,$costo,$seRennueva,$objCliente, $esViaWeb){
        $coleccionDeContratos = $this->colContratos;

        if($esViaWeb){
            $objContrato = new ContratoViaWeb ($fechaInicio, $fechaVencimiento, $objPlan,$costo,$seRennueva,$objCliente);
            array_push($coleccionDeContratos, $objContrato);
            $this->setColContratos($coleccionDeContratos);
        }else{
            $objContrato = new Contrato ($fechaInicio, $fechaVencimiento, $objPlan,$costo,$seRennueva,$objCliente);
            array_push($coleccionDeContratos, $objContrato);
            $this->setColContratos($coleccionDeContratos);
        }
    }

    public function retornarImporteContratos($codigoPlan){
        $sumaDeImportes = 0;

        $planes = $this->getColPlanes();

        foreach($planes as $plan){
            if($plan->getCodigo() == $codigoPlan){
                $sumaDeImportes += $plan->getImporte();
            }
        }

        return $sumaDeImportes;
    }

    public function pagarContrato($objContrato){
        
        $objContrato->actualizarEstadoContrato();
        $importeFinalAbonado = $objContrato->calcularImporte();

        return $importeFinalAbonado;
    }
}