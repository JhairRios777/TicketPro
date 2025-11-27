<?php
    namespace Controllers;
    use Models\Ticket as Ticket;
    use Entity\eTicket as eTicket;

    class TicketController{
        private $ticketModel;
        
        public function __construct() {
            $this->ticketModel = new Ticket();
        }
        public function index() {
            return $this->ticketModel->toList();  
        }

        public function Registry($id) {
            $success = true;
            if(isset($_POST) && isset($_POST['Registrar'])){
                $ticket = new eTicket();

                foreach($_POST as $key => $value) {
                    $ticket->$key = $value;
                }

                $this->ticketModel->save($ticket);
                // Log audit: ticket created/updated
                try {
                    $userId = isset($_SESSION["system"]["user_id"]) ? $_SESSION["system"]["user_id"] : null;
                    $action = (isset($ticket->id) && $ticket->id !== '') ? 'ticket_update' : 'ticket_create';
                    $details = 'Ticket ID: ' . (isset($ticket->id) ? $ticket->id : '');
                    $audit = new \Models\Audit();
                    $audit->log($userId, isset($ticket->service_id) ? $ticket->service_id : null, isset($ticket->id) ? $ticket->id : null, $action, $details);
                } catch (\Exception $e) {
                    // ignore audit failures
                }

                return $ticket;
            }

            $data = $this->ticketModel->getForId($id); 
            
            if(!$data) {
                $data = new eTicket();
                $data->id = $this->ticketModel->getNewId();
            }

            return $data;
        }
    }
?>