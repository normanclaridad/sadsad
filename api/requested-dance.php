<?php
session_start();
require ('../models/Requested_dances.php');
require ('../models/Events.php');

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    echo json_encode(['code' => 4, 'message' => 'You are not authorized to access this page']);
    return;
}

$requestedDances = new Requested_dances();
$events = new Events();

$resEvents = $events->getWhere("WHERE status = 'Y' AND start <= '". date('Y-m-d H:i:s') ."' AND end >= '". date('Y-m-d H:i:s') ."'");

if(empty($resEvents)) {
    echo json_encode(['code' => 3, 'message' => 'No events set.']);
    return;
}

if(count($resEvents) > 1) {
    echo json_encode(['code' => 5, 'message' => 'Events currently active are more than One(1).']);
    return;
}

$eventId = $resEvents[0]['id'];

$id = isset($_POST['id']) ? $_POST['id'] : '';
$actionType = isset($_POST['action_type']) ? $_POST['action_type']: '';
$danceCategoryId = isset($_POST['dance_category_id']) ? $_POST['dance_category_id']: '';
$name = isset($_POST['name']) ? $_POST['name']: '';
$amount = isset($_POST['amount']) ? str_replace(',', '', $_POST['amount']) : '0.00';
$remarks = isset($_POST['remarks']) ? $_POST['remarks'] : '';

$userId = $_SESSION['SESS_ID'];
$dateTime = date('Y-m-d H:i:s');


if($actionType != 'delete') {
    $data = [
        'name' => $name,
        'dance_category_id' => $danceCategoryId,
        'event_id' => $eventId,
        'amount' => str_replace(',', '', $amount),
        'updated_by' => $userId,
        'updated_at' => $dateTime
    ];

    if($actionType == 'add') {
        $data = array_merge($data, ['created_at' => $dateTime, 'created_by' => $userId]);
    }

} else {
    $data = [
        'status' => 'D',
        'remarks' => $remarks,
        'updated_by' => $userId,
        'updated_at' => $dateTime
    ];
}
// print_r($data);
// return;
// Add data
$trxnId = 0;
if($actionType == 'add') {
    $resAction = $requestedDances->insertData($data);
    $trxnId = $resAction;
} else if($actionType == 'update') {
    $where = " id = $id";
    $resAction = $requestedDances->updateData($data, $where);
} else if($actionType == 'delete') {
    $where = " id = $id";
    $resAction = $requestedDances->updateData($data, $where);
}

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