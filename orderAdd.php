<?php
require "library.php";

if(!empty($_POST)){
    $data = filter_input_array(INPUT_POST);
    if($data["comments"] == ""){
        $data["comments"] = null;
    }
    if($data["shippedDate"] == ""){
        $data["shippedDate"] = null;
    }
    var_dump($data);

    $DB = connect("localhost", "classicmodels", "root", "");
    $sql = "INSERT INTO orders VALUES (':oN', ':oD', ':rD', ':sD', ':s', ':c', ':cN')";
    $query = $DB->prepare($sql);
    $query->execute(array(":oN" => $data["orderNumber"], ":oD" => $data["orderDate"], ":rD" => $data["requiredDate"], ":sD" => $data["shippedDate"], ":s" => $data["status"], ":c" => $data["comments"], ":cN" => $data["customerNumber"]));
   
    $query = null;

    $sql = "INSERT INTO orderdetails VALUES (':oN', ':pC', ':qO', ':pE', ':oLN')";
    for($i = 0; $i < $data['numberOfProducts']; $i++){
        $query = $DB->prepare($sql);
        $query->execute(array(
            ":oN" => $data["orderNumber"], 
            ":pC" => $data["productCode"][$i], 
            ":qO" => $data["quantityOrdered"][$i], 
            ":pE" => $data["priceEach"][$i],
            ":oLN" => $data["orderLineNumber"][$i]
        ));
        $query = null;
    }


    $DB = null;
}

// https://dba.stackexchange.com/questions/46410/how-do-i-insert-a-row-which-contains-a-foreign-key

require_once("templates/add.phtml");
?>