<?php
/*
 
Adquirir un plan implica un contrato. Los contratos tienen la fecha de inicio, la fecha de vencimiento, el plan, un estado (al día, moroso, suspendido), un costo, si se renueva o no y una referencia al cliente que adquirió el contrato.
*/
class Contrato{
    
    //ATRIBUTOS
    private $fechaInicio;   
    private $fechaVencimiento;
    private $objPlan;
    private $estado;  //al día, moroso, suspendido
    private $costo;
    private $seRennueva;
    private $objCliente;

 //CONSTRUCTOR
    public function __construct($fechaInicio, $fechaVencimiento, $objPlan,$costo,$seRennueva,$objCliente){
    
       $this->fechaInicio = $fechaInicio;
       $this->fechaVencimiento = $fechaVencimiento;
       $this->objPlan = $objPlan;
       $this->estado = 'AL DIA';
       $this->costo = $costo;
       $this->seRennueva = $seRennueva;
       $this->objCliente = $objCliente;
           

    }


         public function getFechaInicio(){
        return $this->fechaInicio;
    }

    public function setFechaInicio($fechaInicio){
         $this->fechaInicio= $fechaInicio;
    }

        public function getFechaVencimiento(){
        return $this->fechaVencimiento;
    }

    public function setFechaVencimiento($fechaVencimiento){
         $this->fechaVencimiento= $fechaVencimiento;
    }


            public function getObjPlan(){
        return $this->objPlan;
    }

    public function setObjPlan($objPlan){
         $this->objPlan= $objPlan;
    }

   public function getEstado(){
        return $this->estado;
    }

    public function setEstado($estado){
         $this->estado= $estado;
    }

 public function getCosto(){
        return $this->costo;
    }

    public function setCosto($costo){
         $this->costo= $costo;
    }

public function getSeRennueva(){
        return $this->seRennueva;
    }

    public function setSeRennueva($seRennueva){
         $this->seRennueva= $seRennueva;
    }


public function getObjCliente(){
        return $this->objCliente;
    }

    public function setObjCliente($objCliente){
         $this->objCliente= $objCliente;
    }

public function __toString(){
        //string $cadena
        $cadena = "Fecha inicio: ".$this->getFechaInicio()."\n";
        $cadena = "Fecha Vencimiento: ".$this->getFechaVencimiento()."\n";
        $cadena = $cadena. "Plan: ".$this->getObjPlan()."\n";
        $cadena = $cadena. "Estado: ".$this->getEstado()."\n";
        $cadena = $cadena. "Costo: ".$this->getCosto()."\n";
        $cadena = $cadena. "Se renueva: ".$this->getSeRennueva()."\n";
        $cadena = $cadena. "Cliente: ".$this->getObjCliente()."\n";

 
        return $cadena;
         }

         // Métodos propios
         public function diasContratoVencido(){
          $diasVencidos = 0;
          
          $fechaActual = new DateTime();
          $fechaVencimiento = new DateTime($this->getFechaVencimiento());

          if($fechaActual > $fechaVencimiento){
               $diasVencidos = $fechaActual->diff($fechaVencimiento);
          }

          return $diasVencidos;
         }

         public function actualizarEstadoContrato(){
          // El enunciado no espedifica que condición debe cumplirse para ser considerado suspendido

          $fechaActual = new DateTime();
          $diasVencidos = $this->diasContratoVencido();
               if($diasVencidos <= $fechaActual){
                    $this->setEstado("Al día");
               }elseif($diasVencidos > $fechaActual){
                    $this->setEstado("Moroso");
               } elseif(($diasVencidos->days > 10 && $diasVencidos->invert == 0)){
                    $this->setEstado("Suspendido");
               }
         }

         public function calcularImporte(){
          $fechaActual = new DateTime();
          $diasVencidos = $this->diasContratoVencido();
          
          $estaAlDia = false;
          $estaEnMora = false;
          $estaSuspendido = false;

          if($diasVencidos <= $fechaActual){
               $estaAlDia = true;
          }
          if($diasVencidos > $fechaActual){
               $estaEnMora = true;
          }
          if(($diasVencidos->days > 10 && $diasVencidos->invert == 0)){
               $estaSuspendido = true;
          }
          
          if($estaAlDia){
               $importeFinal = $this->getObjPlan()->getImporte();
               $this->setEstado("Al día");
               $this->setSeRennueva(true);
          }elseif($estaEnMora){
               $importePactado = $this->getObjPlan()->getImporte();
               $cantDiasMora = $this->diasContratoVencido();
               $importeMulta = (($importePactado)+ $importePactado/10)*$cantDiasMora;

               $importeFinal = $this->getObjPlan()->getImporte() + $importeMulta;
               $this->setEstado("Moroso");
               $this->setSeRennueva(true);
          } elseif($estaSuspendido){
               $importePactado = $this->getObjPlan()->getImporte();
               $cantDiasMora = $this->diasContratoVencido();
               $importeMulta = (($importePactado)+ $importePactado/10)*$cantDiasMora;

               $importeFinal = $this->getObjPlan()->getImporte() + $importeMulta;
               $this->setEstado("Moroso");
               $this->setSeRennueva(false);
          }
          return $importeFinal;
         }

     }    