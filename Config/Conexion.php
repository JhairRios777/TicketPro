<?php
namespace config;

//$conn = new Conexion("TicketPro");

class Conexion {
    private $host="localhost";
    private $db_name="TicketPro";
    private $user="root";
    private $password="";
    private $conn=null;
    private $port="3306";
    private $charset="utf8mb4";

    public function __construct() {

        try {
            $this->conn = new \PDO("mysql:host=".$this->host.";port=".$this->port.";dbname=".$this->db_name.";charset=".$this->charset, $this->user, $this->password);
            
            //echo "Conexión Exitosa...";

        } catch (\Throwable $th) {
            die("Conexión Fallida... ".$th->getMessage());
        }

        
    }

    public function getConexion() {
        return $this->conn;
    }
}

?>