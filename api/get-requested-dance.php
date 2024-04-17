<?php
require ('../models/Requested_dances.php');
require ('../inc/Helpers.php');

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    echo json_encode(['code' => 4, 'message' => 'You are not authorized to access this page']);
    return;
}

$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

$requestedDances = new Requested_dances();

//Helpers
$helpers = new Helpers();

$btnAction = '';

$eventId  = isset($_POST['event_id']) ? $_POST['event_id'] : '';

$params = $columns = $totalRecords = $data = [];
 
$params = $_REQUEST;
$urlFormer = '';

if(in_array($btnAction, ['excel', 'print'])) {
    $_SESSION['SESS_GEN_TOKEN'] = rand(10000, 10000000);

    $urlFormer = 'token='. $_SESSION['SESS_GEN_TOKEN'];
}

$columns = [  'e.transaction_no', 'e.name', 'e.status', 'e.created_at' ];

$whereCondition = $sqlTot = $sqlRec = '';

$whereCondition .= " AND event_id = $eventId";
if( !empty($params['search']['value']) ) {
    $whereCondition .= " AND ";
    $whereCondition .= " ( rd.name LIKE '%". $params['search']['value'] ."%' ";    
    $whereCondition .= " OR dc.name LIKE '%".$params['search']['value']."%' )";

    $urlFormer .= '&search_value=' . $params['search']['value'];
}

$sortBy = 'rd.id DESC';

if(isset($params['order'])) {
    $sortBy = $columns[$params['order'][0]['column']]."   ". $params['order'][0]['dir'];
    $urlFormer .= '&sort_by=' . $columns[$params['order'][0]['column']];
    $urlFormer .= '&sort_type=' . $params['order'][0]['dir'];
}

$start  = $params['start'];
$length = $params['length'];

//Get total
$totalRecords = $requestedDances->getTotal($whereCondition, $sortBy);

//Get all tsag
$fetchResults = $requestedDances->getJoinWhere($whereCondition, $sortBy, $start, $length);
$data = [];
foreach($fetchResults AS $row) {
    $encryptedId = $helpers->encryptDecrypt($row['id']);

    // $quantity = number_format($row['quantity'],1);
    // $sellingPrice = number_format($row['selling_price'],2);
    $url = $protocol . $_SERVER['HTTP_HOST'] . '/views/view-pos.php?id=' . $encryptedId;
    $action = '<a class="btn-edit" data-id="'. $row['id'] .'" data-amount="'. number_format($row['amount'],2) .'" data-dance-category-id="'. $row['dance_category_id'] .'" data-name="'. $row['name'] .'"><i class="bi bi-pencil"></i></a>';
    $action .= '&nbsp; <a class="btn-danger btn-delete" data-id="'. $row['id'] .'" data-name="'. $row['name'] .'"><i class="bx bxs-trash"></i></a>';
    $status = '<i class = "bi bi-x"></i>';
    if ($row['status'] == 'Y'){
        $status = '<i class = "bi bi-check"></i>';
    }
    $data[] = [
        $row['name'],
        $row['dance_category_name'],
        number_format($row['amount'],2),
        // number_format($row['cash'],2),
        // number_format($row['amount_change'],2),
        // $status,
        // date('M d, Y h:i a', strtotime($row['created_at'])),
        $action,
    ];
}

$baseUrl = $protocol . $_SERVER['HTTP_HOST'] . '/views/settings/products/'.$btnAction.'.php?' . $urlFormer;

$json_data = [
    "draw"            => intval( $params['draw'] ),   
    "recordsTotal"    => intval( $totalRecords ),  
    "recordsFiltered" => intval($totalRecords),
    "data"            => $data,
    'url'             => $baseUrl
];

echo json_encode($json_data);