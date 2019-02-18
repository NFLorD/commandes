<?php
require "library.php";

if(!empty($_POST['id']) && !empty($_POST['password'])){
    $id = filter_input(INPUT_POST, 'id');
    $pass = filter_input(INPUT_POST, 'password');
    $DB = connect("localhost", "classicmodels", "root", "");
    $query = $DB->prepare("SELECT username, `password` FROM users WHERE username = $id AND `password` = $pass");
    $query->execute();
    
    $test = $query->fetchAll(PDO::FETCH_ASSOC);
    var_dump($test);
    if(!empty($test)){
        session_start();
        $_SESSION['id'] = filter_input(INPUT_POST, 'id');
        $_SESSION['password'] = filter_input(INPUT_POST, 'password');
        var_dump($_SESSION['id']);
        var_dump($_SESSION['password']);
    } 
    $query = null;
    $DB = null;
}


?>