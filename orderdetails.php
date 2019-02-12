<?php 

$submit = !empty($_POST);

if ($submit) {
    if (!empty($_POST['secretInput'])) {
        $orderNumber = $_POST['secretInput'];
    } else {
        $orderNumber = $_POST['search'];
    }
}

// !!!!!!!!!!!!!!!!
//$orderNumber = filter_input(INPUT_GET, 'numero', FILTER_VALIDATE_INT);
//if(!$orderNumber){
//     header("Location: index.php");
//     exit;
//}

// if(!$query->rowCount()){
//     header();
//     exit;
// }


// if (!array_key_exists('secretInput', $_POST) || !ctype_digit($_POST['secretInput'])) {
//     sleep(10);
//     header("Location: index.php");
//     exit;
// }

// $filteredVar = filter_input(INPUT_POST, 'search', FILTER_VALIDATE_INT);
// var_dump($filteredVar);

// ctype_digit($orderNumber) -> true 
// is_int($orderNumber) -> false
$orderNumber = intval($orderNumber, 10);
// is_int($orderNumber) -> true

// Connexion DB
$DB = new PDO("mysql:host=localhost;dbname=classicmodels;charset=utf8;", "root", "");

// Query INFOS GENERALES de la commande
$sql = "SELECT o.orderDate, c.customerName, c.contactLastName, c.contactFirstName, e.lastName, e.firstName, ROUND(SUM(od.quantityOrdered * od.priceEach),2) AS totalOfTotals
FROM orders AS o
JOIN customers AS c ON o.customerNumber = c.customerNumber
JOIN employees AS e ON c.salesRepEmployeeNumber = e.employeeNumber
JOIN orderdetails AS od ON o.orderNumber = od.orderNumber
WHERE o.orderNumber = :oNumber
GROUP BY customerName;";
$query = $DB->prepare($sql);
$query->execute(array(':oNumber' => $orderNumber));
$data = $query->fetch(PDO::FETCH_ASSOC);

$test = $query->rowCount();
// var_dump($test);

// Query DETAILS de la commande
$sql = "SELECT productCode, quantityOrdered, priceEach, ROUND((quantityOrdered * priceEach),2) AS total, p.productName
FROM orderdetails AS o
NATURAL JOIN products AS p
WHERE orderNumber = :oNumber;";
$query = $DB->prepare($sql);
$query->execute(array(':oNumber' => $orderNumber));
$details = $query->fetchAll(PDO::FETCH_ASSOC);


// Kill connexion
$query = null;
$DB = null;


$authorizationLevel = 3;
// header("Location: index.php");
// exit();
// die();
// Appel template HTML
require_once("templates/order.phtml");
?>