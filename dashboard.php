<?php
session_start();
?>
<html>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login to DashBoard</title>

	<style>
		<?php include './style.css'; ?>
	</style>
</head>

<body>

	<?php
	$name = "";
	$gender = "";
	$maritalStatus = "";
	if (isset($_SESSION["email"])) {
		include 'db.php';
		if ($tableExists) {
			$sql = "SELECT name, gender, marital_status FROM userinfo";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				// output data of each row
				while ($row = $result->fetch_assoc()) {
					$name = $row["name"];
					$gender = $row["gender"];
					$maritalStatus = $row["marital_status"];
				}
			} else {
				echo "<div class='error'>Something Went Wrong</div>";
			}
		} else {
			echo "<div class='error'>Something Went Wrong</div>";
		}
	}

	function logOut()
	{
		session_unset();
		session_destroy();
		session_start();
		$_SESSION["message"] = "You are Successfully Logged Out";
		header('location: index.php');
	}

	if (array_key_exists('logout', $_POST)) {
		logOut();
	}
	?>

	<div class="heading">
		<h1>The DashBoard</h1>
	</div>

	<div class="container">
		<div class="column1">
			<div class="name">
				<span>Name:</span>
				<span><?php echo $name; ?></span>
			</div>
			<div class="email">
				<span>Email:</span>
				<span><?php echo $_SESSION["email"]; ?></span>
			</div>
		</div>
		<div class="column2">
			<div class="gender">
				<span>Gender:</span>
				<span><?php echo $gender; ?></span>
			</div>
			<div class="maritalStatus">
				<span>Marital Status:</span>
				<span><?php echo $maritalStatus; ?></span>
			</div>
		</div>
	</div>

	<form method="POST">
		<input type="submit" name="logout" value="Log Out" />
	</form>
</body>

</html>