<?php
    namespace Controllers;
    use Models\Ticket as Ticket;

    class TicketController{
        private $ticketModel;
        
        public function __construct() {
            $this->ticketModel = new Ticket();
        }
        public function index() {
            return $this->ticketModel->toList();  
        }
    }
?>