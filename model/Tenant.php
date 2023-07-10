<?php 

    class Tenant {
        public $full_name; 
        public $contact_no; 
        public $emerg_contact_no; 
        public $email;
        public $username;
        public $password;
        public $room;
        public $lease_start;
        public $lease_end;

        function __construct($full_name, $contact_no, $emerg_contact_no, $email, $username , $password, $room, $lease_start, $lease_end) {
            $this->full_name = $full_name;
            $this->contact_no = $contact_no;
            $this->emerg_contact_no = $emerg_contact_no;
            $this->email = $email;
            $this->username = $username;
            $this->password = $password;
            $this->room = $room;
            $this->lease_start = $lease_start;
            $this->lease_end = $lease_end;
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
        
        function getLeaseStart() {
            return $this->lease_start;
        }

        function getLeaseEnd() {
            return $this->lease_end;
        }
    }
?>