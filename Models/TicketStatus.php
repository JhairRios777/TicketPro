<?php
    namespace Models;

    use Config\Conexion as Conexion;

    class TicketStatus {
        private $Conexion;

        public function __construct() {
            $this->Conexion = new Conexion();
            $this->Conexion = $this->Conexion->getConexion();
        }

        public function toList() {
            $sql = "SELECT * FROM TicketStatuses";
            $stmt = $this->Conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        }

    }
?>