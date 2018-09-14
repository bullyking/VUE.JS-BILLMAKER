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
    $result = $con->query("SELECT * FROM room ORDER BY room_number ASC");
    $rooms = array();

    while ($row = $result->fetch_assoc()) {
        array_push($rooms, $row);
    }
    $res['rooms'] = $rooms;
}

if ($action == 'create') {
    $room_id = $_POST['room_id'];
    $host_id = $_POST['host_id'];
    $name_title = $_POST['name_title'];
    $fullname = $_POST['fullname'];
    $nickname = $_POST['nickname'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $birthday = $_POST['birthday'];
    $room_number = $_POST['room_number'];
    $room_price = $_POST['room_price'];
    $cable_price = $_POST['cable_price'];
    $trash_price = $_POST['trash_price'];
    $park_price = $_POST['park_price'];
    $other_price = $_POST['other_price'];

    $result = $con->query("INSERT INTO room (room_id, host_id, name_title, fullname, nickname, age, gender, phone_number, email,
     birthday, room_number, room_price, cable_price, trash_price, park_price, other_price) VALUES ('$room_id','$host_id','$name_title','$fullname',
       '$nickname','$age','$gender','$phone_number','$email','$birthday','$room_number','$room_price','$cable_price','$trash_price','$park_price','$other_price')");
    if ($result) {
        $res['message'] = "Room added";
    } else {
        $res['err'] = true;
        $res['message'] = "Could not insert";
    }
}

if ($action == 'update') {
    $id = $_POST['id'];
    $room_id = $_POST['room_id'];
    $host_id = $_POST['host_id'];
    $name_title = $_POST['name_title'];
    $fullname = $_POST['fullname'];
    $nickname = $_POST['nickname'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $birthday = $_POST['birthday'];
    $room_number = $_POST['room_number'];
    $room_price = $_POST['room_price'];
    $cable_price = $_POST['cable_price'];
    $trash_price = $_POST['trash_price'];
    $park_price = $_POST['park_price'];
    $other_price = $_POST['other_price'];

    $result = $con->query("UPDATE room SET room_id = $room_id, host_id = '$host_id', name_title = '$name_title', fullname = '$fullname',
    nickname = '$nickname', age = '$age', gender = '$gender', phone_number = '$phone_number', email = '$email',
    birthday = '$birthday', room_number = '$room_number', room_price = '$room_price', cable_price = '$cable_price',
    trash_price = '$trash_price', park_price = '$park_price', other_price = '$other_price' WHERE id = '$id'");

    if ($result) {
        $res['message'] = "Room update";
    } else {
        $res['err'] = true;
        $res['message'] = "Could not update";
    }
}

if ($action == 'delete') {
    $id = $_POST["id"];

    $result = $con->query("DELETE FROM room WHERE id = '$id'");

    if ($result) {
        $res['message'] = "Room deleted";
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
