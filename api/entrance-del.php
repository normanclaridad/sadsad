<?php
session_start();

require ('../models/Entrances.php');
require ('../models/Entrance_details.php');
require ('../models/Events.php');

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    echo json_encode(['code' => 4, 'message' => 'You are not authorized to access this page']);
    return;
}

$entrances = new Entrances();
$entranceDetails = new Entrance_details();
$events = new Events();


$id = isset($_POST['id']) ? $_POST['id'] : '';
$actionType = isset($_POST['action_type']) ? $_POST['action_type'] : '';
$remarks = isset($_POST['remarks']) ? $_POST['remarks'] : '';
$userId = $_SESSION['SESS_ID'];

$id = isset($_POST['id']) ? $_POST['id'] : ''; 
$dateTime = date('Y-m-d H:i:s');

$data = [
    'remarks' => $remarks,
    'status' => 'D',        
    'updated_by' => $userId,
    'updated_at' => $dateTime
];

$trxnId = 0;

$where = " id = $id";
$resAction = $entrances->updateData($data, $where);

if(!$resAction) {
    echo json_encode(['code' => 1, 'message' => 'Internal error. Please contact administrator.']);
    return;
}

$actionMessage = 'added';
if($actionType == 'update') {
    $actionMessage = 'updated';
} else if($actionType == 'delete') {
    $actionMessage = 'deleted';
}

echo json_encode(['code' => 0, 'message' => 'Record has been successully ' . $actionMessage]);
return;