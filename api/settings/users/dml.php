<?php
session_start();

require ('../../../models/Users.php');

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    echo json_encode(['code' => 4, 'message' => 'You are not authorized to access this page']);
    return;
}

$users = new Users();

$id = isset($_POST['id']) ? $_POST['id'] : ''; 
$actionType = isset($_POST['action_type']) ? $_POST['action_type']: ''; 
$firstName = isset($_POST['first_name']) ? $_POST['first_name']: '';
$lastName = isset($_POST['last_name']) ? $_POST['last_name']: '';
$userName = isset($_POST['user_name']) ? trim($_POST['user_name']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';
$confirmPassword = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';
$userRole = isset($_POST['user_role']) ? trim($_POST['user_role']) : '';
$status = isset($_POST['status']) ? 'Y': 'N';
$userId = $_SESSION['SESS_ID'];
$dateTime = date('Y-m-d H:i:s');

if($actionType != 'delete') {
    $data = [
        'first_name' => $firstName,
        'last_name' => $lastName,
        'user_role_id' => $userRole,
        'username' => $userName,
        'status' => $status,
        'updated_by' => $userId,
        'updated_at' => $dateTime
    ];

    if($actionType == 'add') {
        $data = array_merge($data, [
            'password' => hash('sha512', $password),
            'created_at' => $dateTime, 
            'created_by' => $userId
        ]);
    }
    

} else {
    $data = [
        'status' => 'D',        
        'updated_by' => $userId,
        'updated_at' => $dateTime
    ];
}

if($actionType == 'add') {
    $where = " AND username = '$userName' ";
    $check = $users->getWhere($where);

    if(!empty($check)) {
        echo json_encode(['code' => 2, 'message' => "$userName already exist in our database."]);
        return;
    }
}

//Add data
if($actionType == 'add') {
    $resAction = $users->insertData($data);
} else if($actionType == 'update') {
    $where = " id = $id";
    $resAction = $users->updateData($data, $where);
} else if($actionType == 'delete') {
    $where = " id = $id";
    $resAction = $users->updateData($data, $where);
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