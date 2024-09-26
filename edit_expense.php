<?php
include "header.php";
extract($_POST);
?>

<?php
if(!isset($_SESSION['user_email']))
{
	header("location: login.php");
	 
	exit();
}

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
}
?>

<?php
if(isset($_POST['editexpense'])) {
	$expense_amount_name = trim($_POST['expense_amount']);
	$expense_date = $_POST['expense_date'];
	$category_id = $_POST['category_id'];
	$expense_description = trim($_POST['expense_description']);
	$expense_date = date("Y-m-d", strtotime($expense_date));
	
	if ((isset($_GET['expense_id'])) && ($_GET['expense_id'] !== "")) {
        $expense_id = $_GET["expense_id"];
	
		$sql = "UPDATE expense SET expense_amount = '$expense_amount', expense_date = '$expense_date', category_id = '$category_id', expense_description = '$expense_description',expense_modify_date=now() WHERE expense_id = '$expense_id'";
		$conn->exec($sql);
		echo "<script>location.replace('manage_expense.php?mode=edited')</script>";
	}
}

if ((isset($_GET['expense_id'])) && ($_GET['expense_id'] !== "")) {
    $expense_id = $_GET["expense_id"];
    $sql = "SELECT * FROM expense e JOIN category c ON e.category_id = c.category_id WHERE e.expense_id = :expense_id";
    $data = array(':expense_id' => $expense_id);

    $result = $conn->prepare($sql);
    $result->execute($data);
    $result = $result->fetchAll(PDO::FETCH_OBJ);
    $row = count($result);
    if ($row > 0) {
        foreach ($result as $rs) {
            $expense_id = $rs->expense_id;
			$expense_amount = $rs->expense_amount;
            $expense_date = $rs->expense_date;
			$category_id = $rs->category_id;
			$category_name = $rs->category_name;
			$expense_description = $rs->expense_description;
			$date = date("Y-m-d",strtotime($expense_date));
        }
    }
}

?>


<html>
<head>
<title>Edit Expense</title>
<script>
var date = $date;
$j(document).ready(function() {
	flatpickr('#expense_date', {
		"dateFormat":"Y-m-d",
		defaultDate: date
	});
});
</script>
</head>
<body>
<div class = "main-wrapper">
<div class = "page-wrapper">
	<div class = "page-content">
	<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Expense</li>
    </ol>
	</nav>
		<div class="row">
			<div class="col-md-12 grid-margin stretch-card">
				<div class="card">
					<div class="card-body">
						<h6 class="card-title">Edit Expense</h6>
							<form class="forms-sample" action="" method="POST">
								<div class="row mb-3">
									<label for="expamt" class="col-sm-3 col-form-label">Expense Amount</label>
									<div class="col-sm-9">
										<input type="number" class="form-control" id="expense_amount" placeholder="Expense Amount" name = "expense_amount" value="<?php echo $expense_amount;?>">
										</div>
									</div>
									<div class = "row mb-3">
										<label for = "expdate" class="col-sm-3 col-form-label">Expense Date</label>
										<div class = "col-sm-9">
										<div class="input-group flatpickr" id="flatpickr-date">
											<input type="date" class="form-control" placeholder="Select date" name = "expense_date" value = "<?php echo $expense_date; ?>" data-input>
											<span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
										</div>
										</div>
									</div>
									<div class="row mb-3">
										<label for="expcategory" class="col-sm-3 col-form-label">Expense Category</label>
										<div class = "col-sm-9">
										<select class="form-select" id="category_id" name="category_id" required value="<?php echo $category_name;?>"> 
											<option selected value="<?php echo $category_id; ?>" required><?php echo $category_name; ?></option>
											<?php
											$sql = "SELECT * FROM category WHERE id = $id";
											$result = $conn->query($sql);
											$result = $result->fetchAll(PDO::FETCH_OBJ);
											$row = count($result);
											if($row > 0) {
												foreach($result as $rs) {
													$category_id = $rs->category_id;
													$category_name = $rs->category_name;
											?>
											<option value = "<?php echo $category_id; ?>"><?php echo $category_name; ?></option>
											<?php }} $conn = null; ?>
											<option value = "Utilities">Utilities</option>
										</select>
										</div>
									</div>
									<div class="row mb-3">
										<label for="expdesc" class="col-sm-3 col-form-label">Expense Description</label>
										<div class="col-sm-9">
										<textarea class="form-control" rows = "3" id="expense_description" name = "expense_description" placeholder = "Expense Description" required><?php echo $expense_description;?></textarea>
										</div>
									</div>
									
									<button type="submit" class="btn btn-primary me-2" name = "editexpense"><i class="ms-2  me-2 icon-md" data-feather="edit-3"></i></button>
									<a href="manage_expense.php" class="btn btn-light me-2"><i class="ms-2  me-2 icon-md" data-feather="arrow-left"></i></a>
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