<?php

class IpAcesso {
    
    private $id;
    private $ipAcesso;
    private $data;
    
    function getId() {
        return $this->id;
    }

    function getIpAcesso() {
        return $this->ipAcesso;
    }

    function getData() {
        return $this->data;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIpAcesso($ipAcesso) {
        $this->ipAcesso = $ipAcesso;
    }

    function setData($data) {
        $this->data = $data;
    }
    
}

