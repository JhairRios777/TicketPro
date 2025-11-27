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

                $this->ticketStatusModel->save($ticketStatus);
                // Log audit: ticket status created/updated
                try {
                    $userId = isset($_SESSION["system"]["user_id"]) ? $_SESSION["system"]["user_id"] : null;
                    $action = (isset($ticketStatus->id) && $ticketStatus->id !== '') ? 'ticket_status_update' : 'ticket_status_create';
                    $details = 'TicketStatus ID: ' . (isset($ticketStatus->id) ? $ticketStatus->id : '');
                    $audit = new \Models\Audit();
                    $audit->log($userId, null, null, $action, $details);
                } catch (\Exception $e) {
                    // ignore audit failures
                }

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