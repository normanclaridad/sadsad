<?php
require ('../../../models/Entrance_prices.php');
require ('../../../inc/Helpers.php');

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    echo json_encode(['code' => 4, 'message' => 'You are not authorized to access this page']);
    return;
}

$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

$entrancePrices = new Entrance_prices();

//Helpers
$helpers = new Helpers();

// $tsag       = isset($_POST['tsag']) ? $_POST['tsag'] : ''; 

$btnAction  = isset($_POST['action']) ? $_POST['action'] : '';

$params = $columns = $totalRecords = $data = [];
 
$params = $_REQUEST;
$urlFormer = '';

if(in_array($btnAction, ['excel', 'print'])) {
    $_SESSION['SESS_GEN_TOKEN'] = rand(10000, 10000000);

    $urlFormer = 'token='. $_SESSION['SESS_GEN_TOKEN'];
}

$columns = [  'ep.event_name', 'ep.male', 'ep.female', 'ep.kids', 'ep.table_charge', 'ur.status', 'ur.created_at' ];

$whereCondition = $sqlTot = $sqlRec = '';

if( !empty($params['search']['value']) ) {
    $whereCondition .= " AND ";
    $whereCondition .= " ( e.name LIKE '%". $params['search']['value'] ."%' )";
    // $whereCondition .= " OR o.status LIKE '%".$params['search']['value']."%' )";

    $urlFormer .= '&search_value=' . $params['search']['value'];
}

$sortBy = 'ep.id DESC';

if(isset($params['order'])) {
    $sortBy = $columns[$params['order'][0]['column']]."   ". $params['order'][0]['dir'];
    $urlFormer .= '&sort_by=' . $columns[$params['order'][0]['column']];
    $urlFormer .= '&sort_type=' . $params['order'][0]['dir'];
}

$start  = $params['start'];
$length = $params['length'];

//Get total
$totalRecords = $entrancePrices->getTotal($whereCondition, $sortBy);

//Get all tsag
$fetchResults = $entrancePrices->getJoinWhere($whereCondition, $sortBy, $start, $length);
$data = [];
foreach($fetchResults AS $row) {
    $encryptedId = $helpers->encryptDecrypt($row['id']);
    $farmersUrl = $protocol . $_SERVER['HTTP_HOST'] . '/views/user-roles/farmers.php?id=' . $encryptedId;
    $action = '<a class="btn btn-circle btn-sm btn-primary btn-edit" data-id="'. $row['id'] .'" data-event-id="'. $row['event_id'] .'" data-status="'. $row['status'] .'" data-male="'. number_format($row['male'],2) .'" data-female="'. number_format($row['female'],2) .'" data-kids="'. number_format($row['kids'],2) .'" data-table-charge="'. number_format($row['table_charge'],2) .'"><i class="bx bx-pencil"></i></a>';
    $action .= '&nbsp; <a class="btn btn-circle btn-sm btn-danger btn-delete" data-id="'. $row['id'] .'" data-name="'. $row['event_name'] .'" data-status="'. $row['status'] .'"><i class="bx bxs-trash"></i></a>';
    $status = '<i class = "bi bi-x"></i>';
    if ($row['status'] == 'Y'){
        $status = '<i class = "bi bi-check"></i>';
    }
    $data[] = [
        $row['event_name'],
        number_format($row['male'],2),
        number_format($row['female'],2),
        number_format($row['kids'],2),
        number_format($row['table_charge'],2),
        $status,
        date('M d, Y h:i a', strtotime($row['created_at'])),
        $action,
    ];
}

$baseUrl = $protocol . $_SERVER['HTTP_HOST'] . '/views/settings/events/'.$btnAction.'.php?' . $urlFormer;

$json_data = [
    "draw"            => intval( $params['draw'] ),   
    "recordsTotal"    => intval( $totalRecords ),  
    "recordsFiltered" => intval($totalRecords),
    "data"            => $data,
    'url'             => $baseUrl
];

echo json_encode($json_data);