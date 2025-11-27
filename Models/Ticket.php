<?php
    namespace Models;
    use Config\Conexion as Conexion;

    class Ticket {
        private $Conexion;

        public function __construct() {
            $this->Conexion = new Conexion();
            $this->Conexion = $this->Conexion->getConexion();
        }

        public function toList() {
            $sql = "SELECT * FROM Tickets";
            $stmt = $this->Conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        }

         public function getForId($id){
            $sql = "SELECT * FROM Tickets WHERE id = :id";
            $stmt = $this->Conexion->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_OBJ);
        }

        public function getNewId(){
            $sql = "SELECT * FROM Tickets ORDER BY id DESC LIMIT 0,1";
            $stmt = $this->Conexion->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetch(\PDO::FETCH_OBJ);

            if(!$data){
                return "1";
            } else {
                return intval($data->id) + 1;
            }
        }
        public function save($entity){
            // Try calling stored procedure first (if it exists), otherwise fallback to direct INSERT
            try {
                $sql = "call SP_Ticket (";
                $sql .= "'".$entity->id."', ";
                $sql .= "'".$entity->ticket_code."', ";
                $sql .= "'".$entity->service_id."', ";
                $sql .= "'".$entity->client_type_id."', ";
                $sql .= "'".$entity->status_id."', ";
                $sql .= "'".$entity->user_id."', ";
                $sql .= "'".$entity->date_time."'";
                $sql .= ");";

                $stmt = $this->Conexion->prepare($sql);
                $stmt->execute();
                return;
            } catch (\Exception $e) {
                // fallback to INSERT
            }

            // Fallback: direct INSERT (use id provided by caller)
            $sql = "INSERT INTO Tickets (id, ticket_code, service_id, client_type_id, status_id, user_id, date_time) ";
            $sql .= "VALUES (:id, :ticket_code, :service_id, :client_type_id, :status_id, :user_id, :date_time)";

            $stmt = $this->Conexion->prepare($sql);
            $stmt->bindValue(':id', isset($entity->id) && $entity->id !== '' ? $entity->id : null);
            $stmt->bindValue(':ticket_code', isset($entity->ticket_code) ? $entity->ticket_code : '');
            $stmt->bindValue(':service_id', isset($entity->service_id) ? $entity->service_id : null);
            $stmt->bindValue(':client_type_id', isset($entity->client_type_id) ? $entity->client_type_id : null);
            $stmt->bindValue(':status_id', isset($entity->status_id) ? $entity->status_id : null);
            $stmt->bindValue(':user_id', isset($entity->user_id) ? $entity->user_id : null);
            $stmt->bindValue(':date_time', isset($entity->date_time) && trim($entity->date_time) !== '' ? $entity->date_time : date('Y-m-d H:i:s'));

            $stmt->execute();
            // set id back to entity in case caller needs it
            if (empty($entity->id) || $entity->id === '0' || $entity->id === null) {
                $entity->id = $this->Conexion->lastInsertId();
            }
        }
    }
?>