
<?php
	require "sendTokens.php";
	$res = sendTokens($_GET["user_token_address"],$_GET["username"], $_GET['author_token_address'], strval($_GET['token_amount']));
	if ($res[0])
	{
		$score = $_GET['rating'];
		$DATABASE_HOST = 'localhost';
		$DATABASE_USER = 'root';
		$DATABASE_PASS = '';
		$DATABASE_NAME = 'web_db';

		$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
		if ( mysqli_connect_errno() ) {
			exit('Failed to connect to MySQL: ' . mysqli_connect_error());
		}
		if ($stmt = $con->prepare('INSERT INTO grades VALUES(NULL, ?, ?, ?, ?)')) {
            $stmt->bind_param('iisd', intval($_GET['book_id']),intval($score),  $res[1], floatval($_GET['token_amount']));
            $stmt->execute();
            $stmt->close();
        }
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Home Page</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
			<div><a href="home.php"><h1>BookBlock</h1></a></div>
			<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
			<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		<div class="content">

			<h2><?=$res[1]?></h2>
			
		</div>
	</body>
</html>