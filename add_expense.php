<?php
include "header.php";

if (!isset($_SESSION)) {
    session_start();
}

$expense_amt = "";
$expense_date = "";
$category_name = "";
$expense_description = "";

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
}

if(isset($_POST['addexpense'])) {
	
	$expense_amount = trim($_POST['expense_amount']);
	$expense_date = $_POST['expense_date'];
	$category_name = $_POST['category_name'];
	$expense_description = trim($_POST['expense_description']);
	$expense_date = date("Y-m-d", strtotime($expense_date));
	
	$sql = "INSERT INTO expense(id, expense_amount, expense_date, category_id, expense_description) VALUES(:id, :expense_amount, :expense_date, :category_name, :expense_description)";
	
	$data = array(":id"=>$id,":expense_amount"=>$expense_amount, ":expense_date"=>$expense_date, ":category_name"=>$category_name, ":expense_description"=>$expense_description);
	
	$result=$conn->prepare($sql);
	$result->execute($data);
	echo "<script> location.replace('add_expense.php?mode=inserted')</script>";
}
?>

<html>
<head>
<title>Add Expense</title>
</head>
<body>
<div class = "main-wrapper">
	<div class = "page-wrapper">
	<div class = "page-content">
	<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add Expense</li>
    </ol>
	</nav>
		<div class="row">
			<div class="col-md-12 grid-margin stretch-card">
				<div class="card">
					<div class="card-body">
					<?php if (isset($_GET['mode']) && $_GET['mode'] == 'inserted') { ?>
						<div class="alert alert-success alert-dismissible fade show" role="alert">
						<strong>Expense Added</strong>
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
						</div>
					<?php } ?>
						<h6 class="card-title">Add Expense</h6>
							<form class="forms-sample" action="" method="POST">
								<div class="row mb-3">
									<label for="expamt" class="col-sm-3 col-form-label">Expense Amount *</label>
									<div class="col-sm-9">
										<input type="number" class="form-control" id="expense_amount" placeholder="Expense Amount in Rs." name = "expense_amount" required>
										</div>
									</div>
									<div class = "row mb-3">
										<label for = "expdate" class="col-sm-3 col-form-label">Expense Date *</label>
										<div class = "col-sm-9">
										<div class="input-group flatpickr" id="flatpickr-date">
											<input type="date" class="form-control" placeholder="Select date" value = "<?php echo date("Y-m-d"); ?>" name = "expense_date" required data-input>
											<span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
										</div>
										</div>
									</div>
									<div class="row mb-3">
										<label for="expcategory" class="col-sm-3 col-form-label">Expense Category *</label>
										<div class = "col-sm-9">
										<select class="form-select" id="category_name" name="category_name" required oninvalid="setCustomValidity('Enter Category from Add Category if not exist else Select from here')" oninput="setCustomValidity('')" /> 
											<option selected value="" required>Select your Category</option>
											<?php
											$sql = "SELECT * FROM category WHERE id = $id OR id = 0";
											$result = $conn->query($sql);
											$result = $result->fetchAll(PDO::FETCH_OBJ);
											$row = count($result);
											if($row > 0) {
												foreach($result as $rs) {
													$id = $rs->id;
													$category_id = $rs->category_id;
													$category_name = $rs->category_name;
											?>
											<option value = "<?php echo $category_id; ?>"><?php echo $category_name; ?></option>
											<?php }} $conn = null; ?>
										</select>
										</div>
									</div>
									<div class="row mb-3">
										<label for="expdesc" class="col-sm-3 col-form-label">Expense Description*</label>
										<div class="col-sm-9">
										<textarea class="form-control" rows = "3" id="expense_description" name = "expense_description" placeholder = "e.g. Item Name, Trip to Goa, etc." required></textarea>
										</div>
									</div>
						<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin" style="margin-bottom:-10px; margin-top: 30px;">
						<div>
							<button type="submit" class="btn btn-primary me-2" name = "addexpense">Submit</button>
							<a href = "dashboard.php" class="btn btn-danger">Cancel</a>          
						</div>
          <div class="d-flex align-items-center flex-wrap text-nowrap">
              <button type="button" class="btn btn-secondary" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="left" data-bs-content="Enter Category from Add Category if not exist">I can't find my category?</button>
          </div>
        </div>
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
	</div>
</body>
</html>