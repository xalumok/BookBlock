

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
			<h2>Home Page</h2>
			<table id="books">
				<tr>
				    <th>Name</th>
				    <th>Author</th>
				</tr>
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
					$query = 'SELECT books.id, books.name, accounts.username FROM books INNER JOIN accounts ON books.author_id = accounts.id';

					if ($result = mysqli_query($con, $query)) {
						while($row = mysqli_fetch_assoc($result)) {
						           echo "<tr><td><a href='/book.php?id=".$row["id"]."'>".$row["name"]."</a></td><td>".$row["username"]."</td></tr>";
						        }
					  mysqli_free_result($result);
					}
					mysqli_close($con);
				?>
			</table>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src='home.js'></script>

	</body>
</html>