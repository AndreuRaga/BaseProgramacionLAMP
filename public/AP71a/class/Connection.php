<?php
class Connection {
    protected $conn;
    private $configFile = 'conf.json';

    public function __construct() {
        $this->makeConnection();
    }

    private function makeConnection() {
        $configData = file_get_contents($this->configFile); // Transforma el contenido del archivo en un string
        $c = json_decode($configData, true); // Transforma el string en un array asociativo, el segundo parámetro es para eso
        $dsn = "mysql:host=" . $c['host'] . ";dbname=" . $c['db'];
        $this->conn = new PDO($dsn, $c['userName'], $c['password']);
    }

    public function getConn() {
        return $this->conn;
    }

    public function __destruct() {
        $this->conn = null;
    }
}