<?php
class Coche extends Vehiculo {
    private $numeroPuertas;
    private $tipoCombustible;

    public function __construct($id, $marca, $modelo, $matricula, $precioDia, $numeroPuertas, $tipoCombustible) {
        parent::__construct($id, $marca, $modelo, $matricula, $precioDia);
        $this->numeroPuertas = $numeroPuertas;
        $this->tipoCombustible = $tipoCombustible;
    }

    public function getNumeroPuertas() {
        return $this->numeroPuertas;
    }

    public function setNumeroPuertas($numeroPuertas) {
        $this->numeroPuertas = $numeroPuertas;
    }

    public function getTipoCombustible() {
        return $this->tipoCombustible;
    }

    public function setTipoCombustible($tipoCombustible) {
        $this->tipoCombustible = $tipoCombustible;
    }

    public function calcularAlquiler($dias) {
        $precioBase = parent::calcularAlquiler($dias);
        if ($this->tipoCombustible == "Eléctrico") {
            $precioBase -= $precioBase * 0.05; // Descuento por ser eléctrico
        }
        return $precioBase;
    }
}