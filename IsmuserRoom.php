<?php

class IsmuserRoom {

    public $roomID;

    function __construct($roomID) {
        $this->roomID = $roomID . '';
    }

    public function __toString(){
      return $this->roomID;
    }

    public function getRoomID() {
        return $this->roomID;
    }
}