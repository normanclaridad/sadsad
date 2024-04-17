<?php
session_start();

require ('../../../models/Products.php');

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    echo json_encode(['code' => 4, 'message' => 'You are not authorized to access this page']);
    return;
}

$products = new Products();

$id = isset($_POST['id']) ? $_POST['id'] : ''; 
$actionType = isset($_POST['action_type']) ? $_POST['action_type']: ''; 
$name = isset($_POST['name']) ? $_POST['name']: '';
$description = isset($_POST['description']) ? $_POST['description']: '';
$status = isset($_POST['status']) ? 'Y': 'N';
$userId = $_SESSION['SESS_ID'];
$dateTime = date('Y-m-d H:i:s');
if($actionType != 'delete') {
    $data = [
        'name' => $name,
        'description' => $description,
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
    $checkProducts = $products->getWhere($where);

    if(!empty($checkProducts)) {
        echo json_encode(['code' => 2, 'message' => "name. $name already exist in our database."]);
        return;
    }
}

//Add data
if($actionType == 'add') {
    $resAction = $products->insertData($data);
} else if($actionType == 'update') {
    $where = " id = $id";
    $resAction = $products->updateData($data, $where);
} else if($actionType == 'delete') {
    $where = " id = $id";
    $resAction = $products->updateData($data, $where);
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