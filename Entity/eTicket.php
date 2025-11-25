<?php
    namespace entity;

    class eTicket {
        public $id;
        public $ticket_code;
        public $service_id;
        public $client_type_id;
        public $status_id;
        public $user_id;
        public $date_time;

        public $Found;

        public function __construct() {
            $this->Found = false;
        }
    }
?>