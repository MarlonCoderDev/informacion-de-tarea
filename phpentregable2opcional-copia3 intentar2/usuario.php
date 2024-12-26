<?php
class Usuario {
    private $id;
    private $nombre;
    private $email;
    private $clave;
    
    public function __construct($nombre = "", $email = "", $clave = "") {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->clave = $clave;
    }
    
    // Getters
    public function getId() {
        return $this->id;
    }
    
    public function getNombre() {
        return $this->nombre;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function getClave() {
        return $this->clave;
    }
    
    // Setters
    public function setId($id) {
        $this->id = $id;
    }
    
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    
    public function setEmail($email) {
        $this->email = $email;
    }
    
    public function setClave($clave) {
        $this->clave = $clave;
    }
}