<?php
include "header.php";

if (!isset($_SESSION)) {
    session_start();
}

$income_amount = "";
$income_description = "";

if(isset($_SESSION['id'])) {
	$id = $_SESSION['id'];
}

if(isset($_POST['addincome'])) {
	$income_amount = trim($_POST['income_amount']);
	$income_category = $_POST['income_category_name'];
	$income_date = $_POST['income_date'];
	$income_description = $_POST['income_description'];
	$income_date = date("Y-m-d", strtotime($income_date));
	
	$sql = "INSERT INTO income(id, income_amount, i_category_id, income_date, income_description) VALUES(:id,:income_amount, :i_category_id, :income_date, :income_description)";
	$data = array(":id"=>$id, ":income_amount"=>$income_amount, ":i_category_id"=>$income_category, ":income_date"=>$income_date, ":income_description"=>$income_description);
	$result = $conn->prepare($sql);
	$result->execute($data);
	echo "<script> location.replace('add_income.php?mode=inserted')</script>";
}
?>

<html>
<head>
<title>Add Income</title>
</head>
<body>
<div class = "main-wrapper">
<div class = "page-wrapper">
	<div class = "page-content">
	<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add Income</li>
    </ol>
	</nav>
		<div class="row">
			<div class="col-md-12 grid-margin stretch-card">
				<div class="card">
					<div class="card-body">
					<?php    
                if (isset($_GET['mode']) && $_GET['mode'] == 'set') { ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Income of this Month is already set</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
                </div>
            <?php } ?>
					<?php if (isset($_GET['mode']) && $_GET['mode'] == 'inserted') { ?>
						<div class="alert alert-success alert-dismissible fade show" role="alert">
						<strong>Income Added</strong>
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
						</div>
					<?php } ?>
						<h6 class="card-title">Add Income</h6>
							<form class="forms-sample" action="" method = "POST">
								<div class="row mb-3">
									<label for="incamt" class="col-sm-3 col-form-label">Income Amount *</label>
									<div class="col-sm-9">
										<input type="number" class="form-control" id="income_amount" placeholder="Income Amount" name = "income_amount" required>
										</div>
									</div>
									<div class = "row mb-3">
										<label for = "incdate" class="col-sm-3 col-form-label">Income Date *</label>
										<div class = "col-sm-9">
										<div class="input-group flatpickr" id="flatpickr-date">
												<input type="date" class="form-control" placeholder="Select date" name = "income_date" value = "<?php echo date("Y-m-d"); ?>" required data-input>
												<span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
											</div>
										</div>
									</div>
									<div class="row mb-3">
										<label for="inccategory" class="col-sm-3 col-form-label">Income Category *</label>
										<div class = "col-sm-9">
										<select class="form-select" id="income_category_name" name="income_category_name" required> 
											<option selected value="" required>Select your Income:</option>
											<?php
											$sql = "SELECT * FROM incomecategory WHERE id = $id";
											$result = $conn->query($sql);
											$result = $result->fetchAll(PDO::FETCH_OBJ);
											$row = count($result);
											if($row > 0) {
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
									<div class="row mb-3">
										<label for="incdesc" class="col-sm-3 col-form-label">Income Description*</label>
										<div class="col-sm-9">
										<textarea class="form-control" rows = "3" id="income_description" name = "income_description" placeholder = "e.g. Tech Blog, Giving Free Tution, etc." required></textarea>
										</div>
									</div>
									<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin" style="margin-bottom:-10px; margin-top: 30px;">
						<div>
							<button type="submit" class="btn btn-primary me-2" name = "addincome">Submit</button>
							<a href = "dashboard.php" class="btn btn-danger">Cancel</a>          
						</div>
          <div class="d-flex align-items-center flex-wrap text-nowrap">
              <button type="button" class="btn btn-secondary" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="left" data-bs-content="Enter Income Category from Add Income Category if not exist">I can't find my Income category?</button>
          </div>
        </div>
								</form>
							</div>
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