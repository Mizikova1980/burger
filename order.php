<?php
include 'config.php';
include 'class.burger.php';
include 'class.db.php';

ini_set('display_errors', 'on');
ini_set('error_reporting', E_NOTICE | E_ALL);


$burger = new Burger();

$email = $_POST['email'];
$name = $_POST['name'];

$addressFields = ['phone', 'street', 'home', 'part', 'appt', 'floor'];
$address = '';
foreach ($_POST as $field => $value) {
    if ($value && in_array($field, $addressFields)) {
        $address .= $value . ',';
    }
}
$data = ['address' => $address];


$user = $burger->getUserByEmail($email);

if($user) {
    $userId = $user['id'];
    $burger->incOrders($user['id']);
    $number = $burger->orderNumber($userId);
    $orderNumber = $number['COUNT(*)'];
    
} else {
    $userId = $burger->createUser($email, $name);
    $orderNumber = 1;
}


$orderId = $burger->addOrder($userId, $data);

echo "Спасибо, ваш заказ будет доставлен по адресу: $address<br>
Номер вашего заказа: #$orderId <br>
Это ваш $orderNumber-й заказ!"; 


?>