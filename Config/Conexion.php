<?php
namespace config;

//$conn = new Conexion("TicketPro");

class Conexion {
    private $host="localhost";
    private $db_name="TicketPro";
    private $user="root";
    private $password="";
    private $conn=null;

    public function __construct() {

        try {
            $this->conn = new \PDO("mysql:host=".$this->host.";dbname=".$this->db_name, $this->user, $this->password);

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