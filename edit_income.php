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
if(isset($_POST['editincome'])) {
	$income_amount = $_POST['income_amount'];
	$i_category_id = $_POST['i_category_id'];
	$income_date = $_POST['income_date'];
	$income_date = date("Y-m-d", strtotime($income_date));
	$income_description = $_POST['income_description'];
	
	if ((isset($_GET['income_id'])) && ($_GET['income_id'] !== "")) {
        $income_id = $_GET["income_id"];
	
		$sql = "UPDATE income SET income_amount = '$income_amount', i_category_id = '$i_category_id', income_date = '$income_date', income_description = '$income_description' WHERE income_id = '$income_id'";
		$conn->exec($sql);
		echo "<script> location.replace('manage_income.php?mode=inserted')</script>";
	}
}

if ((isset($_GET['income_id'])) && ($_GET['income_id'] !== "")) {
    $income_id = $_GET["income_id"];
    $sql = "SELECT * FROM income i JOIN incomecategory ic ON i.i_category_id = ic.i_category_id where i.income_id = :income_id";
    $data = array(':income_id' => $income_id);

    $result = $conn->prepare($sql);
    $result->execute($data);
    $result = $result->fetchAll(PDO::FETCH_OBJ);
    $row = count($result);
    if ($row > 0) {
        foreach ($result as $rs) {
            $income_id = $rs->income_id;
			$income_amount = $rs->income_amount;
			$i_category_id = $rs->i_category_id;
			$i_category_name = $rs->i_category_name;
			$income_date = $rs->income_date;
			$income_description = $rs->income_description;
        }
    }
}

?>


<html>
<head>
<title>Edit Income</title>

</head>
<body>
<div class = "main-wrapper">
<div class = "page-wrapper">
	<div class = "page-content">
	<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Income</li>
    </ol>
	</nav>
		<div class="row">
			<div class="col-md-12 grid-margin stretch-card">
				<div class="card">
					<div class="card-body">
						<h6 class="card-title">Edit Expense</h6>
							<form class="forms-sample" action="" method="POST">
								<div class="row mb-3">
									<label for="income_amount" class="col-sm-3 col-form-label">Income Amount</label>
									<div class="col-sm-9">
										<input type="number" class="form-control" required id="income_amount" placeholder="Income Amount" name = "income_amount" value="<?php echo $income_amount;?>">
										</div>
									</div>
									<div class="row mb-3">
										<label for="expcategory" class="col-sm-3 col-form-label">Expense Category</label>
										<div class = "col-sm-9">
										<select class="form-select" id="i_category_id" name="i_category_id" required value="<?php echo $i_category_name;?>"> 
											<option selected value="<?php echo $i_category_id; ?>" required><?php echo $i_category_name;?></option>
											<?php
											$sql = "SELECT * FROM incomecategory WHERE id = $id";
											$result = $conn->query($sql);
											$result = $result->fetchAll(PDO::FETCH_OBJ);
											$row = count($result);
											if($row > 0) {
												foreach($result as $rs) {
													$i_category_id = $rs->i_category_id;
													$i_category_name = $rs->i_category_name;
											?>
											<option value = "<?php echo $i_category_id; ?>"><?php echo $i_category_name; ?></option>
											<?php }} $conn = null; ?>
											
										</select>
										</div>
									</div>
									
									<div class = "row mb-3">
										<label for = "incdate" class="col-sm-3 col-form-label">Income Date *</label>
										<div class = "col-sm-9">
										<div class="input-group flatpickr" id="flatpickr-date">
												<input type="date" class="form-control" placeholder="Select date" name = "income_date" value = <?php echo $income_date; ?> data-input>
												<span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
											</div>
										</div>
									</div>
									<div class="row mb-3">
										<label for="incdesc" class="col-sm-3 col-form-label">Income Description</label>
										<div class="col-sm-9">
										<textarea class="form-control" rows = "3" id="income_description" name = "income_description" placeholder = "Income Description" required><?php echo $income_description;?></textarea>
										</div>
									</div>
									
									<button type="submit" class="btn btn-primary me-2" name = "editincome"><i class="ms-2  me-2 icon-md" data-feather="edit-3"></i></button>
									<a href="manage_income.php" class="btn btn-light me-2"><i class="ms-2  me-2 icon-md" data-feather="arrow-left"></i></a>
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