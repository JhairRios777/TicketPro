<?php
    namespace Models;
    use Config\Conexion as Conexion;

    class Audit {
        private $Conexion;

        public function __construct() {
            $this->Conexion = new Conexion();
            $this->Conexion = $this->Conexion->getConexion();
        }

        public function toList() {
            $sql = "SELECT * FROM Audits";
            $stmt = $this->Conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        }

        public function getForId($id){
            $sql = "SELECT * FROM Audits WHERE id = :id";
            $stmt = $this->Conexion->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_OBJ);
        }

        public function getNewId(){
            $sql = "SELECT * FROM Audits ORDER BY id DESC LIMIT 0,1";
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
                $sql = "call SP_Audit (";
                $sql .= "'".addslashes($entity->id)."', ";
                $sql .= "'".addslashes($entity->user_id)."', ";
                $sql .= "'".addslashes($entity->desk_id)."', ";
                $sql .= "'".addslashes($entity->ticket_id)."', ";
                $sql .= "'".addslashes($entity->action)."', ";
                $sql .= "'".addslashes($entity->details)."', ";
                $sql .= "'".addslashes($entity->date_time)."'";
                $sql .= ");";

                $stmt = $this->Conexion->prepare($sql);
                $stmt->execute();
                return;
            } catch (\Exception $e) {
                // fallback to INSERT
            }

            // Prepare fields for insert; allow date_time to be empty (use NOW())
            $sql = "INSERT INTO Audits (user_id, desk_id, ticket_id, `action`, details, date_time) ";
            $sql .= "VALUES (:user_id, :desk_id, :ticket_id, :action, :details, ";
            if (isset($entity->date_time) && trim($entity->date_time) !== '') {
                $sql .= ":date_time";
            } else {
                $sql .= "NOW()";
            }
            $sql .= ")";

            $stmt = $this->Conexion->prepare($sql);
            $stmt->bindValue(':user_id', isset($entity->user_id) && $entity->user_id !== '' ? $entity->user_id : null);
            $stmt->bindValue(':desk_id', isset($entity->desk_id) && $entity->desk_id !== '' ? $entity->desk_id : null);
            $stmt->bindValue(':ticket_id', isset($entity->ticket_id) && $entity->ticket_id !== '' ? $entity->ticket_id : null);
            $stmt->bindValue(':action', isset($entity->action) ? $entity->action : '');
            $stmt->bindValue(':details', isset($entity->details) ? $entity->details : '');
            if (isset($entity->date_time) && trim($entity->date_time) !== '') {
                $stmt->bindValue(':date_time', $entity->date_time);
            }

            $stmt->execute();
        }

        // Convenience helper to create a quick audit record
        public function log($user_id = null, $desk_id = null, $ticket_id = null, $action = '', $details = '', $date_time = '') {
            $entity = new \stdClass();
            $entity->id = '';
            $entity->user_id = $user_id;
            $entity->desk_id = $desk_id;
            $entity->ticket_id = $ticket_id;
            $entity->action = $action;
            $entity->details = $details;
            $entity->date_time = $date_time;
            $this->save($entity);
        }
    }
?>