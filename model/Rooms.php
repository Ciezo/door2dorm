<?php
    class Rooms {
        public $room_num;
        public $room_type;
        public $room_category;
        public $gender_assigned;
        public $room_details;
        public $pricing;
        public $number_of_occupants;
        public $occupancy_status; 
        
        function __construct($room_num, $room_type, $room_category, $gender_assigned, $room_details, $pricing, $number_of_occupants, $occupancy_status) {
            $this->room_num = $room_num;
            $this->room_type = $room_type;
            $this->room_category = $room_category;
            $this->gender_assigned = $gender_assigned;
            $this->room_details = $room_details;
            $this->pricing = $pricing;
            $this->number_of_occupants = $number_of_occupants;
            $this->occupancy_status = $occupancy_status;
        }

        function getRoomNum() {
            return $this->room_num;
        }

        function getRoomType() {
            return $this->room_type; 
        }

        function getRoomCategory() {
            return $this->room_category;
        }

        function getGenderAssigned() {
            return $this->gender_assigned;
        }

        function getRoomDetails() {
            return $this->room_details;
        }

        function getRoomPricing() {
            return $this->pricing;
        }

        function getNumOfOccupants() {
            return $this->number_of_occupants;
        }

        function getOccupancyStatus() {
            return $this->occupancy_status;
        }
 
    }
?>