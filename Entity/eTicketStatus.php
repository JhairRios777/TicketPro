<?php
    namespace entity;

    class eTicketStatus {
        public $id;
        public $name;
        public $description;

        public $Found;

        public function __construct() {
            $this->Found = false;
        }
    }
?>