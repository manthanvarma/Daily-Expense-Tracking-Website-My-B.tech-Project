<?php
include "config.php";

session_start();


if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
} else { header ("location: login.php"); }



    $user_email = $_SESSION['user_email'];
	$user_name = $_SESSION['user_name'];
	$id = $_SESSION['id'];
	
	/*$u_image = $_SESSION['image'];*/

	$sql = "SELECT * FROM user WHERE id = :id";
	$data = array(":id"=>$id);
	$result= $conn->prepare($sql);
	$result->execute($data);
	$result = $result->fetchAll(PDO::FETCH_OBJ);
	$row = count($result);
	if($row === 1) {
		foreach($result as $r) {
			$image = $r->image;
			$name = $r->name;
			$email = $r->email;
			
		}
	}


?>

<html>
<head>

<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="Responsive HTML Admin Dashboard Template based on Bootstrap 5">
	<meta name="author" content="NobleUI">
	<meta name="keywords" content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<title>NobleUI - HTML Bootstrap 5 Admin Dashboard Template</title>

  <!-- Fonts -->
   <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
		<script src="jquery-3.3.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
  <!-- End fonts -->
  <link rel="icon" type="image/x-icon" href="https://cdn-icons-png.flaticon.com/512/1490/1490817.png">

	<!-- core:css -->
	<link rel="stylesheet" href="assets/vendors/core/core.css">
	<!-- endinject -->

	<!-- Plugin css for this page -->
	<link rel="stylesheet" href="assets/vendors/flatpickr/flatpickr.min.css">
	<!-- End plugin css for this page -->
	<link rel="stylesheet" href="assets/vendors/owl.carousel/owl.carousel.min.css">
  <link rel="stylesheet" href="assets/vendors/owl.carousel/owl.theme.default.min.css">
	<!-- inject:css -->
	<link rel="stylesheet" href="assets/fonts/feather-font/css/iconfont.css">
	<link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css">
	<link rel="stylesheet" href="assets/vendors/apexcharts/apexcharts.min.js">
	<!-- endinject -->

  <!-- Layout styles -->  
	<link rel="stylesheet" href="assets/css/demo3/style.css">


  <!-- End layout styles -->
  <style>
  .imgb {
	border: 3px solid #6571ff;
  }
  </style>
</head>
<body>
<div class="horizontal-menu">
			<nav class="navbar top-navbar">
				<div class="container">
					<div class="navbar-content">
						<a href="#" class="navbar-brand">
							Expense<span>Tracker</span>
						</a>
                        
						<ul class="navbar-nav">
              <li class="nav-item dropdown">
                
                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <img class="wd-30 ht-30 rounded-circle imga" src="uploads/<?php echo $image ?>" alt="" onerror = "this.src='ab.jpg'">
                </a>
                <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                  <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                    
                    <div class="mb-3">
                      <img class="wd-80 ht-80 rounded-circle imgb" src="uploads/<?php echo $image ?>" alt="Not Found" onerror = "this.src='ab.jpg'">
                    </div>
                    <div class="text-center">
                      <p class="tx-16 fw-bolder"><?php echo $name ?></p>
                      <p class="tx-12 text-muted"><?php echo $email ?></p>
                    </div>
                  </div>
                  <ul class="list-unstyled p-1">
					
					<a href="edit_profile.php" class="text-body ms-0">
					<li class="dropdown-item py-2">
                    <i class="me-2 icon-md" data-feather="tool"></i>
                    <span>Edit Profile</span>
					</li>
                    </a>
                   
					<a href="logout.php" class="text-body ms-0">
					<li class="dropdown-item py-2">
                    <i class="me-2 icon-md" data-feather="log-out"></i>
                    <span>Log Out</span>
					</li>
                    </a>
                  </ul>
                </div>
              </li>
						</ul>
						<button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
							<i data-feather="menu"></i>					
						</button>
					</div>
				</div>
			</nav>
            
			<nav class="bottom-navbar">
				<div class="container">
					<ul class="nav page-navigation">
						<li class="nav-item">
							<a class="nav-link" href="dashboard.php">
								<i class="link-icon" data-feather="box"></i>
								<span class="menu-title">Dashboard</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="link-icon" data-feather="shopping-bag"></i>
								<span class="menu-title">Category</span>
								<i class="link-arrow"></i>
							</a>
							<div class="submenu">
								<ul class="submenu-item">
									<li class="nav-item"><a class="nav-link" href="add_category.php">Add Category</a></li>
									<li class="nav-item"><a class="nav-link" href="manage_category.php">Manage Category</a></li>
								</ul>
							</div>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="link-icon" data-feather="shopping-cart"></i>
								<span class="menu-title">Expenses</span>
								<i class="link-arrow"></i>
							</a>
							<div class="submenu">
								<ul class="submenu-item">
									<li class="nav-item"><a class="nav-link" href="add_expense.php">Add Expense</a></li>
									<li class="nav-item"><a class="nav-link" href="manage_expense.php">Manage Expense</a></li>
								</ul>
							</div>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="link-icon" data-feather="dollar-sign"></i>
								<span class="menu-title">Income</span>
								<i class="link-arrow"></i>
							</a>
							<div class="submenu">
								<ul class="submenu-item">
									<li class="nav-item"><a class="nav-link" href="add_income.php">Add Income</a></li>
									<li class="nav-item"><a class="nav-link" href="manage_income.php">Manage Income</a></li>
									<li class="nav-item"><a class="nav-link" href="add_income_category.php">Add Income Category</a></li>
									<li class="nav-item"><a class="nav-link" href="manage_income_category.php">Manage Income Category</a></li>
								</ul>
							</div>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="link-icon" data-feather="book"></i>
								<span class="menu-title">Report</span>
								<i class="link-arrow"></i>
							</a>
							<div class="submenu">
								<ul class="submenu-item">
									<li class="nav-item"><a class="nav-link" href="expensereport.php">Expense Report</a></li>
									<li class="nav-item"><a class="nav-link" href="incomereport.php">Income Report</a></li>
									<li class="nav-item"><a class="nav-link" href="combinedreport.php">Combined Report</a></li>
								</ul>
							</div>
						</li>
						
					</ul>
				</div>
			</nav>
		</div>
        
	<!-- core:js -->
	<script src="../assets/vendors/core/core.js"></script>
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
	<!-- endinjec -->

	<!-- Custom js for this page -->
	<script src="assets/js/form-validation.js"></script>
	<script src="assets/js/bootstrap-maxlength.js"></script>
	<script src="assets/js/inputmask.js"></script>
	<script src="assets/js/select2.js"></script>
	<script src="assets/js/typeahead.js"></script>
	<script src="assets/js/tags-input.js"></script>
	<script src="assets/js/dropzone.js"></script>
	<script src="assets/js/dropify.js"></script>
	<script src="assets/js/flatpickr.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
	<script src="assets/js/dashboard-light.js"></script>
	<script src="assets/vendors/owl.carousel/owl.carousel.min.js"></script>
	<script src="assets/vendors/jquery-mousewheel/jquery.mousewheel.js"></script>
	<script src="assets/js/carousel.js"></script>
		</body>
		</html>