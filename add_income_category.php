<?php
include "header.php";

if (!isset($_SESSION)) {
    session_start();
}

$i_category_name = "";



if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
}

if(isset($_POST['addincomecategory'])) {
	
	$i_category_name = trim($_POST['i_category_name']);
	$i_category_description = trim($_POST['i_category_description']);
	
	$getData = "SELECT * FROM incomecategory WHERE i_category_name = :i_category_name AND id = :id";
	$data1 = array(":i_category_name"=>$i_category_name, ":id"=>$id);
	
	$result = $conn->prepare($getData);
        $result->execute($data1);
        $result = $result->fetchAll(PDO::FETCH_OBJ);
        $row = count($result);

        if ($row === 1) {
            foreach ($result as $r) {

                $u_i_category = $r->i_category_name;

                if (strtolower($u_i_category) == strtolower($i_category_name)) {
                    echo "<script>location.replace('add_income_category.php?mode=Invalid')</script>";
                }
            }
        } else {
	
	$sql = "INSERT INTO incomecategory(id, i_category_name, i_category_description) VALUES(:id,:i_category_name,:i_category_description)";
	$data = array(":id"=>$id,":i_category_name"=>$i_category_name,":i_category_description"=>$i_category_description);
	$result = $conn->prepare($sql);
	$result->execute($data);
	echo '<script> location.replace("add_income_category.php?mode=inserted")</script>';
}}
?>

<html>
<head>
<title>Add Income Category</title>
</head>
<body>
<div class = "main-wrapper">
<div class = "page-wrapper">
	<div class = "page-content">
	<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add Income Category</li>
    </ol>
	</nav>
		<div class="row">
			<div class="col-md-12 grid-margin stretch-card">
				<div class="card">
					<div class="card-body">
						<h6 class="card-title">Add Income Category</h6>
						<?php if (isset($_GET['mode']) && $_GET['mode'] == 'inserted') { ?>
						<div class="alert alert-success alert-dismissible fade show" role="alert">
						<strong>Income Category Added</strong>
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
						</div>
					<?php } ?>
					<?php if (isset($_GET['mode']) && $_GET['mode'] == 'Invalid') { ?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<strong> Income Category already exists!...</strong>
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
						</div>
					<?php } ?>
							<form class="forms-sample" method="POST" action="">
								<div class="row mb-3">
									<label for="catname" class="col-sm-3 col-form-label">Income Category*</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" minlength="3" maxlength="20" id="i_category_name" name="i_category_name" placeholder="Income Category Name" required>
										</div>
									</div>
									<div class="row mb-3">
										<label for="inccatdesc" class="col-sm-3 col-form-label">Income Category Description</label>
										<div class="col-sm-9">
										<textarea class="form-control" rows = "3" id="i_category_description" name = "i_category_description" placeholder = "Income Category Description" required></textarea>
										</div>
									</div>
									<button type="submit" name="addincomecategory" class="btn btn-primary me-2">Submit</button>
									<a href = "dashboard.php" class="btn btn-danger">Cancel</a>
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