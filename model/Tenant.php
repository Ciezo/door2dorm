<?php 

    class Tenant {
        public $full_name; 
        public $contact_no; 
        public $emerg_contact_no; 
        public $email;
        public $username;
        public $password;
        public $room;

        function __construct($full_name, $contact_no, $emerg_contact_no, $email, $username , $password, $room) {
            $this->full_name = $full_name;
            $this->contact_no = $contact_no;
            $this->emerg_contact_no = $emerg_contact_no;
            $this->email = $email;
            $this->username = $username;
            $this->password = $password;
            $this->room = $room;
        }

        function getFullName() {
            return $this->full_name;
        }

        function getContactNum() {
            return $this->contact_no; 
        }

        function getEmergencyContactNum() {
            return $this->emerg_contact_no;
        }

        function getEmail() {
            return $this->email;
        }

        function getUserName() {
            return $this->username;
        }

        function getPassword() {
            return $this->password;
        }

        function getAssignedRoom() {
            return $this->room;
        }
    }
?>