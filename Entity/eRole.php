<?php
    namespace entity;

    class eRole {
        public $id;
        public $name;
        public $description;

        public $Found;

        public function __construct() {
            $this->Found = false;
        }
    }
?>