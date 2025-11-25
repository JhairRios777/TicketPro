<?php
    namespace entity;

    class eServiceDesk {
        public $id;
        public $user_id;
        public $branch_id;
        public $desk_name;

        public $Found;

        public function __construct() {
            $this->Found = false;
        }
    }
?>