<?php
    namespace Controllers;
    use Models\TicketHistory as TicketHistory;

    class TicketHistoryController {
        private $ticketHistoryModel;
        
        public function __construct() {
            $this->ticketHistoryModel = new TicketHistory();
        }
        
        public function index() {
            $ticketHistories = $this->ticketHistoryModel->toList();
            return $ticketHistories;  
        }
    }
?>