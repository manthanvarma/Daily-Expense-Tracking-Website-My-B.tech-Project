<?php
extract($_POST);
include "config.php";
include "swal.php";
include "partials/_navbar.php";

if (!isset($_SESSION)) {
    session_start();
}

$name = "";
$email = "";
$password = "";
$statusMsg = '';

if (isset($_SESSION['user_email'])) {
    $user_email = $_SESSION['user_email'];
	
} else { header ("location: login.php"); }

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
	$sql = "SELECT * FROM user where id = :id";
    $data = array(':id' => $id);

    $result = $conn->prepare($sql);
    $result->execute($data);
    $result = $result->fetchAll(PDO::FETCH_OBJ);
    $row = count($result);
    if ($row > 0) {
        foreach ($result as $row) {
            $name = $row->name;
            $email = $row->email;
			$image2 = $row->image;
        }
    }
} else { header ("location: login.php"); }


if(isset($_POST['editprofile']) && !empty($_FILES["image1"]["name"])){

    $targetDir = "uploads/";
    $fileName = basename($_FILES["image1"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

    $name=$_POST['name'];
    $email=$_POST['email'];
	
	$sql = "SELECT * FROM user WHERE email = :email AND id != $id";
	$data = array(":email"=>$email);
	
	$result = $conn->prepare($sql);
	$result->execute($data);
    $result = $result->fetchAll(PDO::FETCH_OBJ);
    $row = count($result);
	
	if ($row === 1) {
        foreach ($result as $r) {

            $u_email = $r->email;

            if ($u_email == $email) {
			echo "<script>location.replace('edit_profile.php?mode=Invalid')</script>";            } 
        }
    }
	else {
    
    $allowTypes = array('jpg','png','jpeg','gif','pdf');
    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["image1"]["tmp_name"], $targetFilePath)){
			
		if(isset($_SESSION['id'])) {
			 $id = $_SESSION['id'];
                $updateQuery = "UPDATE user SET name = '$name', email= '$email', image= '$fileName' WHERE id = $id";

                $conn->exec($updateQuery);
                echo '<script>swal({
  title: "Profile and Image Edited",
  text: " ",
  button: false,
  icon: "success",
  timer: 2000
  }).then(function() {
	window.location = "dashboard.php";
  })</script>';
		}}
        }
        else{$statusMsg="Error uploading image";}
    }
}
else if(isset($_POST['editprofile']))
{
	//echo "<script>window.alert('image not selected')</script>";
    $name=$_POST['name'];
    $email=$_POST['email'];
	
	$sql = "SELECT * FROM user WHERE email = :email AND id != $id";
	$data = array(":email"=>$email);
	
	$result = $conn->prepare($sql);
	$result->execute($data);
    $result = $result->fetchAll(PDO::FETCH_OBJ);
    $row = count($result);
	
	if ($row === 1) {
        foreach ($result as $r) {

            $u_email = $r->email;

            if ($u_email == $email) {
			echo "<script>location.replace('edit_profile.php?mode=Invalid')</script>";            } 
        }
    }
	else {

    $statusMsg="Image not Selected";
        $updateQuery = "UPDATE user SET name = '$name', email= '$email' WHERE id = $id";

        $conn->exec($updateQuery);
        echo '<script>swal({
  title: "Profile Edited",
  text: " ",
  button: false,
  icon: "success",
  timer: 2000
  }).then(function() {
	window.location = "dashboard.php";
  })</script>';
    }
}
?>

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
	<link rel="stylesheet" href="assets/vendors/core/core.css">
	<!-- endinject -->

	<!-- Plugin css for this page -->
	<link rel="stylesheet" href="assets/vendors/select2/select2.min.css">
	<link rel="stylesheet" href="assets/vendors/jquery-tags-input/jquery.tagsinput.min.css">
	<link rel="stylesheet" href="assets/vendors/dropzone/dropzone.min.css">
	<link rel="stylesheet" href="assets/vendors/dropify/dist/dropify.min.css">
	<link rel="stylesheet" href="assets/vendors/pickr/themes/classic.min.css">
	<link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/vendors/flatpickr/flatpickr.min.css">
	<!-- End plugin css for this page -->

	<!-- inject:css -->
	<link rel="stylesheet" href="assets/fonts/feather-font/css/iconfont.css">
	<link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css">
	<!-- endinject -->

  <!-- Layout styles -->  
	<link rel="stylesheet" href="assets/css/demo3/style.css">
  <!-- End layout styles -->

  <link rel="shortcut icon" href="assets/images/favicon.png" />
  <style>
	.bc {
		margin-top:-60px;
	}
  </style>
  
</head>
<body>
	<div class="main-wrapper" >
		<div class="page-wrapper full-page" >
			<div class="page-content d-flex align-items-center justify-content-center bc" >

				<div class="row w-100 mx-0 auth-page">
					<div class="col-md-8 col-xl-6 mx-auto">
						<div class="card" >
							<div class="row" >
                <div class="col-md-4 pe-md-0" >
                  <div class="auth-side-wrapper">
					<img src = "d (1).jpg">
                  </div>
                </div>
                <div class="col-md-8 ps-md-0">
                  <div class="auth-form-wrapper px-4 py-1 mt-3">
				  
                    <a href="#" class="noble-ui-logo d-block mb-0">Expense<span>Tracker</span></a>
                    <h5 class="text-muted fw-normal mb-3">Create a free account.</h5>
					<div class="error mx-0">
            <?php    
                if (isset($_GET['mode']) && $_GET['mode'] == 'Invalid') { ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Email already exists!</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
                </div>
            <?php } ?>
        </div>
                    <form class="forms-sample" method="POST" action ="" enctype="multipart/form-data">
                      <div class="mb-3 mt-3">
                        <label for="exampleInputUsername1" class="form-label">Username</label>
                        <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="Username" placeholder="Username" name="name" required value="<?php echo $name; ?>">
                      </div>
                      <div class="mb-3">
                        <label for="userEmail" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="userEmail" placeholder="Email" name="email" required value="<?php echo $email; ?>">
                      </div>
						<!--<div class="mb-3">
							<label for="img" class="form-label">Upload Image</label>
							<input type="file" class="form-control"  name="image1" id="image1">
						</div>-->					  
						<label for="userImage" class="form-label">Add a Profile Image</label>
						<input type="file" name="image1" id="myDropify" data-default-file="uploads/<?php echo $image2; ?>" />
                      <div>
                        <input type="submit" class="btn btn-primary text-white me-2 mt-3" name="editprofile" value="Submit">
						<button type = "button" class="btn btn-danger text-white me-2 mt-3" onclick="location.href='dashboard.php'">Cancel</button>
                      </div>
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

	<script src="assets/vendors/core/core.js"></script>
	<!-- endinject -->

	<!-- Plugin js for this page -->
	<script src="assets/vendors/jquery-validation/jquery.validate.min.js"></script>
	<script src="assets/vendors/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
	<script src="assets/vendors/inputmask/jquery.inputmask.min.js"></script>
	<script src="assets/vendors/select2/select2.min.js"></script>
	<script src="assets/vendors/typeahead.js/typeahead.bundle.min.js"></script>
	<script src="assets/vendors/jquery-tags-input/jquery.tagsinput.min.js"></script>
	<script src="assets/vendors/dropzone/dropzone.min.js"></script>
	<script src="assets/vendors/dropify/dist/dropify.min.js"></script>
	<script src="assets/vendors/pickr/pickr.min.js"></script>
	<script src="assets/vendors/moment/moment.min.js"></script>
	<script src="assets/vendors/flatpickr/flatpickr.min.js"></script>
	<!-- End plugin js for this page -->

	<!-- inject:js -->
	<script src="assets/vendors/feather-icons/feather.min.js"></script>
	<script src="assets/js/template.js"></script>
	<!-- endinject -->

	<!-- Custom js for this page -->
	<script src="assets/js/form-validation.js"></script>
	<script src="assets/js/bootstrap-maxlength.js"></script>
	<script src="assets/js/inputmask.js"></script>
	<script src="assets/js/select2.js"></script>
	<script src="assets/js/typeahead.js"></script>
	<script src="assets/js/tags-input.js"></script>
	<script src="assets/js/dropzone.js"></script>
	<script src="assets/js/dropify.js"></script>
	<script src="assets/js/pickr.js"></script>
	<script src="assets/js/flatpickr.js"></script>

</body>
</html>