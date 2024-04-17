<?php
require ('../../../models/Prices.php');
require ('../../../inc/Helpers.php');

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    echo json_encode(['code' => 4, 'message' => 'You are not authorized to access this page']);
    return;
}

$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

$prices = new Prices();

//Helpers
$helpers = new Helpers();

// $tsag       = isset($_POST['tsag']) ? $_POST['tsag'] : ''; 

$btnAction  = isset($_POST['action']) ? $_POST['action'] : '';
$eventId  = isset($_POST['event_id']) ? $_POST['event_id'] : '';

$params = $columns = $totalRecords = $data = [];
 
$params = $_REQUEST;
$urlFormer = '';

if(in_array($btnAction, ['excel', 'print'])) {
    $_SESSION['SESS_GEN_TOKEN'] = rand(10000, 10000000);

    $urlFormer = 'token='. $_SESSION['SESS_GEN_TOKEN'];
}

$columns = [  'p.name', 'pr.status', 'pr.created_at' ];

$whereCondition = $sqlTot = $sqlRec = '';

if( !empty($params['search']['value']) ) {
    $whereCondition .= " AND ";
    $whereCondition .= " ( p.name LIKE '%". $params['search']['value'] ."%' )";    
    // $whereCondition .= " OR o.status LIKE '%".$params['search']['value']."%' )";

    $urlFormer .= '&search_value=' . $params['search']['value'];
}

if(!empty($eventId)) {
    $whereCondition .= " AND event_id = $eventId";
}

$sortBy = 'pr.id DESC';

if(isset($params['order'])) {
    $sortBy = $columns[$params['order'][0]['column']]."   ". $params['order'][0]['dir'];
    $urlFormer .= '&sort_by=' . $columns[$params['order'][0]['column']];
    $urlFormer .= '&sort_type=' . $params['order'][0]['dir'];
}

$start  = $params['start'];
$length = $params['length'];

//Get total
$totalRecords = $prices->getTotal($whereCondition, $sortBy);

//Get all tsag
$fetchResults = $prices->getJoinWhere($whereCondition, $sortBy, $start, $length);
$data = [];
foreach($fetchResults AS $row) {
    $encryptedId = $helpers->encryptDecrypt($row['id']);

    $originalPrice = number_format($row['original_price'],2);
    $sellingPrice = number_format($row['selling_price'],2);
    // $farmersUrl = $protocol . $_SERVER['HTTP_HOST'] . '/views/user-roles/farmers.php?id=' . $encryptedId;
    $action = '<a class="btn btn-circle btn-sm btn-primary btn-edit" data-id="'. $row['id'] .'"data-product-id="'. $row['product_id'] .'" data-unit-id="'. $row['unit_id'] .'" data-original-price="'. $originalPrice .'" data-selling-price="'. $sellingPrice .'" data-status="'. $row['status'] .'"><i class="bx bx-pencil"></i></a>';
    $action .= '&nbsp; <a class="btn btn-circle btn-sm btn-danger btn-delete" data-id="'. $row['id'] .'" data-status="'. $row['status'] .'"><i class="bx bxs-trash"></i></a>';
    $status = '<i class = "bi bi-x"></i>';
    if ($row['status'] == 'Y'){
        $status = '<i class = "bi bi-check"></i>';
    }
    $data[] = [
        $row['product_name'],
        $row['unit_name'],
        $originalPrice,
        $sellingPrice,
        $status,
        date('M d, Y h:i a', strtotime($row['created_at'])),
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