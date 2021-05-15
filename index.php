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
	$email = $password = "";
	$emailErr = $passwordErr = "";


	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		include 'db.php';

		// checking if email is empty
		if (empty($_POST['email'])) {
			$emailErr = "Email is required";
		} else {
			$email = $_POST['email'];
		}

		// checking if password is empty
		if (empty($_POST['password'])) {
			$passwordErr = "Password is required";
		} else {
			$password = $_POST['password'];
		}

		// checking if email and password are not empty
		if ($email && $password) {
			// checking if table exists
			if ($tableExists) {
				// checking wheather user exists
				$checkSql = $conn->query("select email from userinfo where email = '" . $email . "'");
				if (mysqli_num_rows($checkSql)) {

					// fetching the user password information
					$sql = "SELECT password from userinfo WHERE email = '" . $email . "'";
					$result = $conn->query($sql);

					// parsing through the result set
					if ($result->num_rows > 0) {
						// output data of each row
						while ($row = $result->fetch_assoc()) {
							// checking password is correct or not
							if ($row["password"] == $password) {
								session_destroy();
								session_start();
								$_SESSION["email"] = $email;
								$_SESSION["edit"] = "";
								header('location: dashboard.php');
							} else {
								$passwordErr = "Password is wrong";
							}
						}
					}
				} else {
					$emailErr = "User does not exists";
				}
			} else {
				echo "<span class='error'>Something Went Wrong</span>";
			}
		}
	}
	?>

	<div class="heading">
		<h1>Welcome To The DashBoard</h1>
		<h2>You are One Step Away From The DashBoard</h2>
	</div>

	<?php
	if (isset($_SESSION["message"])) {
		echo "<div class='success'>" . $_SESSION["message"] . "</div>";
		session_unset();
		session_destroy();
	}
	?>

	<div class="login">
		<h3>Login</h3>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
			<label for="email">Email</label>
			<input type="text" name="email" value="<?php echo (isset($email)) ? $email : ''; ?>" />
			<span class="error"><?php echo $emailErr; ?></span>

			<label for="password">Password</label>
			<input type="password" name="password" value="" />
			<span class="error"><?php echo $passwordErr; ?></span>

			<input type="submit" name="login" value="Login" />

			<span>Not Registered? <a href="register.php">Register</a></span>
		</form>
	</div>
</body>

</html>