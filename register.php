<?php
session_start();
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'web_db';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if ( !isset($_POST['username'], $_POST['password'], $_POST['email'] )) {
	exit('Please fill both the username, email and password fields!');
}

if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        echo 'This username is already taken!';
        $stmt->close();
    } else {
        require "createAddress.php";
        $address = createAddress($_POST['username']);
        if ($stmt = $con->prepare('INSERT INTO accounts VALUES(NULL, ?, ?, ?, ?)')) {
            $stmt->bind_param('ssss', $_POST['username'], password_hash($_POST['password'],  PASSWORD_DEFAULT), $_POST['email'], $address);
            $stmt->execute();
            $stmt->close();
            if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
                $stmt->bind_param('s', $_POST['username']);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($id, $password);
                    $stmt->fetch();
                    if (password_verify($_POST['password'], $password)) {
                        session_regenerate_id();
                        $_SESSION['loggedin'] = TRUE;
                        $_SESSION['name'] = $_POST['username'];
                        $_SESSION['id'] = $id;
                        header('Location: home.php');
                    }
                }
                $stmt->close();
            }
        }
    }
}
?>