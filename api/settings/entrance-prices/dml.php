<?php
session_start();

require ('../../../models/Entrance_prices.php');

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    echo json_encode(['code' => 4, 'message' => 'You are not authorized to access this page']);
    return;
}

$entrancePrices = new Entrance_prices();

$id = isset($_POST['id']) ? $_POST['id'] : ''; 
$actionType = isset($_POST['action_type']) ? $_POST['action_type']: ''; 
$eventId = isset($_POST['event_id']) ? $_POST['event_id']: '';
$male = isset($_POST['male']) ? $_POST['male'] : '0.00';
$female = isset($_POST['female']) ? $_POST['female'] : '0.00';
$kids = isset($_POST['kids']) ? $_POST['kids'] : '0.00';
$tableCharge = isset($_POST['table_charge']) ? $_POST['table_charge'] : '0.00';
$status = isset($_POST['status']) ? 'Y': 'N';
$userId = $_SESSION['SESS_ID'];
$dateTime = date('Y-m-d H:i:s');
if($actionType != 'delete') {
    $data = [
        'event_id' => $eventId,
        'male' => str_replace(',', '', $male),
        'female' => str_replace(',', '', $female),
        'kids' => str_replace(',', '', $kids),
        'table_charge' => str_replace(',', '', $tableCharge),
        'status' => $status,
        'updated_by' => $userId,
        'updated_at' => $dateTime
    ];

    if($actionType == 'add') {
        $data = array_merge($data, ['created_at' => $dateTime, 'created_by' => $userId]);
    }

} else {
    $data = [
        'status' => 'D',        
        'updated_by' => $userId,
        'updated_at' => $dateTime
    ];
}

if($actionType == 'add') {
    $where = "WHERE event_id = '$eventId' ";
    $check = $entrancePrices->getWhere($where);

    if(!empty($check)) {
        echo json_encode(['code' => 2, 'message' => "Event entrance prices already exist in our database."]);
        return;
    }
}

//Add data
if($actionType == 'add') {
    $resAction = $entrancePrices->insertData($data);
} else if($actionType == 'update') {
    $where = " id = $id";
    $resAction = $entrancePrices->updateData($data, $where);
} else if($actionType == 'delete') {
    $where = " id = $id";
    $resAction = $entrancePrices->updateData($data, $where);
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