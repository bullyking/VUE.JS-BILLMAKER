<?php
$con = new mysqli("localhost", "root", "", "billmaker");
mysqli_query($con, "SET NAMES 'utf8' ");
if ($con->connect_error) {
    die("Could not connect to database");
}

$res = array('error' => false);

$action = 'read';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

if ($action == 'read') {
    $result = $con->query("SELECT * FROM users");
    $users = array();

    while ($row = $result->fetch_assoc()) {
        array_push($users, $row);
    }
    $res['users'] = $users;
}

if ($action == 'create') {
    $UsID = $_POST['UsID'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $contact_no = $_POST['contact_no'];
    $address = $_POST['address'];
    $district = $_POST['district'];
    $sub_district = $_POST['sub_district'];
    $province = $_POST['province'];
    $postal_code = $_POST['postal_code'];

    $result = $con->query("INSERT INTO users (UsID, email, password, first_name, last_name, contact_no,
     address, district, sub_district, province, postal_code) VALUES ('$UsID','$email','$password','$first_name',
       '$last_name','$contact_no','$address','$district','$sub_district','$province','$postal_code')");
    if ($result) {
        $res['message'] = "User added";
    } else {
        $res['err'] = true;
        $res['message'] = "Could not insert";
    }
}

if ($action == 'update') {
    $user_id = $_POST['id'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $contact_no = $_POST['contact_no'];
    $address = $_POST['address'];
    $district = $_POST['district'];
    $sub_district = $_POST['sub_district'];
    $province = $_POST['province'];
    $postal_code = $_POST['postal_code'];

    $result = $con->query("UPDATE users SET email = '$email', password = '$password', first_name = '$first_name',
    last_name = '$last_name', contact_no = '$contact_no', address = '$address', district = '$district', sub_district = '$sub_district',
    province = '$province', postal_code = '$postal_code' WHERE user_id = '$user_id'");

    if ($result) {
        $res['message'] = "User update";
    } else {
        $res['err'] = true;
        $res['message'] = "Could not update";
    }
}

if ($action == 'delete') {
    $user_id = $_POST["user_id"];

    $result = $con->query("DELETE FROM users WHERE user_idid = '$user_id'");

    if ($result) {
        $res['message'] = "User deleted";
    } else {
        $res['err'] = true;
        $res['message'] = "Could not deleted";
    }
}

$con->close();

header("Content-type: application/json");
header("Access-Control-Allow-Origin: *");
echo json_encode($res);
die();
