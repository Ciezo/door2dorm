<?php
    class Visitor {
        public $full_name;
        public $purpose;
        public $contact_num;
        public $visiting_Date;
        public $visiting_Time;
        public $valid_ID;

        function __construct($full_name, $purpose, $contact_num, $visiting_Date, $visiting_Time, $valid_ID) {
            $this->full_name = $full_name;
            $this->purpose = $purpose;
            $this->contact_num = $contact_num;
            $this->visiting_Date = $visiting_Date;
            $this->visiting_Time = $visiting_Time;
            $this->valid_ID = $valid_ID;
        }

        function getFullName() {
            return $this->full_name;
        }

        function getVisitPurpose() {
            return $this->purpose; 
        }

        function getContactNum() {
            return $this->contact_num;
        }

        function getVisitingDate() {
            return $this->visiting_Date;
        }

        function getVisitingTime() {
            return $this->visiting_Time;
        }

        function getVisitorValidID() {
            return $this->valid_ID;
        }
        
    }
?>