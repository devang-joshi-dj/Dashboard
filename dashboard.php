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
	$changeValue = "";
	$changeValueErr = "";

	if (isset($_SESSION['email'])) {
		include 'db.php';
		if ($tableExists) {
			$sql = "SELECT name, gender, marital_status FROM userinfo where email = '" . $_SESSION["email"] . "'";
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
	} else {
		session_unset();
		session_destroy();
		session_start();
		$_SESSION["message"] = "You were redirected back to the home page";
		header('location: index.php');
	}

	$flag = "";
	function logOut()
	{
		session_unset();
		session_destroy();
		session_start();
		$_SESSION["message"] = "You are Successfully Logged Out";
		header('location: index.php');
	}

	function close()
	{
		$_SESSION["edit"] = "";
	}

	if (array_key_exists('logout', $_POST)) {
		logOut();
	}

	if (array_key_exists('edit', $_POST)) {
		$_SESSION["edit"] = "true";
	}

	if (array_key_exists('close', $_POST)) {
		$_SESSION["edit"] = "";
	}

	if (isset($_POST["changeValue"]) && !empty($_POST["changeValue"])) {
		$changeValue = $_POST["changeValue"];
		echo $changeValue;
	}
	?>

	<div class="heading">
		<h1>The DashBoard</h1>
	</div>

	<div class="container">
		<div class="editContainer">
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
				<input type="submit" name="edit" value="Edit" />
			</form>
		</div>
		<div class="infoContainer">
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
	</div>

	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
		<input type="submit" name="logout" value="Log Out" />
	</form>

	<?php
	if (!empty($_SESSION["edit"])) { ?>
		<div class="editPanel">
			<div class="closeContainer">
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
					<input type="submit" name="close" value="Close" />
				</form>
			</div>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
				<div class="editSection">
					<select name="column" id="column">
						<option value="name">Name</option>
						<option value="maritalStatus">Marital Status</option>
						<input type="text" name="changeValue" value="" />
					</select>
				</div>
				<?php echo $changeValueErr; ?>
				<input type="submit" name="change" value="Change" />
			</form>
		</div>
	<?php
	}
	?>
</body>

</html>