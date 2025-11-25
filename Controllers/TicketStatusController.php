<?php
    namespace Controllers;
    use Models\TicketStatus as TicketStatus;
    use Entity\eTicketStatus as eTicketStatus;

    class TicketStatusController{
        private $ticketStatusModel;
        
        public function __construct() {
            $this->ticketStatusModel = new TicketStatus();
        }
        public function index() {
            $ticketStatuses = $this->ticketStatusModel->toList();
            return $ticketStatuses;
        }

        public function Registry($id) {
            $success = true;
            if(isset($_POST) && isset($_POST['Registrar'])){
                $ticketStatus = new eTicketStatus();

                foreach($_POST as $key => $value) {
                    $ticketStatus->$key = $value;
                }

                if(empty($ticketStatus->name)) {
                    echo '<div class="alert alert-danger" role="alert">El nombre del estado es obligatorio</div>';
                    $success = false;
                }

                $this->ticketStatusModel->save($ticketStatus);
                return $ticketStatus;
            }

            $data = $this->ticketStatusModel->getForId($id); 
            
            if(!$data) {
                $data = new eTicketStatus();
                $data->id = $this->ticketStatusModel->getNewId();
            }

            return $data;
        }
    }
?>