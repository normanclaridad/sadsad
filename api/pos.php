<?php
session_start();

require ('../models/Stocks.php');
require ('../models/Prices.php');
require ('../models/Events.php');
require ('../models/Transactions.php');
require ('../models/Transaction_details.php');

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    echo json_encode(['code' => 4, 'message' => 'You are not authorized to access this page']);
    return;
}

$stocks = new Stocks();
$prices = new Prices();
$events = new Events();
$transactions = new Transactions();
$transactionDetails = new Transaction_details();

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
// $actionType = isset($_POST['action_type']) ? $_POST['action_type']: ''; 
$form = isset($_POST['form']) ? $_POST['form']: '';
$orders = isset($_POST['orders']) ? $_POST['orders']: '';
$status = isset($_POST['status']) ? 'Y': 'N';
// $utang = isset($_POST['good_for']) ? 'Y' : 'N';
$userId = $_SESSION['SESS_ID'];
$dateTime = date('Y-m-d H:i:s');

// if($actionType != 'delete') {
if(empty($form) || empty($orders)) {
    echo json_encode(['code' => 5, 'message' => 'Please take an order.']);
    return;
}
// }

$transactionNo = $transactions->generateTransactionNo();

$customerName = $form['customer_name'];
$actionType = $form['action_type'];
$cash = !empty($form['cash']) ? $form['cash'] : '0.00';
$change = !empty($form['change']) ? $form['change'] : '0.00';
$totalAmount = $form['total_amount'];
$utang = $form['good_for'];
// return;
if($actionType != 'delete') {
    $data = [
        'transaction_no' => $transactionNo,
        'name' => $customerName,
        'event_id' => $eventId,
        'total_amount' => str_replace(',', '', $totalAmount),
        'amount_paid' => str_replace(',', '', $cash),
        'amount_change' => $change,
        'good_for' => $utang,
        // 'status' => $status,
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
// print_r($data);
// return;
// Add data
$trxnId = 0;
if($actionType == 'add') {
    $resAction = $transactions->insertData($data);
    $trxnId = $resAction;
} else if($actionType == 'update') {
    $where = " id = $id";
    $resAction = $transactions->updateData($data, $where);
} else if($actionType == 'delete') {
    $where = " id = $id";
    $resAction = $transactions->updateData($data, $where);
}

if(!$resAction) {
    echo json_encode(['code' => 1, 'message' => 'Internal error. Please contact administrator.']);
    return;
}

if($resAction) {
    foreach($orders as $order) {
        $trxndetails = [
            'transaction_id' => $trxnId,
            'product_id' => $order['product_id'],
            'unit_id' => $order['unit_id'],
            'qty' => $order['quantity'],
            'price' => $order['price'],
            // 'status' => $order['product_id'],
            'created_by' => $userId,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_by' => $userId,
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        
        $resTrxn = $transactionDetails->insertData($trxndetails);

        if($resTrxn) {
            $where = "product_id = ". $order['product_id'] . " AND event_id=" . $eventId;
            $resStocks = $stocks->getWhere(" WHERE $where");
            $prevPurchase = $resStocks[0]['purchase'];
            $stockData = [
                'purchase' => $prevPurchase + $order['quantity'],
                'updated_by' => $userId,
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $where = "product_id = ". $order['product_id'] . " AND event_id=" . $eventId;
            $stocks->updateData($stockData, $where);
        }
    }
    
}

$actionMessage = 'added';
if($actionType == 'update') {
    $actionMessage = 'updated';
} else if($actionType == 'delete') {
    $actionMessage = 'deleted';
}

echo json_encode(['code' => 0, 'message' => 'Record has been successully ' . $actionMessage]);
return;