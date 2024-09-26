<?php

include "header.php";

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
}

if(isset($_POST['submit'])) {
	$startdate = $_POST['startdate'];
    $enddate = $_POST['enddate'];
	$startdate = date("Y-m-d", strtotime($startdate));
	$enddate = date("Y-m-d", strtotime($enddate));
	$startdatenew = date("d-M-y", strtotime($startdate));
	$enddatenew = date("d-M-y", strtotime($enddate));
	
	/* $sql = "SELECT * FROM
(SELECT expense_date as ed, expense_amount as ea, income_amount as incamt, expense_description, category_name FROM expense e JOIN category c ON e.category_id = c.category_id WHERE e.id = :id AND e.expense_date >= :startdate and e.expense_date < :enddate UNION SELECT income_date, expense_amount, + income_amount, income_description, i_category_name FROM income i JOIN incomecategory ic ON i.i_category_id = ic.i_category_id WHERE i.id = :id AND i.income_date >= :startdate and i.income_date < :enddate ORDER BY ed)
AS SUBQUERY;"; */
	
	$sql = "SELECT * FROM
(SELECT 'Expense' as type, expense_date as recorddate, expense_amount, 0 as 'income_amount', expense_description as description, category_name as category, -expense_amount as cd FROM expense e JOIN category c ON e.category_id = c.category_id WHERE e.id = :id AND e.expense_date >= :startdate AND e.expense_date < :enddate UNION SELECT 'Income' as type, income_date as recorddate, 0 as 'expense_amount', income_amount, income_description as description, i_category_name as category, income_amount as cd FROM income i JOIN incomecategory ic ON i.i_category_id = ic.i_category_id WHERE i.id = :id AND i.income_date >= :startdate AND i.income_date < :enddate ORDER BY recorddate)
AS SUBQUERY;";

	$data = array(":id"=>$id, ":startdate"=>$startdate, ":enddate"=>$enddate);
    $result = $conn->prepare($sql);
    $result->execute($data);
    $result = $result->fetchAll(PDO::FETCH_OBJ);
    $row = count($result);

$sql2 = "select SUM(income_amount) - SUM(expense_amount) as totalbalance from ( SELECT 'expense' as type,`expense_id`, `id`, `expense_amount`, 0 as `income_amount` ,`category_id`, `expense_date` as recorddate, `expense_description`, `expense_created_date`, `expense_modify_date` FROM `expense` where `expense_date` < :startdate and id = :id UNION ALL SELECT 'income' as type,`income_id`, `id`, 0 as `expense_amount`,`income_amount`, `i_category_id`, `income_date` as recorddate,`income_description`, `income_created_on`, '' FROM `income`where `income_date` < :startdate and id = :id order by recorddate) as t1;";
	
	$data2 = array(":id"=>$id, ":startdate"=>$startdate);
    $result2 = $conn->prepare($sql2);
    $result2->execute($data2);
    $result2 = $result2->fetchAll(PDO::FETCH_OBJ);
    $row2 = count($result2);
?>

<html>
<head>
<title>Report</title>
<style>
	body.swal2-shown > [aria-hidden="true"] {
  transition: 0.0s filter;
  filter: blur(100px);
}
  </style>
</head>
<body>
	<div class="main-wrapper">

		<!-- partial:../../partials/_navbar.html -->
		
		<!-- partial -->
	<script>
	let timerInterval
      Swal.fire({
        title: 'Your Combined Report is Being Generated!',
		icon: 'success',
        html: 'in <b></b> milliseconds.',
		backdrop: true,
        timer: 2000,
        timerProgressBar: true,
        didOpen: () => {
          Swal.showLoading()
          timerInterval = setInterval(() => {
            const content = Swal.getHtmlContainer()
            if (content) {
              const b = content.querySelector('b')
              if (b) {
                b.textContent = Swal.getTimerLeft()
              }
            }
          }, 100)
        },
      })</script>
		<div class="page-wrapper">

			<div class="page-content">

				<nav class="page-breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="#">Dashboard</a></li>
						<li class="breadcrumb-item active" aria-current="page">Combined Report</li>
					</ol>
				</nav>

				<div class="row">
					<div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <div class="container-fluid d-flex justify-content-between">
                  <div class="col-lg-3 ps-0">
                    <a href="#" class="noble-ui-logo d-block mt-3">Combined<span>Report</span></a>                 
                    <p class="mb-1"><b>Report Generated From</b></p>
                    <p><?php echo $startdatenew; ?> To <?php echo $enddatenew; ?></p>
                  </div>
				  <?php 
					if($row>0) {
						$name = $r->name; 
						$email = $r->email;
						foreach($result as $rs){
							// $incamt = $rs->incamt;
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
						<?php
							  if($row2 > 0) {
								foreach($result2 as $rs) {
							     $totalbalance = $rs->totalbalance;}}
							  ?>
                          <tr style="text-align:center;">
							<th>Index</th>
							<th>Type</th>
							<th>Category</th>
							<th>Description</th>
							<th>Record Date</th>
							<th>Expense Amount</th>
							<th>Income Amount</th>
							<th>Balance</th>
                          </tr>
						  <tr style="">
							<td class = "text-center">-</td>
							<td colspan = "3" class = "text-center">Opening Balance</td>
							<td class = "text-center"><?php echo $startdatenew; ?></td>
							<td colspan = "2" class = "text-center">-</td>
							<td class = "text-center"><?php if($totalbalance == ""){ echo "No Amount Found";} else {
								echo '₹'.$totalbalance;} ?></td>
						  </tr>
                        </thead>
                        <tbody>
                          <?php 
						$sumi = 0;
						$sume = 0;
						$balance = 0;
						$index = 0;						
						foreach($result as $r) {
							
							$type = $r->type;
							$expense_amount = $r->expense_amount;
							$income_amount = $r->income_amount;
							$category = $r->category;
							$description = $r->description;
							$recorddate1 = $r->recorddate;
							$recorddate = date("d-M-y", strtotime($recorddate1));
							$creditdebit = $r->cd;
							$totalbalance = $totalbalance+$creditdebit;
							// $expamt = $r->ea;
							$sumi += $income_amount;
							$sume += $expense_amount;
							$savings = $sumi - $sume;
							$index++;
							
							?>
							
							<tr style = "text-align:center;">
								<td><?php echo $index; ?></td>
								<td><?php echo $type; ?></td>
								<td><?php echo $category; ?></td>
								<td><?php echo $description; ?></td>
								<td><?php echo $recorddate; ?></td>
								<td><?php echo $expense_amount; ?></td>
								<td><?php echo $income_amount; ?></td>
								<td><?php echo $totalbalance; ?></td>
							</tr>
							
							</tbody>
								<?php }}else {echo  '<script>location.replace("combinedreport.php?mode=notfound")</script>'; }} ?>
                      </table>
                    </div>
                </div>
				<div class="container-fluid mt-5 w-100">
                  <div class="row">
                    <div class="col-md-5 ms-auto">
                        <div class="table-responsive">
                          <table class="table">
                              <tbody>
								<tr>
                                  <td><strong>Total Expense</strong></td>
                                  <td class="text-end">₹ <?php echo $sume; ?></td>
                                </tr>
                                <tr>
                                  <td><strong>Total Income</strong></td>
                                  <td class="text-end">₹ <?php echo $sumi; ?></td>
                                </tr>
                                <tr class="bg-light">
                                  <td class="text-bold-800"><strong>Total Savings</strong></td>
                                  <td class="text-bold-800 text-end">₹ <?php echo $savings; ?></td>
                                </tr>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/rasterizehtml/1.3.1/rasterizeHTML.allinone.js" integrity="sha512-E+GxjPdj9RTIj08DQtsIYjUlC6bA75wqkP4Cqch+MLIwVIoVYQiDZF/8vNZRNE6fnvOQhAVQ3U4nHDF5e+QDcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
  
</script>

</html>

