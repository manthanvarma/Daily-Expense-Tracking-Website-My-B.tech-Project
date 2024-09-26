<?php
include "header.php";

if (!isset($_SESSION)) {
    session_start();
}

$category_name = "";
$category_description = "";


if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
}

if(isset($_POST['addcategory'])) {
	$category_name = trim($_POST['category_name']);
	$category_description = trim($_POST['category_description']);
	
	$getData = "SELECT * FROM category WHERE category_name = :category_name AND id = :id OR category_name = :category_name AND id = 0";
	$data1 = array(":category_name"=>$category_name, ":id"=>$id);
	
	$result = $conn->prepare($getData);
        $result->execute($data1);
        $result = $result->fetchAll(PDO::FETCH_OBJ);
        $row = count($result);

        if ($row === 1) {
            foreach ($result as $r) {

                $u_category = $r->category_name;

                if (strtolower($u_category) == strtolower($category_name)) {
                    echo "<script>location.replace('add_category.php?mode=Invalid')</script>";
                }
            }
        } else {
	
	$sql1 = "INSERT INTO category(id, category_name, category_description) VALUES(:id,:category_name,:category_description)";
	$data2 = array(":id"=>$id,":category_name"=>$category_name, ":category_description"=>$category_description);
	$result1 = $conn->prepare($sql1);
	$result1->execute($data2);
	echo "<script> location.replace('add_category.php?mode=inserted')</script>";
} }
?>

<html>
<head>
<title>Add Category</title>

</head>
<body>
<div class = "main-wrapper">
	<div class = "page-wrapper">
	<div class = "page-content">
	<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add Category</li>
    </ol>
	</nav>
		<div class="row">
			<div class="col-md-12 grid-margin stretch-card">
				<div class="card">
					<div class="card-body">
					<?php if (isset($_GET['mode']) && $_GET['mode'] == 'Invalid') { ?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<strong>Category already exists!...</strong>
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
						</div>
					<?php } ?>
					<?php if (isset($_GET['mode']) && $_GET['mode'] == 'inserted') { ?>
						<div class="alert alert-success alert-dismissible fade show" role="alert">
						<strong>Category Added</strong>
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
						</div>
					<?php } ?>
						<h6 class="card-title">Add Category</h6>
							<form class="forms-sample" method="POST" action="">
								<div class="row mb-3">
									<label for="catname" class="col-sm-3 col-form-label">Category Name *</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" minlength="3" maxlength="20" id="category_name" name="category_name" placeholder="Category Name" required>
										</div>
									</div>
									<div class="row mb-3">
										<label for="catdesc" class="col-sm-3 col-form-label">Category Description</label>
										<div class="col-sm-9">
										<textarea class="form-control" rows = "3" id="category_description" name="category_description" autocomplete="off" placeholder="Category Description"></textarea>
										</div>
									</div>
									<button type="submit" name="addcategory" class="btn btn-primary me-2">Submit</button>
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