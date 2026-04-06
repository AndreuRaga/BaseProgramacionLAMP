<?php
class Motocicleta extends Vehiculo {
    private $cilindrada;
    private $incluyeCasco;

    public function __construct($id, $marca, $modelo, $matricula, $precioDia, $cilindrada, $incluyeCasco) {
        parent::__construct($id, $marca, $modelo, $matricula, $precioDia);
        $this->cilindrada = $cilindrada;
        $this->incluyeCasco = $incluyeCasco;
    }

    public function getCilindrada() {
        return $this->cilindrada;
    }

    public function setCilindrada($cilindrada) {
        $this->cilindrada = $cilindrada;
    }

    public function getIncluyeCasco() {
        return $this->incluyeCasco;
    }

    public function setIncluyeCasco($incluyeCasco) {
        $this->incluyeCasco = $incluyeCasco;
    }

    public function calcularAlquiler($dias) {
        $precioBase = parent::calcularAlquiler($dias);
        if ($this->incluyeCasco) {
            $precioBase += 10; // Extra por incluir casco
        }
        return $precioBase;
    }
}