<?php
session_start();

require ('../../../models/Stocks.php');
require ('../../../models/Events.php');

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    echo json_encode(['code' => 4, 'message' => 'You are not authorized to access this page']);
    return;
}

$stocks = new Stocks();
$events = new Events();

$resEvents = $events->getWhere("WHERE status = 'Y' AND start <= '". date('Y-m-d H:i:s') ."' AND end >= '". date('Y-m-d H:i:s') ."'");

if(empty($resEvents)) {
    echo json_encode(['code' => 3, 'message' => 'No events set.']);
    return;
}

$eventId = $resEvents[0]['id'];

$id = isset($_POST['id']) ? $_POST['id'] : ''; 
$actionType = isset($_POST['action_type']) ? $_POST['action_type']: ''; 
$supplierId = isset($_POST['supplier_id']) ? $_POST['supplier_id']: '';
$productId = isset($_POST['product_id']) ? $_POST['product_id']: '';
$unitId = isset($_POST['unit_id']) ? $_POST['unit_id']: '';
$quantity = isset($_POST['quantity']) ? $_POST['quantity']: '';
// $originalPrice = isset($_POST['original_price']) ? number_format($_POST['original_price'],2): '';
// $sellingPrice = isset($_POST['selling_price']) ? number_format($_POST['selling_price'],2): '';
$status = isset($_POST['status']) ? 'Y': 'N';
$userId = $_SESSION['SESS_ID'];
$dateTime = date('Y-m-d H:i:s');

// if($actionType != 'delete') {
//     if(empty($originalPrice) || empty($sellingPrice)) {
//         echo json_encode(['code' => 5, 'message' => 'Original price or selling price should more than 0.']);
//         return;
//     }
// }

if($actionType != 'delete') {
    $data = [
        'event_id' => $eventId,
        'supplier_id' => $supplierId,
        'product_id' => $productId,
        'unit_id' => $unitId,
        'quantity' => $quantity,
        // 'original_price' => str_replace(',', '', $originalPrice),
        // 'selling_price' => str_replace(',', '', $sellingPrice),
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
    $where = "WHERE event_id = '$eventId' AND product_id = '$productId' AND supplier_id = '$supplierId' ";
    $check = $stocks->getWhere($where);

    if(!empty($check)) {
        echo json_encode(['code' => 2, 'message' => "Product already have price in our database. Check events,product and supplier in product prices table."]);
        return;
    }
}

//Add data
if($actionType == 'add') {
    $resAction = $stocks->insertData($data);
} else if($actionType == 'update') {
    $where = " id = $id";
    $resAction = $stocks->updateData($data, $where);
} else if($actionType == 'delete') {
    $where = " id = $id";
    $resAction = $stocks->updateData($data, $where);
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