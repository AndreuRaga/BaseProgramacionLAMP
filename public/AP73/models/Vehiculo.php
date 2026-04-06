<?php
class Vehiculo {
    protected $id;
    protected $marca;
    protected $modelo;
    protected $matricula;
    protected $precioDia;

    public function __construct($id = 0, $marca, $modelo, $matricula, $precioDia) {
        $this->id = $id;
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->matricula = $matricula;
        $this->precioDia = $precioDia;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getMarca() {
        return $this->marca;
    }

    public function setMarca($marca) {
        $this->marca = $marca;
    }

    public function getModelo() {
        return $this->modelo;
    }

    public function setModelo($modelo) {
        $this->modelo = $modelo;
    }

    public function getMatricula() {
        return $this->matricula;
    }

    public function setMatricula($matricula) {
        $this->matricula = $matricula;
    }

    public function getPrecioDia() {
        return $this->precioDia;
    }

    public function setPrecioDia($precioDia) {
        $this->precioDia = $precioDia;
    }

    public function calcularAlquiler($dias) {
        return $this->precioDia * $dias;
    }
}