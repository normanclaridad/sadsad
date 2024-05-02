<?php
session_start();

require ('../../../models/Transaction_details.php');
require ('../../../models/Entrances.php');
require ('../../../models/Entrance_details.php');
require ('../../../models/Events.php');
require ('../../../models/Requested_dances.php');

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    echo json_encode(['code' => 4, 'message' => 'You are not authorized to access this page']);
    return;
}

$transactionDetails = new Transaction_details();
$entrances = new Entrances();
$requestedDances = new Requested_dances();

$eventId = isset($_POST['event']) ? $_POST['event'] : '';

$where = " AND t.event_id = $eventId
AND s.event_id = $eventId
AND pr.event_id = $eventId
AND t.good_for = 'N'
GROUP BY product_id
ORDER BY total_qty DESC";

$resSales = $transactionDetails->getSales($where);

$sales = [];

$totalSupplierAmount = 0.00;
$totalSellerAmount = 0.00;
$totalRevenue = 0.00;
foreach($resSales as $sale) {
    $sales[] = [
        'name' => $sale['name'],
        'total_qty' => $sale['total_qty'],
        'price' => number_format($sale['price'],2),
        'product_amount' => number_format($sale['product_amount'],2),
        'original_price' => number_format($sale['original_price'],2),
        'orig_product_amount' => number_format($sale['orig_product_amount'],2),
        'revenue' => number_format($sale['revenue'],2),
        'stock' => $sale['stock'],
    ];

    $totalSupplierAmount += $sale['orig_product_amount'];
    $totalSellerAmount += $sale['product_amount'];
    $totalRevenue += $sale['revenue'];
}

$whereEntranceCategory = " AND event_id = $eventId GROUP BY name";

$resEntrances = $entrances->getEntranceByCategoryPrice($whereEntranceCategory);
$entranceCategory = [
    [
        'name' => 'Male',
        'quantity' => 0,
        'total_amount' => 0.00
    ],
    [
        'name' => 'Female',
        'quantity' => 0,
        'total_amount' => 0.00
    ],
    [
        'name' => 'Kids',
        'quantity' => 0,
        'total_amount' => 0.00
    ],
    [
        'name' => 'Table-charge',
        'quantity' => 0,
        'total_amount' => 0.00
    ],
];

$entranceTotalAmount = 0.00;
if(!empty($resEntrances)) {
    $entranceCategory = [];
    foreach($resEntrances as $entrance) {
        $entranceCategory[] = [
            'name' => ucfirst($entrance['name']),
            'quantity' => $entrance['quantity'],
            'total_amount' => number_format($entrance['total_amount'], 2)
        ];

        $entranceTotalAmount += $entrance['total_amount'];
    }
}

$whereReqDance = "AND rd.event_id = $eventId";
$reqDanceSortBy = "rd.created_at ASC";

$resReqDances = $requestedDances->getCurachaRequestDanceDetails($whereReqDance, $reqDanceSortBy);
$dances = [];

$dancesTotalAmount = 0.00;
foreach($resReqDances as $dance) {
    $dances[] = [
        'category_name' => $dance['dance_category_name'],
        'name' => $dance['name'],
        'amount' => number_format($dance['amount'], 2)
    ];

    $dancesTotalAmount += $dance['amount'];
}


$data = [
    'sales' => $sales,
    'supplier_total_amount' => number_format($totalSupplierAmount,2),
    'seller_total_amount' => number_format($totalSellerAmount,2),
    'total_revenue' => number_format($totalRevenue,2),
    'entrance' => $entranceCategory,
    'entrance_total_amount' => number_format($entranceTotalAmount, 2),
    'dances_total_amount' => number_format($dancesTotalAmount, 2),
    'dances' => $dances
];


echo json_encode($data);
return;