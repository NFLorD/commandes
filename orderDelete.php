<?php
require "library.php";

if(!empty($_POST)){
    $orderNumber = intval(filter_input(INPUT_POST, 'deleter', FILTER_VALIDATE_INT),10);
    
    $DB = connect("localhost", "classicmodels", "root", "");
    $sql = "DELETE FROM `orderdetails` WHERE `orderdetails`.`orderNumber` = $orderNumber;
    DELETE FROM `orders` WHERE `orders`.`orderNumber` = $orderNumber";
    $query = $DB->prepare($sql);
    $query->execute();
    $query = null;
    $DB = null;
}

header('Location: index.php');
exit;
?>