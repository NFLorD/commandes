<?php 

$availableOrders = [
    'orderNumber',
    'totalAmount',
    'orderDate',
    'customerName',
    'lastName',
    'status'
];

$availableDirections = [
    'ASC',
    'DESC'
];

$availableNumbersOfResults = [
    10,
    25,
    50
];

if (!empty($_POST['orderSelector']) && in_array($_POST['orderSelector'], $availableOrders)) {
    $order = $_POST['orderSelector'];
} else {
    $order = "orderNumber";
}

if (!empty($_POST['orderDirection']) && in_array($_POST['orderDirection'], $availableDirections)) {
    $orderDirection = $_POST['orderDirection'];
} else {
    $orderDirection = "ASC";
}

if (!empty($_POST['numberOfResults']) && in_array($_POST['numberOfResults'], $availableNumbersOfResults)) {
    $numberOfResults = $_POST['numberOfResults'];
} else {
    $numberOfResults = 10;
}

if (!empty($_POST['pageInput'])) {
    $page = $_POST['pageInput'];
    $offsetNumber = $numberOfResults * ($page - 1);
} else {
    $offsetNumber = 0;
    $page = 1;
}

// Connexion à la DB
$DB = new PDO("mysql:host=localhost;dbname=classicmodels;charset=utf8;", "root", "");

$sql = "SELECT o.orderNumber, o.orderDate, o.shippedDate, o.status, c.customerName, e.lastName, e.firstName, ROUND(SUM(od.priceEach * od.quantityOrdered),2) AS totalAmount
FROM orders AS o
JOIN customers AS c ON o.customerNumber = c.customerNumber
JOIN employees AS e ON c.salesRepEmployeeNumber = e.employeeNumber
JOIN orderdetails AS od ON o.orderNumber = od.orderNumber
GROUP BY orderNumber
ORDER BY $order";

if ($orderDirection == 'DESC') {
    $sql = $sql . ' DESC';
}

$sql = $sql . " LIMIT " . $numberOfResults;
$sql = $sql . " OFFSET " . $offsetNumber;

$query = $DB->prepare($sql);

$query->execute();

// Récupération des données
$data = $query->fetchAll(PDO::FETCH_ASSOC);

// Fin de la connexion
$query = null;
$DB = null;
// Appel au template HTML
require_once("templates/orders.phtml");
?>