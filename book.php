<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'web_db';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// We don't have the password or email info stored in sessions so instead we can get the results from the database.
$stmt = $con->prepare('SELECT books.name, accounts.username, books.description, accounts.tokenAddress, accounts.username FROM books INNER JOIN accounts ON books.author_id = accounts.id WHERE books.id=?');
$book_id = $_GET["id"];
$username = $_SESSION['name'];
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_GET['id']);
$stmt->execute();
$stmt->bind_result($book_name, $author_name, $description, $author_token_address, $author_name);
$stmt->fetch();
$stmt->close();


$stmt = $con->prepare('SELECT `tokenAddress` FROM accounts WHERE id = ?');
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($user_token_address);
$stmt->fetch();
$stmt->close();


$stmt = $con->prepare('SELECT SUM(grade * tokenAmount) /SUM(tokenAmount) FROM grades WHERE book_id = ?');
$stmt->bind_param('i', $book_id);
$stmt->execute();
$stmt->bind_result($book_rating);
$stmt->fetch();
$stmt->close();

$con->close();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Profile Page</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src='rating.js'></script>
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
			<h2><?=$book_name?></h2>
			<div>
				<p><?=$description?></p>
				 <div id="containerr">
				 	<table>
					<tr>
						<td>Author:</td>
						<td><?=$author_name?></td>
					</tr>
					<tr>
						<td>Author token amount:</td>
						<td><?php require "getBalance.php"; echo getBalance($author_token_address); ?></td>
					</tr>
					<tr>
						<td>Weighted rating:</td>
						<td><?=$book_rating?></td>
					</tr>
				</table>
				<h1>Rate this book!</h1>
				<form id="form" action="sendTokensToAuthor.php">
					<input type="number" name="token_amount" value="3">
					<i star-rating="1" class="fas fa-star star"></i>
					<i star-rating="2" class="fas fa-star star"></i>
					<i star-rating="3" class="fas fa-star star"></i>
					<i star-rating="4" class="fas fa-star star"></i>
					<i star-rating="5" class="fas fa-star star"></i>
					<?php 
						echo '<input type="hidden" name="book_id" value="'.$book_id.'">';
						echo '<input type="hidden" name="username" value="'.$username.'">';
						echo '<input type="hidden" name="author_token_address" value="'.$author_token_address.'">';
						echo '<input type="hidden" name="user_token_address" value="'.$user_token_address.'">';

					?>
					
					<input type="number" name="rating" id="ratingInput" value="3" style="display: none;">
					<input type="submit" value="Submit">
				</form>
				 </div>

				
			</div>
		</div>
		

	</body>
</html>