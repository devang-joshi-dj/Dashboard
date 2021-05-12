<html>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Register to DashBoard</title>

	<style>
		<?php include './style.css'; ?>
	</style>
</head>

<body>
	<?php
	$name = $email = $password = $gender = $maritalStatus = "";
	$nameErr = $emailErr = $passwordErr = $genderErr = $maritalStatusErr = "";


	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		include 'db.php';

		// checking if name is empty
		if (empty($_POST['name'])) {
			$nameErr = "Name is required";
		} else {
			$name = $_POST['name'];
		}

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

		// checking if gender is empty
		if (isset($_POST['gender'])) {
			if (!empty($_POST['gender'])) {
				$gender = $_POST['gender'];
			}
		} else {
			$genderErr = "Gender is required";
		}

		// checking if marital status is empty
		if (isset($_POST['maritalStatus'])) {
			if (!empty($_POST['maritalStatus'])) {
				$maritalStatus = $_POST['maritalStatus'];
			}
		} else {
			$maritalStatusErr = "Marital Status is required";
		}

		// checking if email and password are not empty
		if ($name && $email && $password && $gender && $maritalStatus) {
			$sql = "
			INSERT INTO userinfo
			(name, email, password, gender, marital_status)
			VALUES
			('" . $name . "', '" . $email . "', '" . $password . "', '" . $gender . "', '" . $maritalStatus . "'
			)";

			// checking if table exists
			if ($tableExists && $conn->query($sql) === TRUE) {
				session_start();
				$_SESSION["message"] = "You are Successfully Registered";
				header('location: index.php');
			} else {
				echo "<span class='error'>Something Went Wrong</span>";
			}
		}
	}
	?>

	<div class="heading">
		<h1>Welcome To The DashBoard</h1>
		<h2>We are happy to see you here</h2>
	</div>

	<div class="login">
		<h3>Register</h3>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
			<label for="name">Name</label>
			<input type="name" name="name" value="<?php echo (isset($name)) ? $name : ''; ?>" />
			<span class="error"><?php echo $nameErr; ?></span>

			<label for="email">Email</label>
			<input type="email" name="email" value="<?php echo (isset($email)) ? $email : ''; ?>" />
			<span class="error"><?php echo $emailErr; ?></span>

			<label for="password">Password</label>
			<input type="password" name="password" value="" />
			<span class="error"><?php echo $passwordErr; ?></span>

			<label for="gender">Gender</label>
			<div class="radio">
				<input type="radio" name="gender" value="Female"><span>Female</span>
				<input type="radio" name="gender" value="Male"><span>Male</span>
				<input type="radio" name="gender" value="Other"><span>Other</span>
			</div>
			<span class="error"><?php echo $genderErr; ?></span>

			<label for="maritalStatus">Marital Status</label>
			<div class="radio">
				<input type="radio" name="maritalStatus" value="Single"><span>Single</span>
				<input type="radio" name="maritalStatus" value="Committed"><span>Committed</span>
				<input type="radio" name="maritalStatus" value="Married"><span>Married</span>
			</div>
			<span class="error"><?php echo $maritalStatusErr; ?></span>

			<input type="submit" name="login" value="Register" />

			<span>Already Registered User? <a href="index.php">Login</a></span>
		</form>
	</div>
</body>

</html>