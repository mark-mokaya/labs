<?php
    include_once 'user.php';
    $first_name = null;
    $last_name = null;
    $city = null;
    $username = null;
    $password = null;
    $instance = $instance = new User($first_name, $last_name, $city, $username, $password);
    $instance->logout();