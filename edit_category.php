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
?>

<?php
if(isset($_POST['editcategory'])) {
	$category_name = $_POST['category_name'];
	$category_description = $_POST['category_description'];
	
	if ((isset($_GET['category_id'])) && ($_GET['category_id'] !== "")) {
        $category_id = $_GET["category_id"];
	
		$sql = "UPDATE category SET category_name = '$category_name', category_description = '$category_description',category_modify_date=now() WHERE category_id = '$category_id'";
		$conn->exec($sql);
		echo "<script> location.replace('manage_category.php?mode=inserted')</script>";
	}
}

if ((isset($_GET['category_id'])) && ($_GET['category_id'] !== "")) {
    $category_id = $_GET["category_id"];
    $sql = "SELECT * FROM category where category_id = :category_id";
    $data = array(':category_id' => $category_id);

    $result = $conn->prepare($sql);
    $result->execute($data);
    $result = $result->fetchAll(PDO::FETCH_OBJ);
    $row = count($result);
    if ($row > 0) {
        foreach ($result as $rs) {
            $category_id = $rs->category_id;
			$category_name = $rs->category_name;
            $category_description = $rs->category_description;
        }
    }
}

?>


<html>
<head>
<title>Edit Category</title>
</head>
<body>
<div class = "main-wrapper">
<div class = "page-wrapper">
	<div class = "page-content">
	<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Category</li>
    </ol>
	</nav>
		<div class="row">
			<div class="col-md-12 grid-margin stretch-card">
				<div class="card">
					<div class="card-body">
						<h6 class="card-title">Edit Category</h6>
							<form class="forms-sample" method="POST" action="">
								<div class="row mb-3">
									<label for="catname" class="col-sm-3 col-form-label">Category Name</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" value="<?php echo $category_name;?>" id="category_name" name="category_name" placeholder="Category Name">
										</div>
									</div>
									<div class="row mb-3">
										<label for="catdesc" class="col-sm-3 col-form-label">Category Description</label>
										<div class="col-sm-9">
										<textarea class="form-control" rows = "3" id="category_description"   name="category_description" autocomplete="off" placeholder="Category Description"><?php echo $category_description;?></textarea>
										</div>
									</div>
									<button type="submit" name="editcategory" class="btn btn-primary me-2"><i class="ms-2  me-2 icon-md" data-feather="edit-3"></i></button>
									<a href="manage_category.php" class="btn btn-light me-2"><i class="ms-2  me-2 icon-md" data-feather="arrow-left"></i></a>
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