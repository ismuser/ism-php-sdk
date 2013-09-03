<?php

class IsmuserRoom {

    private $roomID;
    private $roomProperties;

    function __construct($roomID, $properties=array()) {
        $this->roomID = $roomID . '';
        $this->roomProperties = $properties;
    }

    public function __toString(){
      return $this->roomID;
    }

    public function getRoomID() {
        return $this->roomID;
    }

    public function getPermissions() {        
        return array(
            "videoconference_mod" => $this->roomProperties["videoconference_mod"],
            "magicboard_mod" => $this->roomProperties["magicboard_mod"],
            "chat_mod" => $this->roomProperties["chat_mod"],
        );
    }

    public function isDebug() {
        return $this->roomProperties["debug"];
    }
}