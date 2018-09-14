<?php
$con = new mysqli("localhost", "root", "", "billmaker");
if($con->connect_error) {
  die("Could not connect to database");
}

$res = array('error' => false);

$action = 'read';

if(isset($_GET['action'])) {
  $action = $_GET['action'];
}

if($action == 'read') {
  $result = $con->query("SELECT * FROM test");
  $users = array();

  while ($row = $result->fetch_assoc()) {
    array_push($users, $row);
  }
  $res['users'] = $users;
}

if($action == 'create') {
  $username = $_POST['username'];
  $name = $_POST['name'];
  $email = $_POST['email'];

  $result = $con->query("INSERT INTO test (username, email) VALUES ('$username','$email')");
  if ($result) {
    $res['message'] = "User added";
  } else {
    $res['err'] = true;
    $res['message'] = "Could not insert";
  }
}

if($action == 'update') {
  $id = $_POST['id'];
  $username = $_POST['username'];
  $name = $_POST['name'];
  $email = $_POST['email'];

  $result = $con->query("UPDATE test SET username = '$username', name = '$name', email = '$email' WHERE id = '$id'");

  if ($result) {
    $res['message'] = "User update";
  } else {
    $res['err'] = true;
    $res['message'] = "Could not update";
  }
}

if($action == 'delete') {
  $id = $_POST["id"];

  $result = $con->query("DELETE FROM test WHERE id = '$id'");

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
?>
