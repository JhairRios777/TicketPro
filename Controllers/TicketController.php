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

                if(empty($ticket->ticket_code)) {
                    echo '<div class="alert alert-danger" role="alert">El código del ticket es obligatorio</div>';
                    $success = false;
                }

                $this->ticketModel->save($ticket);
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