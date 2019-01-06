<?php
$conn = new mysqli("localhost","root","","mydb");
if($conn->connect_error)
{
	die('mysql Databse not Connected'.$conn->connect_errno());
}

$res =array('error'=>false);

$action = 'read';

if(isset($_GET['action']))
{
	$action =  $_GET['action'];
}

if($action =='read')
{
	$result = $conn->query("Select * from users ORDER BY id DESC LIMIT 0,10");
	$users =array();
	while ($row =$result->fetch_assoc()) {
		array_push($users, $row);
	}
	$res['users'] = $users;

}
if($action =='create')
{
	$fname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$email = $_POST['email'];
	$result = $conn->query("INSERT INTO users(firstname,lastname,email)VALUES('$fname','$lastname','$email')");
	if($result)
	{
		$res['message'] ="User added successfully!";
	}
	else
	{
		$res['error'] = true;
		$res['message'] ="User added Failed!";
	}

}
if($action =='update')
{
	$id= $_POST['id'];
	$fname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$email = $_POST['email'];
	$result = $conn->query("UPDATE users SET firstname='$fname',lastname='$lastname',email='$email' where id='$id'");
	if($result)
	{
		$res['message'] ="User Updated successfully!";
	}
	else
	{
		$res['error'] = true;
		$res['message'] ="User Updated Failed!";
	}

}
if($action =='delete')
{
	$id= $_POST['id'];
	$result = $conn->query("DELETE FROM users  where id='$id'");
	if($result)
	{
		$res['message'] ="User Deleted successfully!";
	}
	else
	{
		$res['error'] = true;
		$res['message'] ="User Deleted Failed!";
	}

}


$conn->close();
header("Content-type: application/json");
echo  json_encode($res);
die();
?>