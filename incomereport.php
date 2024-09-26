<?php
include "header.php";

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
}
?>

<html>
	<head>
		<title>Income Report</title>
	</head>
	<body>
		<div class = "main-wrapper">
		<div class = "page-wrapper">
			<div class = "page-content">
			<nav class="page-breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
				<li class="breadcrumb-item active" aria-current="page">Income Report</li>
			</ol>
			</nav>
				<!--<div class = "row">
					<div class = "col-md-12 grid-margin stretch-card">
						<div class = "card">
							<div class = "card-body">
								<h6 class = "card-title">Day Wise Report</h6>
								<form class = "forms-sample" action = "">
									<div class="row">
											<div class="col-sm-3">
												<div class="mb-3">
													<label class="form-label">Start Date</label>
													<input type="date" class="form-control" name = "sdate">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="mb-3">
													<label class="form-label">End Date</label>
													<input type="date" class="form-control" name = "edate">
												</div>
											</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>-->
			<div class="row">
				<div class="col-md-12 grid-margin stretch-card">
					<div class="card">
						<div class="card-body">
							<h6 class="card-title">Income Report</h6>
							<?php if (isset($_GET['mode']) && $_GET['mode'] == 'notfound') { ?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<strong>Report not generated for given date</strong>
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
						</div>
					<?php } ?>
								<form class="forms-sample" action="income_report.php" method="POST">
								<div class = "row">
									<div class = "col-sm-4">
										<div class = "mb-3">
										<div class = "mt-1 mb-1">Start Date:</div>
											<div class="input-group flatpickr" id="flatpickr-date">
												<input type="date" class="form-control" placeholder="Select date" name = "startdate" data-input>
												<span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
											</div>
										</div>
									</div>
									<div class = "col-sm-4">
										<div class = "mb-3">
											<div class = "mt-1 mb-1">End Date:</div>
											<div class="input-group flatpickr" id="flatpickr-date">
												<input type="date" class="form-control" placeholder="Select date" name = "enddate" data-input>
												<span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
											</div>
										</div>
									</div>
									<div class = "col-sm-4">
										<div class = "mb-3">
											<div class = "mt-1 mb-1">Income Category</div>
											<select class = "form-select" id = "income_category_name" name = "income_category_name">
												<option selected value = "none" required>Select your Income Category:</option>
												<?php
												$sql = "SELECT * FROM incomecategory WHERE id = $id";
												$result = $conn->query($sql);
												$result = $result->fetchAll(PDO::FETCH_OBJ);
												$row = count($result);
												if($row>0) {
													foreach($result as $rs) {
														$id = $rs->id;
														$i_category_id = $rs->i_category_id;
														$i_category_name = $rs->i_category_name;
												?>
												<option value = "<?php echo $i_category_id; ?>"><?php echo $i_category_name; ?></option>
												<?php }} $conn = null; ?>
												</select>
										</div>
									</div>
								</div>
								<button type="submit" name="submit" class="btn btn-primary me-2">Submit</button>
								</form>
						
					</div>
				</div>
			</div>
			</div>		
							
							
			<footer class="footer border-top fixed-bottom">
        <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between py-3 small" style="background-color: #F9FAFB;">
          <p class="text-muted mb-1 mb-md-0">Copyright © 2022 <a href="https://www.nobleui.com" target="_blank">NobleUI</a>.</p>
          <p class="text-muted">Handcrafted With <i class="mb-1 text-primary ms-1 icon-sm" data-feather="heart"></i></p>
        </div>
			</footer>
		</div>
		</div>
	</body>
</html>

