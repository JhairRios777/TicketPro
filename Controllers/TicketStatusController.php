<?php
    namespace Controllers;
    use Models\TicketStatus as TicketStatus;

    class TicketStatusController{
        private $ticketStatusModel;
        
        public function __construct() {
            $this->ticketStatusModel = new TicketStatus();
        }
        public function index() {
            return $this->ticketStatusModel->toList();  
        }
    }
?>