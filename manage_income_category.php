<?php
include "header.php";
include "pagination.php";

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
}

extract($_POST);
$sql = "SELECT * FROM incomecategory WHERE id = $id";
$result=$conn->query($sql);
$result = $result->fetchAll(PDO::FETCH_OBJ);
$row = count($result);

$per_page = 5;
// $cur_page = 1;
$cur_page = isset($_GET['cur_page']) && is_numeric($_GET['cur_page']) ? $_GET['cur_page'] : 1;
if ($cur_page == 1) {
    $page_start = 0;
} else {
    $page_start = (($cur_page - 1) * $per_page);
}
$total_results = $row;
$total_pages = intval($total_results / $per_page); //total pages we going to have
if ($total_pages == 0) {
    $total_pages = 1;
} elseif (($total_pages * $per_page) < $total_results) {
    $total_pages++;
}
$pagination = "";
$url_string = "";

if ($total_pages > 1) {
    $pagination = paginate ('manage_income_category.php?' . $url_string, $cur_page, $total_pages);
    $url_string .= "&page=" . $cur_page;
}

$sql ="SELECT * FROM incomecategory WHERE id = :id limit $page_start , $per_page  ";

    $data = array(":id" => $id);

    $result = $conn->prepare($sql);
    $result->execute($data);
    $result = $result->fetchAll(PDO::FETCH_OBJ);
    $row = count($result);

if(!isset($_SESSION['id']))
{
	header("location: login.php");
	 
	exit();
}
?>

<html>
	<head>
		<title>Manage Category</title>
		<style>
		table,th,td {
			text-align:center;
			
		}
		</style>
	</head>
	<body>
	<div class = "main-wrapper">
	<div class = "page-wrapper">
		<div class = "page-content">
		<nav class="page-breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
			<li class="breadcrumb-item active" aria-current="page">Manage Income Category</li>
		</ol>
		</nav>
		<div class="row">
					<div class="col-md-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
			  <?php if (isset($_GET['mode']) && $_GET['mode'] == 'deleted') { ?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<strong>Income Category Deleted</strong>
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
						</div>
					<?php } ?>
								<h6 class="card-title">Manage Income Categories</h6>
								<div class="table-responsive">
										<table class="table">
											<thead>
												<tr>
													<th>Id</th>
													<th>Category</th>
													<th>Delete</th>
												</tr>
											</thead>
											
											<?php
											$index = (($cur_page - 1) * $per_page) + 1;
											if($row>0) {
												foreach($result as $rs) {
													$i_category_id = $rs->i_category_id;
													$i_category_name = $rs->i_category_name;
											?>
											
											<tbody>
												<tr>
													<th><?php echo $index++; ?></th>
													<td><?php echo $i_category_name; ?></td>
													<td><a href="delete_income_category.php?i_category_id=<?php echo "$i_category_id"; ?>" onclick="return confirm('Are you sure?')"><div class="btn btn-outline-Danger"><i class="ms-2  me-2 icon-md" data-feather="trash"></i></div></a></td>
												</tr>
											<?php }} $conn = null;?>
											</tbody>
										</table>
								</div>
								<?php
                    if($total_results > 0)
                    {
                    ?>
					
					<nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center mt-4" >
                  
                        <li class="page-item <?php if ($cur_page <= 1) echo 'disabled'; ?>">
                            <a class="page-link" href="<?php if ($cur_page <= 1) {echo '#';} else {echo "?cur_page=" . ($cur_page - 1);} ?>" style = "height:38px"><i data-feather="chevron-left"></i></a>
                        </li>
                        <?php   for($page = 1; $page<= $total_pages; $page++) {  ?>
                        <li class="page-item <?php                             
                                if(isset($_GET['cur_page'])){
                                    if($_GET['cur_page'] == $page) echo "active";}
                                    ?> ">
                            <a class="page-link" href="?cur_page=<?php echo $page;?>"><?php echo $page;?> </a>     
                        </li>
                        <?php } ?>
                        <li class="page-item <?php if ($cur_page >= $total_pages) {echo 'disabled';} ?>">
                            <a class="page-link" href="<?php if ($cur_page >= $total_pages) {echo '#';} else {  echo "?cur_page=" . ($cur_page + 1);} ?>"   style = "height:38px"><i data-feather="chevron-right"></i></a>
                        </li>
                    </ul>
                </nav>

                <?php } ?>
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