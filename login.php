<?php
include "config.php";
include "swal.php";

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['user_name']) || isset($_COOKIE['member_login'])) {

    if (isset($_COOKIE['member_login'])) {
        $_SESSION["user_email"] =$_COOKIE["member_login"] ;
        $_SESSION["user_name"] =  $_COOKIE["user_name"];
        $_SESSION["id"] = $_COOKIE["id"];
    }
    header("location:dashboard.php");
}

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = md5($_POST['password']);
	
    if (isset($_POST['rememberme'])) {
        $rememberme = 1;
    } else {
        $rememberme = 0;
    }

    $sql = "SELECT * FROM user WHERE email = :email AND password = :password";

    $data = array(":email" => $email, ":password" => $password);

    $result = $conn->prepare($sql);
    $result->execute($data);
    $result = $result->fetchAll(PDO::FETCH_OBJ);
    $row = count($result);

    if ($row === 1) {
        foreach ($result as $r) {
            $u_email = $r->email;
            $u_name = $r->name;
            $u_password = $r->password;
            $id = $r->id;
			$u_image = $r->image;

            if ($u_email == $email && $u_password == $password) {
                if ($rememberme == 1) {
                    setcookie("member_login", $email, time() + (86400 * 30));
                    setcookie("id", $id, time() + (86400 * 30));
                    setcookie("user_name", $u_name, time() + (86400 * 30));
                }

                $sqlupdate = 'UPDATE user set last_login = now() where id = :id';
                $preparedStatement = $conn->prepare($sqlupdate);
                $preparedStatement->execute(array(':id' => $id));

                $_SESSION["user_email"] = $u_email;
                $_SESSION["user_name"] = $u_name;
                $_SESSION["id"] = $id;
				$_SESSION["image"] = $u_image;
				
				?>
				<script>var nametest = "<?php echo $u_name; ?>"</script>
				<?php



                //$redirect = "dashboard.php";
                echo '<script>swal({
  title: "Welcome Back "+nametest,
  text: "to Expense Tracker",
  button: false,
  icon: "success",
  timer: 2000
  }).then(function() {
	window.location = "dashboard.php";
  })</script>';
            } else {
                echo "<script>window.alert('Invalid Credentials')</script>";
            }
        }
    } elseif($_POST["email"] == '' && $_POST["password"] == '') {
		echo '<script>swal({
    position: "top-end",
    icon: "error",
  title: "Hey...",
  text: "Enter Something!",
  button: false,
    timer: 2000
  })</script>';
	}else {
                echo '<script>swal({
    position: "top-end",
    icon: "error",
  title: "Oops...",
  text: "Invalid Credentials!",
  button: false,
    timer: 2000
  })</script>';
            }
}
?>

<?php
/*
include "config.php";

if(!isset($_SESSION)) {
	session_start();
}

if(isset($_POST['login'])) {
	$email = $_POST['email'];
	$password = md5($_POST['password']);
	$sql = "SELECT * FROM user WHERE email = :email AND password = :password";
	$data = array(":email"=>$email, ":password"=>$password);
	
	$result = $conn->prepare($sql);
    $result->execute($data);
    $result = $result->fetchAll(PDO::FETCH_OBJ);
    $row = count($result);
	
	if($row === 1) {
		foreach($result as $r) {
			$u_email = $r->email;
			$u_password = $r->password;
			$u_id = $r->id;
			
			if($u_email == $email && $u_password == $password) {
				$sqlupdate = 'UPDATE user SET last_modified = now() WHERE id = :u_id';
				$preparedStatement = $conn->prepare($sqlupdate);
                $preparedStatement->execute(array(':u_id' => $u_id));
				
				$_SESSION["user_email"] = $u_email;
				
				$redirect = "dashboard.php";
				header("location: $redirect");
			} else {
				echo "invalid credentials";
			}
			
		}
	}
}*/
?>
<!DOCTYPE html>
<!--
Template Name: NobleUI - HTML Bootstrap 5 Admin Dashboard Template
Author: NobleUI
Website: https://www.nobleui.com
Portfolio: https://themeforest.net/user/nobleui/portfolio
Contact: nobleui123@gmail.com
Purchase: https://1.envato.market/nobleui_admin
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="Responsive HTML Admin Dashboard Template based on Bootstrap 5">
	<meta name="author" content="NobleUI">
	<meta name="keywords" content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<title>NobleUI - HTML Bootstrap 5 Admin Dashboard Template</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
  <!-- End fonts -->

	<!-- core:css -->
	<link rel="stylesheet" href="/assets/vendors/core/core.css">
	<!-- endinject -->

	<!-- Plugin css for this page -->
	<!-- End plugin css for this page -->

	<!-- inject:css -->
	<link rel="stylesheet" href="assets/fonts/feather-font/css/iconfont.css">
	<link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css">
	<!-- endinject -->

  <!-- Layout styles -->  
	<link rel="stylesheet" href="assets/css/demo3/style.css">
  <!-- End layout styles -->
<link rel="icon" type="image/x-icon" href="https://cdn-icons-png.flaticon.com/512/1490/1490817.png">
  <style>
 
  </style>
</head>
<body>
	<div class="main-wrapper">
		<div class="page-wrapper full-page">
			<div class="page-content d-flex align-items-center justify-content-center">

				<div class="row w-100 mx-0 auth-page">
					<div class="col-md-8 col-xl-6 mx-auto">
						<div class="card">
							<div class="row">
                <div class="col-md-4 pe-md-0">
                  <div class="auth-side-wrapper" style = "background-image: url('expense.jpg'); background-size:cover;">
					
                  </div>
                </div>
                <div class="col-md-8 ps-md-0">
                  <div class="auth-form-wrapper px-4 py-5 bc">
                    <a href="#" class="noble-ui-logo d-block mb-2">Expense<span>Tracker</span></a>
                    <h5 class="text-muted fw-normal mb-4">Welcome back! Log in to your account.</h5>
                    <form class="forms-sample" method="POST" action="">
                      <div class="mb-3">
                        <label for="Email" class="form-label">Email</label>
                        <input class="form-control" id="email" placeholder="Enter Email" name="email" data-inputmask="'alias': 'email'" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" title="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
                      </div>
                      <div class="mb-3">
                        <label for="Password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="Password" placeholder="Enter Password" name = "password">
                      </div>
					  <div class="form-check form-check-flat form-check-primary mb-3">
                               <label class="form-check-label">
                              <input type="checkbox" class="form-check-input" value="1" name="rememberme">
                                     Remember me
                                  </label>
                        </div>
                      <div>
                        <input type = "submit"	class="btn btn-primary me-2 mb-2 mb-md-0 text-white" name="login" value="Login">
                      </div>
                      <a href="forgot_password.php" class="d-block mt-3 text-muted">Forgot Password?</a>
                      <a href="register.php" class="d-block text-muted">Not a user? Sign up</a>
                    </form>
                  </div>
                </div>
              </div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>

	<!-- core:js -->
	<script src="assets/vendors/core/core.js"></script>
	<!-- endinject -->

	<!-- Plugin js for this page -->
	<!-- End plugin js for this page -->

	<!-- inject:js -->
	<script src="assets/vendors/feather-icons/feather.min.js"></script>
	<script src="assets/js/template.js"></script>
	<script src="assets/vendors/inputmask/jquery.inputmask.min.js"></script>
	<script src="assets/js/inputmask.js"></script>
	<!-- endinject -->

	<!-- Custom js for this page -->
	<!-- End custom js for this page -->

</body>
</html>