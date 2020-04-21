<?php
    interface Crud{
    // methods to be implemennted by every class 
    public function save();
    public function readAll();
    public function readUnique();
    public function search();
    public function update();
    public function removeOne();
    public function removeAll();
    }
?>