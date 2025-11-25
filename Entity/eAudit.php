<?php
    namespace entity;

    class eAudit {
        public $id;
        public $user_id;
        public $desk_id;
        public $ticket_id;
        public $action;

        public $Found;

        public function __construct() {
            $this->Found = false;
        }
    }
?>