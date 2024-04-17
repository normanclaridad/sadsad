<?php
require ('../../../models/Events.php');
require ('../../../inc/Helpers.php');

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    echo json_encode(['code' => 4, 'message' => 'You are not authorized to access this page']);
    return;
}

$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

$events = new Events();

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

$columns = [  'e.name', 'ur.status', 'ur.created_at' ];

$whereCondition = $sqlTot = $sqlRec = '';

if( !empty($params['search']['value']) ) {
    $whereCondition .= " AND ";
    $whereCondition .= " ( e.name LIKE '%". $params['search']['value'] ."%' )";    
    // $whereCondition .= " OR o.status LIKE '%".$params['search']['value']."%' )";

    $urlFormer .= '&search_value=' . $params['search']['value'];
}

$sortBy = 'e.id DESC';

if(isset($params['order'])) {
    $sortBy = $columns[$params['order'][0]['column']]."   ". $params['order'][0]['dir'];
    $urlFormer .= '&sort_by=' . $columns[$params['order'][0]['column']];
    $urlFormer .= '&sort_type=' . $params['order'][0]['dir'];
}

$start  = $params['start'];
$length = $params['length'];

//Get total
$totalRecords = $events->getTotal($whereCondition, $sortBy);

//Get all tsag
$fetchResults = $events->getJoinWhere($whereCondition, $sortBy, $start, $length);
$data = [];
foreach($fetchResults AS $row) {
    $encryptedId = $helpers->encryptDecrypt($row['id']);
    $farmersUrl = $protocol . $_SERVER['HTTP_HOST'] . '/views/user-roles/farmers.php?id=' . $encryptedId;
    $action = '<a class="btn btn-circle btn-sm btn-primary btn-edit" data-id="'. $row['id'] .'" data-name="'. $row['name'] .'" data-status="'. $row['status'] .'" data-date-started="'. date('Y-m-d', strtotime($row['start'])) .'" data-time-started="'. date('H:i:s', strtotime($row['start'])) .'" data-date-finish="'. date('Y-m-d', strtotime($row['end'])) .'" data-time-finish="'. date('H:i:s', strtotime($row['end'])) .'"><i class="bx bx-pencil"></i></a>';
    $action .= '&nbsp; <a class="btn btn-circle btn-sm btn-danger btn-delete" data-id="'. $row['id'] .'" data-name="'. $row['name'] .'" data-status="'. $row['status'] .'"><i class="bx bxs-trash"></i></a>';
    $status = '<i class = "bi bi-x"></i>';
    if ($row['status'] == 'Y'){
        $status = '<i class = "bi bi-check"></i>';
    }
    $data[] = [
        $row['name'],
        date('M d, Y h:i a', strtotime($row['start'])),
        date('M d, Y h:i a', strtotime($row['end'])),
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