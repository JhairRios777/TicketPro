<?php
    namespace entity;

    class eTicketHistory {
        public $id;
        public $ticket_id;
        public $status_id;
        public $user_id;
        public $date_time;
        public $observation;

        public $Found;

        public function __construct() {
            $this->Found = false;
        }
    }
?>