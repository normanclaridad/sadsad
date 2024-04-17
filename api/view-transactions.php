<?php
require ('../models/Transactions.php');
require ('../models/Transaction_details.php');
require ('../inc/Helpers.php');

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    echo json_encode(['code' => 4, 'message' => 'You are not authorized to access this page']);
    return;
}

$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

$transactions = new Transactions();
$transactionDetails = new Transaction_details();

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


$resTransactions = $transactions->getWhere("WHERE id=$id");


$resTrxnDetails = $transactionDetails->getTransactionDetails("WHERE td.transaction_id=". $id);

$trxnDetails = [];
foreach($resTrxnDetails as $row) {
    $total = $row['qty'] * $row['price'];
    $trxnDetails[] = [
        'product_name' => $row['product_name'],
        'unit_name' => $row['unit_name'],
        'qty' => $row['qty'],
        'price' => number_format($row['price'],2),
        'total' => number_format($total,2)
    ];
}

$data = [
    'transaction_no' => $resTransactions[0]['transaction_no'],
    'name' => $resTransactions[0]['name'],
    'total_amount' => number_format($resTransactions[0]['total_amount'],2),
    'amount_paid' => number_format($resTransactions[0]['amount_paid'],2),
    'amount_change' => number_format($resTransactions[0]['amount_change'],2),
    'status' => $resTransactions[0]['status'],
    'created_at' => date("M-d, Y h:i:s a", strtotime($resTransactions[0]['created_at'])),
    'trxndetails' => $trxnDetails
];


echo json_encode($data);
return;