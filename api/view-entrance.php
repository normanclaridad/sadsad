<?php
require ('../models/Entrances.php');
require ('../models/Entrance_details.php');
require ('../inc/Helpers.php');

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    echo json_encode(['code' => 4, 'message' => 'You are not authorized to access this page']);
    return;
}

$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

$entrances = new Entrances();
$entranceDetails = new Entrance_details();

//Helpers
$helpers = new Helpers();

$id = isset($_POST['id']) ? $_POST['id']: '';;

if(empty($id)) {
    echo json_encode(['code' => 5, 'message' => 'You are not authorized to access this page']);
    return;
}

if(!is_numeric($id)) {
    echo json_encode(['code' => 5, 'message' => 'You are not authorized to access this page']);
    return;
}

$resEntrances = $entrances->getWhere("WHERE id=$id");

$resEntranceDetails = $entranceDetails->getWhere("WHERE entrance_id=". $id);

$entranceDetailsArr = [];
foreach($resEntranceDetails as $row) {
    $total = $row['qty'] * $row['price'];
    $entranceDetailsArr[] = [
        'name' => ucfirst($row['name']),
        'qty' => $row['qty'],
        'price' => number_format($row['price'],2),
        'total' => number_format($total,2)
    ];
}

$data = [
    'transaction_no' => $resEntrances[0]['transaction_no'],
    'name' => ucfirst($resEntrances[0]['name']),
    'total_amount' => number_format($resEntrances[0]['total'],2),
    'amount_paid' => number_format($resEntrances[0]['cash'],2),
    'amount_change' => number_format($resEntrances[0]['amount_change'],2),
    'status' => $resEntrances[0]['status'],
    'created_at' => date("M-d, Y h:i:s a", strtotime($resEntrances[0]['created_at'])),
    'entrance_details' => $entranceDetailsArr
];


echo json_encode($data);
return;