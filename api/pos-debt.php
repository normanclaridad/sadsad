<?php
session_start();

require ('../models/Stocks.php');
require ('../models/Prices.php');
require ('../models/Events.php');
require ('../models/Transactions.php');
require ('../models/Transaction_details.php');
require ('../models/Transaction_history.php');

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    echo json_encode(['code' => 4, 'message' => 'You are not authorized to access this page']);
    return;
}

$stocks = new Stocks();
$prices = new Prices();
$events = new Events();
$transactions = new Transactions();
$transactionDetails = new Transaction_details();
$transactionHistory = new Transaction_history();

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
$actionType = isset($_POST['action_type']) ? $_POST['action_type'] : '';     
$totalDebt = isset($_POST['total_debt']) ? $_POST['total_debt']: '';
$cash = isset($_POST['cash']) ? $_POST['cash']: '';
$change = isset($_POST['change']) ? $_POST['change']: 0.00;
$userId = $_SESSION['SESS_ID'];
$dateTime = date('Y-m-d H:i:s');


$resTrxn = $transactions->getTransactionWhere("WHERE id = $id");

if(empty($resTrxn)) {
    echo json_encode(['code' => 4, 'message' => 'Invalid transaction.']);
    return;
}

$status = 'Y';
if($cash >= $totalDebt) {
    $status = 'P';
}

$trxnData = [
    'event_id' => $resTrxn['event_id'],
    'name' => $resTrxn['name'],
    'good_for' => $resTrxn['good_for'],
    'total_amount' => $resTrxn['total_amount'],
    'amount_paid' => $resTrxn['amount_paid'],
    'amount_change' => $resTrxn['amount_change'],
    'status' => $resTrxn['status'],
    'remarks' => $resTrxn['remarks'],
    'created_by' => $userId,
    'created_at' => $dateTime,
    'updated_by' => $userId,
    'updated_at' => $dateTime
];

//Insert transaction history
$trxnHistory = $transactionHistory->insertData($trxnData);
// return;

$totalCash = $resTrxn['amount_paid'] + $cash;

$data = [
    'amount_paid' => str_replace(',', '', $totalCash),
    'amount_change' => str_replace(',', '', $change),
    'status' => $status,
    'updated_by' => $userId,
    'updated_at' => $dateTime,
];

$where = " id = $id";
$trxnStatus = $transactions->updateData($data, $where);

//Insert again the current transaction
$resTrxn = $transactions->getTransactionWhere("WHERE id = $id");

$trxnData = [
    'event_id' => $resTrxn['event_id'],
    'name' => $resTrxn['name'],
    'good_for' => $resTrxn['good_for'],
    'total_amount' => $resTrxn['total_amount'],
    'amount_paid' => str_replace(',', '', $cash),
    'amount_change' => str_replace(',', '', $change),
    'status' => $resTrxn['status'],
    'remarks' => $resTrxn['remarks'],
    'created_by' => $userId,
    'created_at' => $dateTime,
    'updated_by' => $userId,
    'updated_at' => $dateTime
];

//Insert transaction history
$trxnHistory = $transactionHistory->insertData($trxnData);

$actionMessage = 'added';
if($actionType == 'update') {
    $actionMessage = 'updated';
} else if($actionType == 'delete') {
    $actionMessage = 'deleted';
}

echo json_encode(['code' => 0, 'message' => 'Record has been successully ' . $actionMessage]);
return;