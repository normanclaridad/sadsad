<?php
session_start();

require ('../../../models/Events.php');

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    echo json_encode(['code' => 4, 'message' => 'You are not authorized to access this page']);
    return;
}

$events = new Events();

$id = isset($_POST['id']) ? $_POST['id'] : ''; 
$actionType = isset($_POST['action_type']) ? $_POST['action_type']: ''; 
$name = isset($_POST['name']) ? $_POST['name']: '';
$dateStarted = isset($_POST['date_started']) ? date('Y-m-d', strtotime($_POST['date_started'])) : '';
$timeStarted = isset($_POST['time_started']) ? date('H:i:s', strtotime($_POST['time_started'])) : '';
$dateFinish = isset($_POST['date_finish']) ? date('Y-m-d', strtotime($_POST['date_finish'])) : '';
$timeFinish = isset($_POST['time_finish']) ? date('H:i:s', strtotime($_POST['time_finish'])) : '';
$status = isset($_POST['status']) ? 'Y': 'N';
$userId = $_SESSION['SESS_ID'];
$dateTime = date('Y-m-d H:i:s');
if($actionType != 'delete') {
    $data = [
        'name' => $name,
        'start' => $dateStarted . ' ' . $timeStarted,
        'end' => $dateFinish . ' ' . $timeFinish,
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
    $where = "WHERE name = '$name' ";
    $check = $events->getWhere($where);

    if(!empty($check)) {
        echo json_encode(['code' => 2, 'message' => "name. $name already exist in our database."]);
        return;
    }
}

//Add data
if($actionType == 'add') {
    $resAction = $events->insertData($data);
} else if($actionType == 'update') {
    $where = " id = $id";
    $resAction = $events->updateData($data, $where);
} else if($actionType == 'delete') {
    $where = " id = $id";
    $resAction = $events->updateData($data, $where);
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