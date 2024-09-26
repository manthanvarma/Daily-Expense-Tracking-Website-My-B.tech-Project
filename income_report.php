<?php

include "header.php";

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
}

if(isset($_POST['income_category_name']) && isset($_POST['submit'])) {
	$startdate = $_POST['startdate'];
    $enddate = $_POST['enddate'];
	$i_category_name = $_POST['income_category_name'];
	$startdate = date("Y-m-d", strtotime($startdate));
	$enddate = date("Y-m-d", strtotime($enddate));
	$startdatenew = date("d-M-y", strtotime($startdate));
	$enddatenew = date("d-M-y", strtotime($enddate));
	
	$sql = "SELECT * from user u JOIN income i on u.id = i.id JOIN incomecategory ic ON i.i_category_id = ic.i_category_id WHERE u.id = :id AND i.i_category_id = :i_category_name AND i.income_date BETWEEN :startdate AND :enddate ORDER BY i.income_date ASC";
	$data = array(":id"=>$id, ":i_category_name"=>$i_category_name, ":startdate"=>$startdate, ":enddate"=>$enddate);
    $result = $conn->prepare($sql);
    $result->execute($data);
    $result = $result->fetchAll(PDO::FETCH_OBJ);
    $row = count($result);
}

if(isset($_POST['income_category_name']) && $_POST['income_category_name'] == 'none' && isset($_POST['submit'])) {
	
		$startdate = $_POST['startdate'];
    $enddate = $_POST['enddate'];
	$startdate = date("Y-m-d", strtotime($startdate));
	$enddate = date("Y-m-d", strtotime($enddate));
	$startdatenew = date("d-M-y", strtotime($startdate));
	$enddatenew = date("d-M-y", strtotime($enddate));
	
	$sql = "SELECT * from user u JOIN income i on u.id = i.id JOIN incomecategory ic ON i.i_category_id = ic.i_category_id WHERE u.id = :id AND i.income_date BETWEEN :startdate AND :enddate ORDER BY i.income_date ASC";
	$data = array(":id"=>$id, ":startdate"=>$startdate, ":enddate"=>$enddate);
    $result = $conn->prepare($sql);
    $result->execute($data);
    $result = $result->fetchAll(PDO::FETCH_OBJ);
    $row = count($result);
}

?>
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
	<link rel="stylesheet" href="/assets/fonts/feather-font/css/iconfont.css">
	<link rel="stylesheet" href="/assets/vendors/flag-icon-css/css/flag-icon.min.css">
	<!-- endinject -->

  <!-- Layout styles -->  
	<link rel="stylesheet" href="/assets/css/demo3/style.css">
  <!-- End layout styles -->

  <link rel="shortcut icon" href="/assets/images/favicon.png" />
  <style>
	body.swal2-shown > [aria-hidden="true"] {
  transition: 0.1s filter;
  filter: blur(100px);
}
  </style>
</head>
<body>
	<div class="main-wrapper">

		<!-- partial:../../partials/_navbar.html -->
		
		<!-- partial -->
	
		<div class="page-wrapper">

			<div class="page-content">
			<script>
	// let timerInterval
      // Swal.fire({
        // title: 'Your Income Report is Being Generated!',
		// icon: 'success',
        // html: 'in <b></b> milliseconds.',
		// backdrop: true,
        // timer: 2000,
        // timerProgressBar: true,
        // didOpen: () => {
          // Swal.showLoading()
          // timerInterval = setInterval(() => {
            // const content = Swal.getHtmlContainer()
            // if (content) {
              // const b = content.querySelector('b')
              // if (b) {
                // b.textContent = Swal.getTimerLeft()
              // }
            // }
          // }, 100)
        // },
      // })</script>
				<nav class="page-breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="#">Dashboard</a></li>
						<li class="breadcrumb-item active" aria-current="page">Income Report</li>
					</ol>
				</nav>

				<div class="row">
					<div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <div class="container-fluid d-flex justify-content-between">
                  <div class="col-lg-3 ps-0">
                    <a href="#" class="noble-ui-logo d-block mt-3">Income<span>Report</span></a>                 
                    <p class="mb-1"><b>Report Generated From</b></p>
                    <p><?php echo $startdatenew; ?> To <?php echo $enddatenew; ?></p>
                  </div>
				  <?php 
					if($row>0) {
						$name = $r->name; 
						$email = $r->email;
						foreach($result as $rs){
							$income_amount = $rs->income_amount;
						}
						
						?>
                  <div class="col-lg-3 pe-0">
                    <h4 class="fw-bolder text-uppercase text-end mt-3"><?php echo $name; ?></h4>
                    <h6 class="text-end mb-1 mt-1"><?php echo $email; ?></h6>
                    <h6 class="text-end mb-1 mt-2">Report Generated Date: <?php echo "" . date("d/m/Y") . "<br>"; ?></h6>
                  </div>
                </div>
                <div class="container-fluid mt-2 d-flex justify-content-center w-100">
                  <div class="table-responsive w-100">
                      <table class="table table-bordered">
                        <thead>
                          <tr style="text-align:center;">
							<th>Index</th>
							<th>Income Date</th>
							<th>Income Category</th>
							<th>Income Description</th>
							<th>Income Amount (₹)</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
						$sum = 0;
						$index = 0;						
						foreach($result as $r) {
							
							$income_date = $r->income_date;
							$income_date1 = date("d-M-Y", strtotime($income_date));
							$i_category_name = $r->i_category_name;
							$income_description = $r->income_description;
							$income_amount = $r->income_amount;
							$sum += $income_amount;
							$index++;
							
							?>
							
							<tr style = "text-align:center;">
								<td><?php echo $index; ?></td>
								<td><?php echo $income_date1; ?></td>
								<td><?php echo $i_category_name; ?></td>
								<td><?php echo $income_description; ?></td>
								<td><?php echo $income_amount; ?></td>
							</tr>
							
							</tbody>
								<?php }}else {echo  '<script>location.replace("incomereport.php?mode=notfound")</script>'; } ?>
								<tbody>
								<td class = "text-center" colspan = "3"><b></b></td>
								<td class = "text-center bg-light"><b>Total Income</b></td>
								<td class = "text-center bg-light"><b>₹ <?php echo $sum ?></b></td>
								</tbody>
                      </table>
                    </div>
                </div>
                <div class="container-fluid mt-3 w-100">
                  <div class="row">
                    <div class="col-md-5 ms-auto">
                        <div class="table-responsive">
                          <table class="table">
                              <tbody>
                                <!--<tr class = "bg-light">
                                  <td>Total Expense</td>
                                  <td class="text-bold-800 text-center">₹ <?php echo $sum ?></td>
                                </tr>-->
                              </tbody>
                          </table>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="container-fluid w-100">
                  <a href="javascript:;" class="btn btn-primary float-end mt-4 ms-2"><i data-feather="send" class="me-3 icon-md"></i>Send Invoice</a>
                  <button onclick="window.print()" href="javascript:;" class="btn btn-outline-primary float-end mt-4"><i data-feather="printer" class="me-2 icon-md"></i>Print</button>
                </div>
              </div>
            </div>
					</div>
				</div>
			</div>

			<!-- partial:../../partials/_footer.html -->
			<footer class="footer border-top">
        <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between py-3 small">
          <p class="text-muted mb-1 mb-md-0">Copyright © 2022 <a href="https://www.nobleui.com" target="_blank">NobleUI</a>.</p>
          <p class="text-muted">Handcrafted With <i class="mb-1 text-primary ms-1 icon-sm" data-feather="heart"></i></p>
        </div>
			</footer>
			<!-- partial -->
	
		</div>
	</div>

	<!-- core:js -->
	<script src="../../../assets/vendors/core/core.js"></script>
	<!-- endinject -->

	<!-- Plugin js for this page -->
	<!-- End plugin js for this page -->

	<!-- inject:js -->
	<script src="../../../assets/vendors/feather-icons/feather.min.js"></script>
	<script src="../../../assets/js/template.js"></script>
	<!-- endinject -->

	<!-- Custom js for this page -->
	<!-- End custom js for this page -->

</body>
</html>