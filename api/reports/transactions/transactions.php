<?php
session_start();

require ('../../../models/Transactions.php');
require ('../../../models/Entrances.php');
require ('../../../models/Entrance_details.php');
require ('../../../models/Events.php');
require ('../../../models/Requested_dances.php');

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    echo json_encode(['code' => 4, 'message' => 'You are not authorized to access this page']);
    return;
}

$transactions = new Transactions();

$eventId = isset($_POST['event']) ? $_POST['event'] : '';

$where = " AND t.event_id = $eventId";
$resTransactions = $transactions->getTransactions($where);

$trxn = [];
$total = 0;
$totalUtang = 0;
foreach($resTransactions as $row) {

    if(($row['good_for'] == 'Y')) {
        $totalUtang += $row['total_amount'];
    } else {
        $total += $row['total_amount'];
    }

    $trxn[] = [
        'transaction_no' => $row['transaction_no'],
        'event_name' => $row['event_name'],
        'customer_name' => $row['name'],
        'good_for' => ($row['good_for'] == 'Y') ? number_format($row['total_amount'],2) : '',
        'total_amount' => ($row['good_for'] == 'Y') ? '-'. number_format($row['total_amount'],2) : number_format($row['total_amount'],2),
        'amount_paid' => number_format($row['amount_paid'],2),
        'amount_change' => number_format($row['amount_change'],2),
        'remarks' => $row['remarks'],
        'created_at' => date("M d, Y h:i a", strtotime($row['created_at'])),
    ];
}

$data = [
    'transactions' => $trxn,
    'total_amount' => number_format($total,2),
    'total_good_for' => number_format($totalUtang, 2)
];

echo json_encode($data);
return;