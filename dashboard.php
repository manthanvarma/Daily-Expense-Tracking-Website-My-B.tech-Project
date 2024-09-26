
<?php include "header.php";
 include "swal.php"; 

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
} else { header ("location: login.php"); }
?>

<?php
if(!isset($_SESSION['user_name'])){
    echo '<script> document.location.replace("login.php"); </script>';    
}
?>

<?php if (isset($_GET['mode']) && $_GET['mode'] == 'updated1') { ?>
    <div class="alert alert-success alert-dismissible fade show container mt-4" role="alert">
        <strong>Profile Updated Successfully</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
    </div>
<?php } ?>

<?php if (isset($_GET['mode']) && $_GET['mode'] == 'imageupdated') { ?>
    <div class="alert alert-primary alert-dismissible fade show container mt-4" role="alert">
        <strong>Image Updated Successfully</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
    </div>
<?php } ?>

<?php



?>

<?php

$queryl = "SELECT * FROM expense e JOIN category c ON e.category_id = c.category_id WHERE e.id = :id ORDER BY expense_date ASC";
$datal = array(":id"=>$id);
 $resultl=$conn->prepare($queryl);
 $resultl->execute($datal);
 $resultl = $resultl->fetchAll(PDO::FETCH_OBJ);
 $rowl = count($resultl);

?>

<?php
$sum = 0;
$queryall = "SELECT * FROM expense WHERE id = :id ";
$dataall = array(":id"=>$id);
 $resultall = $conn->prepare($queryall);
 $resultall->execute($dataall);
 $resultall = $resultall->fetchAll(PDO::FETCH_OBJ);
 $rowall = count($resultall);

if($rowall>0)
			{ 	
				foreach ($resultall as $rall) {
					$expense_amount_all	= $rall->expense_amount;
					$sum += $expense_amount_all;
				}
				
			}
?>

<?php
$avgi = 0;
$queryavgi = "SELECT *,avg(i.income_amount) as average1 FROM income i JOIN incomecategory ic ON i.i_category_id = ic.i_category_id WHERE i.id = :id;";
$dataavgi = array(":id"=>$id);
 $resultavgi = $conn->prepare($queryavgi);
 $resultavgi->execute($dataavgi);
 $resultavgi = $resultavgi->fetchAll(PDO::FETCH_OBJ);
 $rowavgi = count($resultavgi);

if($rowavgi>0)
			{ 	
				foreach ($resultavgi as $ravgi) {
					$income_amount_avg1	= $ravgi->average1;
					$income_amount_avg = sprintf('%0.2f', $income_amount_avg1);
				}
				
			}
?>

<?php
$avge = 0;
$queryavge = "SELECT *,avg(e.expense_amount) as average2 FROM expense e JOIN category c ON e.category_id = c.category_id WHERE e.id = :id;";
$dataavge = array(":id"=>$id);
 $resultavge = $conn->prepare($queryavge);
 $resultavge->execute($dataavge);
 $resultavge = $resultavge->fetchAll(PDO::FETCH_OBJ);
 $rowavge = count($resultavge);

if($rowavge>0)
			{ 	
				foreach ($resultavge as $ravge) {
					$expense_amount_avg1 = $ravge->average2;
					$expense_amount_avg = sprintf('%0.2f', $expense_amount_avg1);
				}
				
			}
?>

<?php
$suminc = 0;
$queryinc = "SELECT * FROM income WHERE id = :id ";
$datainc = array(":id"=>$id);
 $resultinc = $conn->prepare($queryinc);
 $resultinc->execute($datainc);
 $resultinc = $resultinc->fetchAll(PDO::FETCH_OBJ);
 $rowinc = count($resultinc);

if($rowinc>0)
			{ 	
				foreach ($resultinc as $rinc) {
					$income_amount_inc	= $rinc->income_amount;
					$suminc += $income_amount_inc;
				}
				
			}
?>

<?php
$sumtoday = 0;
$querytod = "SELECT * FROM expense WHERE id = :id AND DAY(expense_date) = DAY(now()) AND MONTH(expense_date) = MONTH(now()) AND YEAR(expense_date) = YEAR(now())";
$datatod = array(":id"=>$id);
 $resulttod = $conn->prepare($querytod);
 $resulttod->execute($datatod);
 $resulttod = $resulttod->fetchAll(PDO::FETCH_OBJ);
 $rowtod = count($resulttod);

if($rowtod>0)
			{ 	
				foreach ($resulttod as $rtod) {
					
					$expense_amount_tod	= $rtod->expense_amount;
					$sumtoday += $expense_amount_tod;
				}
				
			}
?>

<?php
$suminctoday = 0;
$queryinctod = "SELECT * FROM income WHERE id = :id AND DAY(income_date) = DAY(now()) AND MONTH(income_date) = MONTH(now()) AND YEAR(income_date) = YEAR(now())";
$datainctod = array(":id"=>$id);
 $resultinctod = $conn->prepare($queryinctod);
 $resultinctod->execute($datainctod);
 $resultinctod = $resultinctod->fetchAll(PDO::FETCH_OBJ);
 $rowinctod = count($resultinctod);

if($rowinctod>0)
			{ 	
				foreach ($resultinctod as $rinctod) {
					
					$income_amount_tod	= $rinctod->income_amount;
					$suminctoday += $income_amount_tod;
				}
				
			}
?>

<?php
/*$expmax = 0;
$qmax = "SELECT MAX(expense_amount) as max FROM expense WHERE id = :id";
$dmax = array(":id"=>$id);
$rmax = $conn->prepare($qmax);
$rmax->execute($dmax);
$rmax = $rmax->fetchAll(PDO::FETCH_OBJ);
$rowmax = count($rmax);
if($rowmax>0){
	foreach($rmax as $rowx) {
		$expmax = $rowx->max;
		
	}
}*/
?>

<?php
$expmaxdesc = 0;
$expmax = 0;
$qmax = "SELECT  expense_description, expense_amount FROM expense WHERE id = :id AND expense_amount = (SELECT MAX(expense_amount) FROM expense WHERE id = :id);";
$dmax = array(":id"=>$id);
$rmax = $conn->prepare($qmax);
$rmax->execute($dmax);
$rmax = $rmax->fetchAll(PDO::FETCH_OBJ);
$rowmax = count($rmax);
if($rowmax>0){
	foreach($rmax as $rowx) {
		$expmaxdesc = $rowx->expense_description;
		$expmax = $rowx->expense_amount;
	}
}
?>

<?php
$incmaxdesc = 0;
$incmax = 0;
$qincmax = "SELECT  income_description, income_amount FROM income WHERE id = :id AND income_amount = (SELECT MAX(income_amount) FROM income WHERE id = :id);";
$dincmax = array(":id"=>$id);
$rincmax = $conn->prepare($qincmax);
$rincmax->execute($dincmax);
$rincmax = $rincmax->fetchAll(PDO::FETCH_OBJ);
$rowincmax = count($rincmax);
if($rowincmax>0){
	foreach($rincmax as $rowincx) {
		$incmaxdesc = $rowincx->income_description;
		$incmax = $rowincx->income_amount;
	}
}
?>

<?php
$expmaxcattod = 0;
$mct = "SELECT category_name,COUNT(e.category_id) FROM expense e JOIN category c ON e.category_id = c.category_id  WHERE e.id=:id and day(e.expense_date) = day(now()) and month(e.expense_date) = month(now()) and year(e.expense_date) = year(now()) GROUP BY c.category_name ORDER BY COUNT(e.category_id) DESC LIMIT 1;";    
$dct = array(":id"=>$id);
$rmt = $conn->prepare($mct);
$rmt->execute($dct);
$rmt = $rmt->fetchAll(PDO::FETCH_OBJ);
$romt = count($rmt);
if($romt>0){
	foreach($rmt as $romt) {
		$expmaxcattod = $romt->category_name;
	}
}
?>

<?php
$incmaxcattod = 0;
$mcit = "SELECT i_category_name,COUNT(i.i_category_id) FROM income i JOIN incomecategory ic ON i.i_category_id = ic.i_category_id  WHERE i.id=:id GROUP BY ic.i_category_name ORDER BY COUNT(i.i_category_id) DESC LIMIT 1;";    
$dcit = array(":id"=>$id);
$rmit = $conn->prepare($mcit);
$rmit->execute($dcit);
$rmit = $rmit->fetchAll(PDO::FETCH_OBJ);
$romit = count($rmit);
if($romit>0){
	foreach($rmit as $romti) {
		$incmaxcattod = $romti->i_category_name;
	}
}
?>

<?php
$expavg = 0;
$mcitg = "SELECT category_name,COUNT(e.category_id) FROM expense e JOIN category c ON e.category_id = c.category_id  WHERE e.id=:id GROUP BY c.category_name ORDER BY COUNT(e.category_id) DESC LIMIT 1;";    
$dcitg = array(":id"=>$id);
$rmitg = $conn->prepare($mcitg);
$rmitg->execute($dcitg);
$rmitg = $rmitg->fetchAll(PDO::FETCH_OBJ);
$romitg = count($rmitg);
if($romitg>0){
	foreach($rmitg as $romtig) {
		$expavg = $romtig->category_name;
	}
}
?>

<?php
$expmaxcattodall = 0;
$mctall = "SELECT category_name,COUNT(e.category_id) FROM expense e JOIN category c ON e.category_id = c.category_id  WHERE e.id=:id GROUP BY c.category_name ORDER BY COUNT(e.category_id) DESC LIMIT 1;";
$dctall = array(":id"=>$id);
$rmtall = $conn->prepare($mctall);
$rmtall->execute($dctall);
$rmtall = $rmtall->fetchAll(PDO::FETCH_OBJ);
$romtall = count($rmtall);
if($romtall>0){
	foreach($rmtall as $mtall) {
		$expmaxcattodall = $mtall->category_name;
	}
}
?>

<?php
$query2 = "SELECT * FROM expense e JOIN category c ON e.category_id = c.category_id WHERE e.id=:id AND MONTH(expense_date) = MONTH(now()) AND YEAR(expense_date) = YEAR(now())";
$data2 = array(":id"=>$id);
$result2 = $conn->prepare($query2);
$result2->execute($data2);
$result2=$result2->fetchAll(PDO::FETCH_OBJ);
$row2 = count($result2);
?>

<html>
	<head>
		<title>Dashboard</title>
		<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="Responsive HTML Admin Dashboard Template based on Bootstrap 5">
	<meta name="author" content="NobleUI">
	<meta name="keywords" content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.js"></script>
	<title>NobleUI - HTML Bootstrap 5 Admin Dashboard Template</title>

  <!-- Fonts -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,900&display=swap" rel="stylesheet">
<link rel="icon" type="image/x-icon" href="https://cdn-icons-png.flaticon.com/512/1490/1490817.png">
  
	<style>
    
    .donut-inner {
      margin-top: -165px;
      margin-bottom: 100px;
      / margin-right: -125spx; /
      / margin-left: 125px; /
      text-align: center;
    }
    .donut-inner h5 {
      margin-bottom: 5px;
      margin-top: 10px;
      font-size: 30px;
      text-align: center;
    }
    .donut-inner span {
      font-size: 12px;
      text-align: center;
    }
	
	
  </style>
  
	</head>
<body>
	<div class="main-wrapper">
		<div class="page-wrapper">

		<!-- partial:partials/_navbar.html -->
		
		<!-- partial -->
	

			<div class="page-content">

        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
          <div>
            <h3 class="mb-3 mb-md-0">Welcome to Dashboard</h3>
          </div>
          <div class="d-flex align-items-center flex-wrap text-nowrap">
              <div class="input-group flatpickr wd-200 me-2 mb-2 mb-md-0" id="flatpickr-date">
												<input type="date" class="form-control" value = "<?php echo date("Y-m-d"); ?>" name = "enddate" data-input>
												<span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
											</div>
            <button type="button" class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0" onClick="window.print()">
              <i class="btn-icon-prepend" data-feather="printer"></i>
              Print
            </button>
          </div>
        </div>
		<script>
		$(document).ready(function() {
 
  $(".owl-carousel").owlCarousel({
 
      autoPlay: 3000,
      items : 3,
      itemsDesktop : [1199,3],
      itemsDesktopSmall : [979,3],
      center: true,
      nav:true,
      loop:true,
      responsive: {
        600: {
          items: 3
        }
      }
  });
});
		</script>
		<div class="col-md-12 grid-margin stretch-card" style="margin-bottom:-26px;">
              <div class="card0" style="width: 100%;">
                <div class="card-body">
                  <div class="owl-carousel">
				  
				  <div class="item me-2">
                      <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                      <h6 class="card-title mb-0">Total Expense Till Now</h6>
                      
                    </div>
                    <div class="row">
                      <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-2 mt-2">₹ <?php echo $sum ?></h3>
                        <div class="d-flex align-items-baseline">
                          <p class="text-success">
                            <span>Frequently Spent On <?php echo $expmaxcattodall; ?></span>
                            <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                          </p>
                        </div>
                      </div>
                      <div class="col-6 col-md-12 col-xl-7 mt-2">
					  <?php
							include 'config.php';
							
							$sqltots = "SELECT * FROM expense e JOIN category c ON e.category_id = c.category_id WHERE e.id=$id";
							
							$resulttots = $conn->query($sqltots);
							$resulttots = $resulttots->fetchAll(PDO::FETCH_OBJ);
							$rowtots = count($resulttots);

							if($rowtots>0) {
								foreach($resulttots as $rts) {
									$expense_amounttots = $rts->expense_amount;
									$category_nametots = $rts->category_name;
									
									$datatot[] = $expense_amounttots;
									$labeltot[] = $category_nametots;
								}
							}
							?>
                        <div id="totchart" class="mt-md-3 mt-xl-0"></div>
						<script>
						var colors = {
                              primary        : "#6571ff",
                              secondary      : "#7987a1",
                              success        : "#05a34a",
                              info           : "#66d1d1",
                              warning        : "#fbbc06",
                              danger         : "#ff3366",
                              light          : "#e9ecef",
                              dark           : "#060c17",
                              muted          : "#7987a1",
                              gridBorder     : "rgba(77, 138, 240, .15)",
                              bodyColor      : "#000",
                              cardBg         : "#fff"
                            }

                            var fontFamily = "'Roboto', Helvetica, sans-serif"
						
						var options = {
						  chart: {
							type: "line",
							height: 60,
							sparkline: {
							  enabled: !0
							}
						  },
						  series: [{
							name: '',
							data: <?php echo json_encode($datatot) ?>
						  }],
						  xaxis: {
							type: 'date',
							categories: <?php echo json_encode($labeltot) ?>,
						  },
						  stroke: {
							width: 2,
							curve: "smooth"
						  },
						  markers: {
							size: 0
						  },
						  colors: [colors.primary],
						};
						
						var chart = new ApexCharts(document.getElementById('totchart'), options);

                            chart.render();
						</script>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
                    </div>
					
					<div class="item ms-3 me-2">
                      <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                      <h6 class="card-title mb-0">Total Expense Today</h6>
                    </div>
                    <div class="row">
                      <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-2 mt-2">₹ <?php echo $sumtoday ?></h3>
                        <div class="d-flex align-items-baseline">
                          <p class="text-danger">
                            <span>Mostly spent on <br><?php echo $expmaxcattod; ?></span>
                            <i data-feather="arrow-down" class="icon-sm mb-1"></i>
                          </p>
                        </div>
                      </div>
                      <div class="col-6 col-md-12 col-xl-7 mt-2">
						<?php
							include 'config.php';
							
							$sqltods = "SELECT * FROM expense e JOIN category c ON e.category_id = c.category_id WHERE e.id=$id AND DAY(expense_date) = DAY(now()) AND MONTH(expense_date) = MONTH(now()) AND YEAR(expense_date) = YEAR(now())";
							
							$resulttods = $conn->query($sqltods);
							$resulttods = $resulttods->fetchAll(PDO::FETCH_OBJ);
							$rowtods = count($resulttods);

							if($rowtods>0) {
								foreach($resulttods as $rt) {
									$expense_amounttods = $rt->expense_amount;
									$category_nametods = $rt->category_name;
									
									$datatoday[] = $expense_amounttods;
									$labeltoday[] = $category_nametods;
								}
							}
							?>
                        <div id="charttoday" class="mt-md-3 mt-xl-0"></div>
						<script>
				
                  var colors = {
                              primary        : "#6571ff",
                              secondary      : "#7987a1",
                              success        : "#05a34a",
                              info           : "#66d1d1",
                              warning        : "#fbbc06",
                              danger         : "#ff3366",
                              light          : "#e9ecef",
                              dark           : "#060c17",
                              muted          : "#7987a1",
                              gridBorder     : "rgba(77, 138, 240, .15)",
                              bodyColor      : "#000",
                              cardBg         : "#fff"
                            }

                            var fontFamily = "'Roboto', Helvetica, sans-serif"

							var options = {
							  chart: {
								type: "bar",
								height: 60,
								sparkline: {
								  enabled: !0
								}
							  },
							  plotOptions: {
								bar: {
								  borderRadius: 2,
								  columnWidth: "60%"
								}
							  },
							  colors: [colors.primary],
							  series: [{
								name: 'Expense',
								data: <?php echo json_encode($datatoday) ?>
							  }],
							  xaxis: {
								type: 'date',
								categories: <?php echo json_encode($labeltoday) ?>,
							  },
							};
							
                            var chart = new ApexCharts(document.getElementById('charttoday'), options);

                            chart.render();
                </script>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
                    </div>
                    
                     <div class="item ms-3 me-2">
                      <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                      <h6 class="card-title mb-0">Highest Expense of All time</h6>
                    </div>
                    <div class="row">
                      <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-2 mt-2">₹ <?php echo $expmax ?></h3>
                        <div class="d-flex align-items-baseline">
                          <p class="text-success">
                            <span>Spent on<br><?php echo $expmaxdesc ?></span>
                            <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                          </p>
                        </div>
                      </div>
                      <div class="col-6 col-md-12 col-xl-7">
						<div id="growthChart" class="mt-md-3 mt-xl-0"></div>
                        <!--<img src = "https://media.tenor.com/FzHuYmU7pToAAAAC/kbc-adbhut.gif" style = "width:200px; height:100px">-->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
                    </div>
                     
					
					<div class="item ms-3 me-2">
                      <div class="col-12 col-xl-12 grid-margin stretch-card">
            <div class="row flex-grow-1">
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                      <h6 class="card-title mb-0">Total Income Till Now</h6>
                      
                    </div>
                    <div class="row">
                      <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-2 mt-2">₹ <?php echo $suminc ?></h3>
                        <div class="d-flex align-items-baseline">
                          <p class="text-danger">
                            <span>Frequently Spent On <?php echo $expmaxcattodall; ?></span>
                            <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                          </p>
                        </div>
                      </div>
                      <div class="col-6 col-md-12 col-xl-7 mt-2">
					  <?php
							include 'config.php';
							
							$sqltots = "SELECT * FROM income i JOIN incomecategory ic ON i.i_category_id = ic.i_category_id WHERE i.id=$id";
							
							$resulttots = $conn->query($sqltots);
							$resulttots = $resulttots->fetchAll(PDO::FETCH_OBJ);
							$rowtots = count($resulttots);

							if($rowtots>0) {
								foreach($resulttots as $rts) {
									$income_amounttots = $rts->income_amount;
									$income_categorytots = $rts->i_category_name;
									
									$dataitot[] = $income_amounttots;
									$labelitot[] = $income_categorytots;
								}
							}
							?>
                        <div id="totchart34" class="mt-md-3 mt-xl-0"></div>
						<script>
						var colors = {
                              primary        : "#6571ff",
                              secondary      : "#7987a1",
                              success        : "#05a34a",
                              info           : "#66d1d1",
                              warning        : "#fbbc06",
                              danger         : "#ff3366",
                              light          : "#e9ecef",
                              dark           : "#060c17",
                              muted          : "#7987a1",
                              gridBorder     : "rgba(77, 138, 240, .15)",
                              bodyColor      : "#000",
                              cardBg         : "#fff"
                            }

                            var fontFamily = "'Roboto', Helvetica, sans-serif"
						
						var options = {
						  chart: {
							type: "line",
							height: 60,
							sparkline: {
							  enabled: !0
							}
						  },
						  series: [{
							name: '',
							data: <?php echo json_encode($dataitot) ?>
						  }],
						  xaxis: {
							type: 'date',
							categories: <?php echo json_encode($labelitot) ?>,
						  },
						  stroke: {
							width: 2,
							curve: "smooth"
						  },
						  markers: {
							size: 0
						  },
						  colors: [colors.primary],
						};
						
						var chart = new ApexCharts(document.getElementById('totchart34'), options);

                            chart.render();
						</script>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
                    </div>
					
					<div class="item ms-3 me-2">
                      <div class="col-12 col-xl-12 grid-margin stretch-card">
            <div class="row flex-grow-1">
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                      <h6 class="card-title mb-0">Average Monthly Income</h6>
                      
                    </div>
                    <div class="row">
                      <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-2 mt-2">₹ <?php echo $income_amount_avg; ?></h3>
                        <div class="d-flex align-items-baseline">
                          <p class="text-success">
                            <span>Mostly came from <?php echo $incmaxcattod; ?></span>
                            <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                          </p>
                        </div>
                      </div>
                      <div class="col-6 col-md-12 col-xl-7 mt-2">
					  <?php
							include 'config.php';
							
							$sqltots = "SELECT *, avg(i.income_amount) FROM income i JOIN incomecategory ic ON i.i_category_id = ic.i_category_id WHERE i.id = $id GROUP BY i.i_category_id;";
							
							$resulttots = $conn->query($sqltots);
							$resulttots = $resulttots->fetchAll(PDO::FETCH_OBJ);
							$rowtots = count($resulttots);

							if($rowtots>0) {
								foreach($resulttots as $rts) {
									$income_dateavg = $rts->income_date;
									$income_amountavg = $rts->income_amount;
									
									$dataitot56[] = $income_amountavg;
									$labelitot56[] = $income_dateavg;
								}
							}
							?>
                        <div id="totchart56" class="mt-md-3 mt-xl-0"></div>
						<script>
						var colors = {
                              primary        : "#6571ff",
                              secondary      : "#7987a1",
                              success        : "#05a34a",
                              info           : "#66d1d1",
                              warning        : "#fbbc06",
                              danger         : "#ff3366",
                              light          : "#e9ecef",
                              dark           : "#060c17",
                              muted          : "#7987a1",
                              gridBorder     : "rgba(77, 138, 240, .15)",
                              bodyColor      : "#000",
                              cardBg         : "#fff"
                            }

                            var fontFamily = "'Roboto', Helvetica, sans-serif"
						
						var options = {
						  chart: {
							type: "line",
							height: 60,
							sparkline: {
							  enabled: !0
							}
						  },
						  series: [{
							name: '',
							data: <?php echo json_encode($dataitot56) ?>
						  }],
						  xaxis: {
							type: 'date',
							categories: <?php echo json_encode($labelitot56) ?>,
						  },
						  stroke: {
							width: 2,
							curve: "smooth"
						  },
						  markers: {
							size: 0
						  },
						  colors: [colors.primary],
						};
						
						var chart = new ApexCharts(document.getElementById('totchart56'), options);

                            chart.render();
						</script>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
                    </div>
					
					<div class="item ms-3">
                      <div class="col-12 col-xl-12 grid-margin stretch-card">
            <div class="row flex-grow-1">
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                      <h6 class="card-title mb-0">Average Monthly Expense</h6>
                      
                    </div>
                    <div class="row">
                      <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-2 mt-2">₹ <?php echo $expense_amount_avg; ?></h3>
                        <div class="d-flex align-items-baseline">
                          <p class="text-danger">
                            <span>Mostly spent on <?php echo $expavg; ?></span>
                            <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                          </p>
                        </div>
                      </div>
                      <div class="col-6 col-md-12 col-xl-7 mt-2">
					  <?php
							include 'config.php';
							
							$sqltotsa = "SELECT *, avg(e.expense_amount) FROM expense e JOIN category c ON e.category_id = c.category_id WHERE e.id = $id GROUP BY e.category_id;";
							
							$resulttotsa = $conn->query($sqltotsa);
							$resulttotsa = $resulttotsa->fetchAll(PDO::FETCH_OBJ);
							$rowtotsa = count($resulttotsa);

							if($rowtotsa>0) {
								foreach($resulttotsa as $rtsa) {
									$exp_dateavg = $rtsa->expense_date;
									$exp_amountavg = $rtsa->expense_amount;
									
									$dataitot567[] = $exp_amountavg;
									$labelitot567[] = $exp_dateavg;
								}
							}
							?>
                        <div id="totchart567" class="mt-md-3 mt-xl-0"></div>
						<script>
						var colors = {
                              primary        : "#6571ff",
                              secondary      : "#7987a1",
                              success        : "#05a34a",
                              info           : "#66d1d1",
                              warning        : "#fbbc06",
                              danger         : "#ff3366",
                              light          : "#e9ecef",
                              dark           : "#060c17",
                              muted          : "#7987a1",
                              gridBorder     : "rgba(77, 138, 240, .15)",
                              bodyColor      : "#000",
                              cardBg         : "#fff"
                            }

                            var fontFamily = "'Roboto', Helvetica, sans-serif"
						
						var options = {
						  chart: {
							type: "line",
							height: 60,
							sparkline: {
							  enabled: !0
							}
						  },
						  series: [{
							name: '',
							data: <?php echo json_encode($dataitot567) ?>
						  }],
						  xaxis: {
							type: 'date',
							categories: <?php echo json_encode($labelitot567) ?>,
						  },
						  stroke: {
							width: 2,
							curve: "smooth"
						  },
						  markers: {
							size: 0
						  },
						  colors: [colors.primary],
						};
						
						var chart = new ApexCharts(document.getElementById('totchart567'), options);

                            chart.render();
						</script>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
                    </div>
                    
                  </div>
                </div>
              </div>
            </div>

		<div class = "row">
		  <div class="col-6 col-xl-8 grid-margin stretch-card">
            <div class="card overflow-hidden" style="height:570px;">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-0 mb-md-0">
                  <h6 class="card-title mb-0">Expense Per Day For Current Month</h6>
                </div>
                <div class="row align-items-start">
                  <div class="col-md-12">
                    <p class="text-muted tx-13 mb-3 mb-md-0">This group will show you expenditure per day for current month. It will be helpful for you to observe how much you spent per day.</p>
                  </div>
                  
                </div>
                <!--<div id="revenueChart" ></div>-->
				<?php
                        $sql4 = "SELECT * FROM expense e JOIN user u ON u.id=e.id WHERE e.id=$id AND MONTH(e.expense_date) = MONTH(now()) AND year(e.expense_date) = year(now()) ORDER BY expense_date";
  
                        $result4 = $conn->query($sql4);
                        $result4 = $result4->fetchAll(PDO::FETCH_OBJ);
                        $row4 = count($result4);
                        
                        if($row4>0){
                          $cal4=0;
                          foreach($result4 as $r4){
                            $expense_amount = $r4->expense_amount;
                            $expense_date = $r4->expense_date;

                            $data4[] = $expense_amount;
                            $label4[] = $expense_date;
                            $datelabel1[] = date("M d Y",strtotime($expense_date));//.'('.$name.')'
                            
echo '<div id="bigline5" class="mx-md-3 mt-4"></div>'; }} else { echo '<div class = "text-center" style = "margin-top:150px; font-size:25px;";>Expense Not Entered for Current Month</div><div class = "text-center" style = "margin-top:0px; font-size:15px;";>(Add Some Expenses)</div>'; }
                        ?>
                <div id="bigline5" class="mx-md-3 mt-xl-0"></div>
                <script>
				
                  var colors = {
                              primary        : "#6571ff",
                              secondary      : "#7987a1",
                              success        : "#05a34a",
                              info           : "#66d1d1",
                              warning        : "#fbbc06",
                              danger         : "#ff3366",
                              light          : "#e9ecef",
                              dark           : "#060c17",
                              muted          : "#7987a1",
                              gridBorder     : "rgba(77, 138, 240, .15)",
                              bodyColor      : "#000",
                              cardBg         : "#fff"
                            }

                            var fontFamily = "'Roboto', Helvetica, sans-serif"

							var options = {
                              chart: {
                                type: "bar",
                                height: '450',
                                parentHeightOffset: 0,
                                foreColor: colors.bodyColor,
								zoom: {
									  enabled: true,
									  type: 'x',  
									  autoScaleYaxis: false,  
									  zoomedArea: {
										fill: {
										  color: '#90CAF9',
										  opacity: 0.4
										},
										stroke: {
										  color: '#0D47A1',
										  opacity: 0.4,
										  width: 1
										}
									  }
								  },
                                background: colors.cardBg,
                                toolbar: {
                                  show: false
                                },
                              },
                              theme: {
                                mode: 'light'
                              },
                              tooltip: {
                                theme: 'light'
                              },
                              colors: [colors.primary],
							  fill: {
								opacity: .9
							  } ,
                              grid: {
                                padding: {
                                  bottom: -4,
                                },
                                borderColor: colors.gridBorder,
                                xaxis: {
                                  lines: {
                                    show: true
                                  },
                                }
                              },
                              series: [
                                {
                                  name: "Expense Amount",
                                  data: <?php echo json_encode($data4) ?>
                                },
                              ],
                              xaxis: {
                                type: "date",
                                categories: <?php echo json_encode($datelabel1) ?>,
								tickPlacement: 'on',
                                axisBorder: {
                                  color: colors.gridBorder,
                                },
                                axisTicks: {
                                  color: colors.gridBorder,
                                },
								labels: {
									rotate: 0,
								},
                              },
                              yaxis: {
                                title: {
                                  text: 'Expense Amount',
                                  style:{
                                    size: 9,
                                    color: colors.muted
                                  }
                                },
                              },
							  legend: {
								show: true,
								position: "top",
								horizontalAlign: 'center',
								fontFamily: fontFamily,
								itemMargin: {
								  horizontal: 8,
								  vertical: 0
								},
							  },
                              stroke: {
                                width: 0
                              },
							  dataLabels: {
								enabled: true,
								style: {
								  fontSize: '10px',
								  fontFamily: fontFamily,
								},
								offsetY: -27
							  },
							  plotOptions: {
								bar: {
								  columnWidth: "50%",
								  borderRadius: 4,
								  dataLabels: {
									position: 'top',
									orientation: 'vertical',
								  }
								},
							  },
                            };

                            var chart = new ApexCharts(document.getElementById('bigline5'), options);

                            chart.render();
                </script>
				
              </div>
            </div>
          </div>
		  
		  <div class="col-6 col-xl-4 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline">
                  <h6 class="card-title mb-0">Income vs Expenditure for current month</h6>
                  
                </div>
				<div class="row align-items-start">
                  <div class="col-md-12">
                    <p class="text-muted tx-13 mb-3 mt-1 mb-md-0">This group will show your income vs expenditure for current month. This will give you alert if your expense is going higher than your income or vice versa.</p>
                  </div>
                </div>
				
				<?php
                $sqlcha = "SELECT SUM(expense_amount) as expense_amount, SUM(income_amount) as income_amount from (SELECT 'expense' as type,`expense_id`, `id`, `expense_amount`, 0 as `income_amount` ,`category_id`, `expense_date` as recorddate, `expense_description`, `expense_created_date`, `expense_modify_date` FROM `expense` WHERE MONTH(expense_date) = MONTH(now()) and YEAR(expense_date) = YEAR(now()) UNION ALL SELECT 'income' as type,`income_id`, `id`, 0 as `expense_amount`,`income_amount`, `i_category_id`, `income_date` as recorddate,`income_description`, `income_created_on`, '' FROM `income` WHERE MONTH(income_date) = MONTH(now()) AND YEAR(income_date) = YEAR(now())  order by recorddate) as t1 WHERE id = $id;";
  
                $resultcha = $conn->query($sqlcha);
                $resultcha = $resultcha->fetchAll(PDO::FETCH_OBJ);
                $rowcha = count($resultcha);
                $ints = 0;
				$expense_amount_sums = 0;
				$income_amount_sums = 0;
                if($rowcha>0){
                  $expense_amount_sums = 0;
                  $income_amount_sums = 0;
                  $label = 'Expense';

                  foreach($resultcha as $rcha){
                    $expense_amounts = $rcha->expense_amount;
                    $expense_amount_sums += $expense_amounts;
					$income_amounts = $rcha->income_amount;
                    $income_amount_sums += $income_amounts;
                  }
                  
				  if($income_amount_sums == 0 OR $expense_amount_sums == 0) {
					echo "<div class = 'mt-3 text-center text-danger' style = 'font-size:20px;'>Expense or Income Empty</div>";
				  } elseif($expense_amount_sums<$income_amount_sums) {
				  
                  $exp_percents = ($expense_amount_sums*100)/$income_amount_sums;
                  //echo $exp_percent;
                  $ints = (int)$exp_percents;
				  echo '<div id="storage2" class="mx-md-3 mt-xl-0"></div>';
                }
				else { $ints=100; echo '<div id="storage23" class="mx-md-3 mt-xl-0"></div>'; }
				}
                ?>
                
                
                <script>
				
                  var colors = {
                              primary        : "#6571ff",
                              secondary      : "#7987a1",
                              success        : "#05a34a",
                              info           : "#66d1d1",
                              warning        : "#fbbc06",
                              danger         : "#ff3366",
                              light          : "#e9ecef",
                              dark           : "#060c17",
                              muted          : "#7987a1",
                              gridBorder     : "rgba(77, 138, 240, .15)",
                              bodyColor      : "#000",
                              cardBg         : "#fff"
                            }

                            var fontFamily = "'Roboto', Helvetica, sans-serif"

							var options = {
							  chart: {
								height: 350,
								type: "radialBar"
							  },
							  series: [<?php echo $ints; ?>],
							  colors: [colors.primary],
							  plotOptions: {
								radialBar: {
								  hollow: {
									margin: 15,
									size: "70%"
								  },
								  track: {
									show: true,
									background: colors.light,
									strokeWidth: '100%',
									opacity: 1,
									margin: 5, 
								  },
								  dataLabels: {
									showOn: "always",
									name: {
									  offsetY: -11,
									  show: true,
									  color: colors.muted,
									  fontSize: "13px"
									},
									value: {
									  color: colors.bodyColor,
									  fontSize: "30px",
									  show: true
									}
								  }
								}
							  },
							  fill: {
								opacity: 1
							  },
							  stroke: {
								lineCap: "round",
							  },
							  labels: ["Expense"]
							};
							
							var chart = new ApexCharts(document.getElementById('storage2'), options);

                            chart.render();    
                </script>
				<script>
				
                  var colors = {
                              primary        : "#6571ff",
                              secondary      : "#7987a1",
                              success        : "#05a34a",
                              info           : "#66d1d1",
                              warning        : "#fbbc06",
                              danger         : "#ff3366",
                              light          : "#e9ecef",
                              dark           : "#060c17",
                              muted          : "#7987a1",
                              gridBorder     : "rgba(77, 138, 240, .15)",
                              bodyColor      : "#000",
                              cardBg         : "#fff"
                            }

                            var fontFamily = "'Roboto', Helvetica, sans-serif"

							var options = {
							  chart: {
								height: 350,
								type: "radialBar"
							  },
							  series: [<?php echo $ints; ?>],
							  colors: [colors.danger],
							  plotOptions: {
								radialBar: {
								  hollow: {
									margin: 15,
									size: "70%"
								  },
								  track: {
									show: true,
									background: colors.light,
									strokeWidth: '100%',
									opacity: 1,
									margin: 5, 
								  },
								  dataLabels: {
									showOn: "always",
									name: {
									  offsetY: -11,
									  show: true,
									  color: colors.muted,
									  fontSize: "13px"
									},
									value: {
									  color: colors.bodyColor,
									  fontSize: "30px",
									  show: true
									}
								  }
								}
							  },
							  fill: {
								opacity: 1
							  },
							  stroke: {
								lineCap: "round",
							  },
							  labels: ["Expense"]
							};
							
							var chart = new ApexCharts(document.getElementById('storage23'), options);

                            chart.render();    
                </script>
				<div class="row mb-3 mt-3">
                  <div class="col-6 d-flex justify-content-end">
                    <div>
                      <label class="d-flex align-items-center justify-content-end tx-11 text-uppercase fw-bolder">Total Expense <span class="p-1 ms-1 rounded-circle bg-secondary"></span></label>
                      <h4 class="fw-bolder mb-0 text-end"><?php echo $expense_amount_sums; ?></h4>
                    </div>
                  </div>
                  <div class="col-6">
                    <div>
                      <label class="d-flex align-items-center tx-11 text-uppercase fw-bolder"><span class="p-1 me-1 rounded-circle bg-primary"></span> Total Income</label>
                      <h4 class="fw-bolder mb-0"><?php echo $income_amount_sums; ?></h4>
                    </div>
                  </div>
                </div>
                <div class="d-grid">
					<?php if($expense_amount_sums > $income_amount_sums) {
						echo "<button class='btn btn-danger'>You're spending more than your income</button>";
					} else {
						echo "<button class='btn btn-success'>Expense is less than Income, You're Good to Go</button>";
					} ?>
                </div>
				</div>
			</div>
		</div>
		  </div>
	
	<div class="row">
	<div class="col-6 col-xl-4 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline">
                  <h6 class="card-title mb-0">Total Income vs Total Expenditure</h6>
                  
                </div>
				<div class="row align-items-start">
                  <div class="col-md-12">
                    <p class="text-muted tx-13 mb-3 mb-md-0">This group will show your expenditure per category of today. This will be helpful for you to see where in which domain you spend the most in a day.</p>
                  </div>
                  
                </div>
                <!--<div id="storageChart"></div>-->
				 <?php
                $sqlch = "SELECT SUM(expense_amount) as expense_amount, SUM(income_amount) as income_amount from (SELECT 'expense' as type,`expense_id`, `id`, `expense_amount`, 0 as `income_amount` ,`category_id`, `expense_date` as recorddate, `expense_description`, `expense_created_date`, `expense_modify_date` FROM `expense` UNION ALL SELECT 'income' as type,`income_id`, `id`, 0 as `expense_amount`,`income_amount`, `i_category_id`, `income_date` as recorddate,`income_description`, `income_created_on`, '' FROM `income`  order by recorddate) as t1 WHERE id = $id;";
  
                $resultch = $conn->query($sqlch);
                $resultch = $resultch->fetchAll(PDO::FETCH_OBJ);
                $rowch = count($resultch);
                $int = 0;
				$expense_amount_sum = '0';
				$income_amount_sum = '0';
                if($rowch>0){
                  $expense_amount_sum = 0;
                  $income_amount_sum = 0;
                  $label = 'Expense';

                  foreach($resultch as $rch){
                    $expense_amounts = $rch->expense_amount;
                    $expense_amount_sum += $expense_amounts;
					$income_amounts = $rch->income_amount;
                    $income_amount_sum += $income_amounts;
                  }
				  
				  if($income_amount_sum == 0 OR $expense_amount_sum == 0) {
					echo "<div class = 'mt-2 text-center text-danger' style = 'font-size:20px;'>Expense or Income Empty</div>";
				  } elseif($expense_amount_sum<$income_amount_sum) {
                  
                  $exp_percent = ($expense_amount_sum*100)/$income_amount_sum;
                  //echo $exp_percent;
                  $int = (int)$exp_percent;
				  echo '<div id="storage" class="mx-md-3 mt-xl-0"></div>';
                }
				else { $int=100; echo '<div id="storage22" class="mx-md-3 mt-xl-0"></div>'; }
				}
                ?>
                
                
                <script>
				
                  var colors = {
                              primary        : "#6571ff",
                              secondary      : "#7987a1",
                              success        : "#05a34a",
                              info           : "#66d1d1",
                              warning        : "#fbbc06",
                              danger         : "#ff3366",
                              light          : "#e9ecef",
                              dark           : "#060c17",
                              muted          : "#7987a1",
                              gridBorder     : "rgba(77, 138, 240, .15)",
                              bodyColor      : "#000",
                              cardBg         : "#fff"
                            }

                            var fontFamily = "'Roboto', Helvetica, sans-serif"

							var options = {
							  chart: {
								height: 350,
								type: "radialBar"
							  },
							  series: [<?php echo $int; ?>],
							  colors: [colors.primary],
							  plotOptions: {
								radialBar: {
								  hollow: {
									margin: 15,
									size: "70%"
								  },
								  track: {
									show: true,
									background: colors.light,
									strokeWidth: "100%",
									opacity: 1,
									margin: 5, 
								  },
								  dataLabels: {
									showOn: "always",
									name: {
									  offsetY: -11,
									  show: true,
									  color: colors.muted,
									  fontSize: "13px"
									},
									value: {
									  color: colors.bodyColor,
									  fontSize: "30px",
									  show: true
									}
								  }
								}
							  },
							  fill: {
								opacity: 1
							  },
							  stroke: {
								lineCap: "round",
							  },
							  labels: ["Expense"]
							};
							
							var chart = new ApexCharts(document.getElementById("storage"), options);

                            chart.render();    
                </script>
				<script>
				
                  var colors = {
                              primary        : "#6571ff",
                              secondary      : "#7987a1",
                              success        : "#05a34a",
                              info           : "#66d1d1",
                              warning        : "#fbbc06",
                              danger         : "#ff3366",
                              light          : "#e9ecef",
                              dark           : "#060c17",
                              muted          : "#7987a1",
                              gridBorder     : "rgba(77, 138, 240, .15)",
                              bodyColor      : "#000",
                              cardBg         : "#fff"
                            }

                            var fontFamily = "'Roboto', Helvetica, sans-serif"

							var options = {
							  chart: {
								height: 350,
								type: "radialBar"
							  },
							  series: [<?php echo $int; ?>],
							  colors: [colors.danger],
							  plotOptions: {
								radialBar: {
								  hollow: {
									margin: 15,
									size: "70%"
								  },
								  track: {
									show: true,
									background: colors.light,
									strokeWidth: "100%",
									opacity: 1,
									margin: 5, 
								  },
								  dataLabels: {
									showOn: "always",
									name: {
									  offsetY: -11,
									  show: true,
									  color: colors.muted,
									  fontSize: "13px"
									},
									value: {
									  color: colors.bodyColor,
									  fontSize: "30px",
									  show: true
									}
								  }
								}
							  },
							  fill: {
								opacity: 1
							  },
							  stroke: {
								lineCap: "round",
							  },
							  labels: ["Expense"]
							};
							
							var chart = new ApexCharts(document.getElementById("storage22"), options);

                            chart.render();    
                </script>
				
                <div class="row mb-3 mt-0">
                  <div class="col-6 d-flex justify-content-end">
                    <div>
                      <label class="d-flex align-items-center justify-content-end tx-11 text-uppercase fw-bolder">Total Expense <span class="p-1 ms-1 rounded-circle bg-secondary"></span></label>
                      <h4 class="fw-bolder mb-0 text-end"><?php echo $expense_amount_sum; ?></h4>
                    </div>
                  </div>
                  <div class="col-6">
                    <div>
                      <label class="d-flex align-items-center tx-11 text-uppercase fw-bolder"><span class="p-1 me-1 rounded-circle bg-primary"></span> Total Income</label>
                      <h4 class="fw-bolder mb-0"><?php echo $income_amount_sum; ?></h4>
                    </div>
                  </div>
                </div>
                <div class="d-grid">
					<?php if($expense_amount_sum > $income_amount_sum) {
						echo "<button class='btn btn-danger'>You're spending more than your income</button>";
					} else {
						echo "<button class='btn btn-success'>Expense is less than Income, You're Good to Go</button>";
					} ?>
                </div>
              </div>
            </div>
          </div>

		<div class="col-6 col-xl-8 grid-margin stretch-card">
            <div class="card overflow-hidden" style="height:550px;">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-0 mb-md-0">
                  <h6 class="card-title mb-0">Expense Per Day of current year <?php echo date("Y"); ?></h6>
                </div>
                <div class="row align-items-start">
                  <div class="col-md-12">
                    <p class="text-muted tx-13 mb-3 mb-md-0">This chart is a line Chart. This chart will show you the expense per day for current year. It will be helpful for you to observe the amount you've spent per day in a year. A line chart is a graphical representation of an asset's historical price action that connects a series of data points with a continuous line.</p>
                  </div>
                  
                </div>
                <!--<div id="revenueChart" ></div>-->
				<?php
                        $sql3 = "SELECT * FROM expense e JOIN user u ON u.id=e.id WHERE e.id=$id AND YEAR(expense_date) = YEAR(now()) ORDER BY expense_date";
  
                        $result3 = $conn->query($sql3);
                        $result3 = $result3->fetchAll(PDO::FETCH_OBJ);
                        $row3 = count($result3);
                        
                        if($row3>0){
                          $cal3=0;
                          foreach($result3 as $r){
                            $expense_amount = $r->expense_amount;
                            $expense_date = $r->expense_date;

                            $data3[] = $expense_amount;
                            $label3[] = $expense_date;
                            $datelabel[] = date("M d Y",strtotime($expense_date));//.'('.$name.')'
                            
echo '<div id="bigline1" class="mx-md-3 mt-4"></div>'; }} else { echo '<div class = "text-center" style = "margin-top:200px; font-size:25px;";>Expense Not Entered</div><div class = "text-center" style = "margin-top:0px; font-size:15px;";>(Add Some Expenses to see result)</div>'; }
                        ?>
                <div id="bigline1" class="mx-md-3 mt-xl-0"></div>
                <script>
                  var colors = {
                              primary        : "#6571ff",
                              secondary      : "#7987a1",
                              success        : "#05a34a",
                              info           : "#66d1d1",
                              warning        : "#fbbc06",
                              danger         : "#ff3366",
                              light          : "#e9ecef",
                              dark           : "#060c17",
                              muted          : "#7987a1",
                              gridBorder     : "rgba(77, 138, 240, .15)",
                              bodyColor      : "#000",
                              cardBg         : "#fff"
                            }

                            var fontFamily = "'Roboto', Helvetica, sans-serif"

var options = {
                              chart: {
                                type: "line",
                                height: '400',
                                parentHeightOffset: 0,
                                foreColor: colors.bodyColor,
                                background: colors.cardBg,
                                zoom: {
									  enabled: true,
									  type: 'x',  
									  autoScaleYaxis: false,  
									  zoomedArea: {
										fill: {
										  color: '#90CAF9',
										  opacity: 0.4
										},
										stroke: {
										  color: '#0D47A1',
										  opacity: 0.4,
										  width: 1
										}
									  }
								  },
                                toolbar: {
                                  autoSelected: 'zoom'
                                },
                                toolbar: {
                                  show: false
                                },
                              },
                              theme: {
                                mode: 'light'
                              },
                              tooltip: {
                                theme: 'light'
                              },
                              colors: [colors.primary, colors.danger, colors.warning],
                              grid: {
                                padding: {
                                  bottom: -4,
                                },
                                borderColor: colors.gridBorder,
                                xaxis: {
                                  lines: {
                                    show: true
                                  },
                                }
                              },
                              series: [
                                {
                                  name: "Expense Amount",
                                  data: <?php echo json_encode($data3) ?>
                                },
                              ],
                              xaxis: {
                                type: "date",
                                categories: <?php echo json_encode($datelabel) ?>,
								tickAmount: 4,
                                lines: {
                                  show: true
                                },
                                labels: {
                                  format: 'dd-MMM-yy',
								  rotate: 0,
                                },
                                axisBorder: {
                                  color: colors.gridBorder,
                                },
                                axisTicks: {
                                  color: colors.gridBorder,
                                },
                                crosshairs: {
                                  stroke: {
                                    color: colors.secondary,
                                  },
                                },
                              },
                              yaxis: {
                                title: {
                                  text: 'Expense Amount',
                                  style:{
                                    size: 9,
                                    color: colors.muted
                                  }
                                },
                                tooltip: {
                                  enabled: true
                                },
                                crosshairs: {
                                  stroke: {
                                    color: colors.secondary,
                                  },
                                },
                              },
                              markers: {
                                size: 5,
                              },
                              stroke: {
                                width: 2,
                                curve: "straight",
                              },
                            };

                            var chart = new ApexCharts(document.getElementById('bigline1'), options);

                            chart.render();
                </script>
              </div>
            </div>
          </div>
          
		  
        </div> <!-- row -->
		<div class = "row">
			<div class="col-6 col-xl-4 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline">
                  <h6 class="card-title mb-0">Today Spending Per Category</h6>
                </div>
				<div class="row align-items-start">
                  <div class="col-md-0">
                    <p class="text-muted tx-13 mb-3 mt-2 mb-md-0">Your Expenditure Per Category For Today. Hover on colors to see how much you spent.</p>
                  </div>
                </div>
				<?php 
				include "config.php"; 
				$sqlnow = "SELECT *, sum(e.expense_amount) as se FROM expense e JOIN category c ON e.category_id = c.category_id WHERE e.id = $id AND DAY(expense_date) = DAY(now()) AND MONTH(expense_date) = MONTH(now()) AND YEAR(expense_date) = YEAR(now()) GROUP BY e.category_id;";
				$resultnow = $conn->query($sqlnow);
				$resultnow = $resultnow->fetchAll(PDO::FETCH_OBJ);
				$rownow = count($resultnow);
				
				if($rownow>0) {
					foreach($resultnow as $r) {
						$expense_amount_now = $r->se;
						$category_name_now = $r->category_name;
						
						$data1[] = $expense_amount_now;
					$label1[] = $category_name_now; }
						
				echo '<canvas id="exptoday" class="mt-2"></canvas>'; } else { echo '<div class = "text-center" style = "margin-top:70px; font-size:15px;";>Expense Not Entered for Today</div><div class = "text-center" style = "margin-top:0px; font-size:15px;";>(Add Some Expenses)</div>'; }
				?>
				<script>
				var colors = {
				primary        : "#6571ff",
				secondary      : "#7987a1",
				success        : "#05a34a",
				info           : "#66d1d1",
				warning        : "#fbbc06",
				danger         : "#ff3366",
				light          : "#e9ecef",
				dark           : "#060c17",
				muted          : "#7987a1",
				gridBorder     : "rgba(77, 138, 240, .15)",
				bodyColor      : "#000",
				cardBg         : "#fff",
				orange		   : "#f78307",	
				electriclime   : "#ccff00",	
				purple   	   : "#660066"	
			  }

			  var fontFamily = "'Roboto', Helvetica, sans-serif"
			  
				new Chart($('#exptoday'), {
				  type: 'pie',
				  data: {
					labels: <?php echo json_encode($label1) ?>,
					datasets: [{
					  label: "Expense",
					  backgroundColor: [colors.primary, colors.orange, colors.electriclime, colors.purple, colors.danger, colors.info, colors.warning, colors.muted, colors.success],
					  borderColor: colors.cardBg,
					  data: <?php echo json_encode($data1) ?>
					}]
				  },
				  options: {
					plugins: {
					  legend: { 
						display: true,
						position: 'right',
						labels: {
						  color: colors.bodyColor,
						  font: {
							size: '13px',
							family: fontFamily
						  }
						}
					  },
					},
					aspectRatio: 2,
				  }
				});
				</script>
			  </div>
			</div>
			</div>
			
			<div class="col-6 col-xl-4 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline">
                  <h6 class="card-title mb-0"><?php echo date('F'); ?> Spending Per Category</h6>
                </div>
				<div class="row align-items-start">
                  <div class="col-md-0">
                    <p class="text-muted tx-13 mb-3 mt-2 mb-md-0">Your Expenditure Per Category For <?php echo date('F'); ?> month. Hover on colors to see how much you spent.</p>
                  </div>
                </div>
				<?php 
				include "config.php"; 
				$sqlmon = "SELECT *, sum(e.expense_amount) as se FROM expense e JOIN category c ON e.category_id = c.category_id WHERE e.id = $id AND MONTH(expense_date) = MONTH(now()) AND YEAR(expense_date) = YEAR(now()) GROUP BY e.category_id;";
				$resultmon = $conn->query($sqlmon);
				$resultmon = $resultmon->fetchAll(PDO::FETCH_OBJ);
				$rowmon = count($resultmon);
				
				if($rowmon>0) {
					foreach($resultmon as $r) {
						$expense_amount_mon = $r->se;
						$category_name_mon = $r->category_name;
						
						$data2[] = $expense_amount_mon;
					$label2[] = $category_name_mon; }
						
				echo '<canvas id="expmonth" class="mt-2"></canvas>'; } else { echo '<div class = "text-center" style = "margin-top:70px; font-size:15px;";>Expense Not Entered for current month</div><div class = "text-center" style = "margin-top:0px; font-size:15px;";>(Add Some Expenses)</div>'; }
				?>
				<script>
				var colors = {
				primary        : "#6571ff",
				secondary      : "#7987a1",
				success        : "#05a34a",
				info           : "#66d1d1",
				warning        : "#fbbc06",
				danger         : "#ff3366",
				light          : "#e9ecef",
				dark           : "#060c17",
				muted          : "#7987a1",
				gridBorder     : "rgba(77, 138, 240, .15)",
				bodyColor      : "#000",
				cardBg         : "#fff",
				orange		   : "#f78307",	
				electriclime   : "#ccff00",	
				purple   	   : "#660066"	
			  }

			  var fontFamily = "'Roboto', Helvetica, sans-serif"
			  
				new Chart($('#expmonth'), {
				  type: 'pie',
				  data: {
					labels: <?php echo json_encode($label2) ?>,
					datasets: [{
					  label: "Expense",
					  backgroundColor: [colors.primary, colors.orange, colors.electriclime, colors.purple, colors.danger, colors.info, colors.warning, colors.muted, colors.success],
					  borderColor: colors.cardBg,
					  data: <?php echo json_encode($data2) ?>
					}]
				  },
				  options: {
					plugins: {
					  legend: { 
						display: true,
						position: 'right',
						labels: {
						  color: colors.bodyColor,
						  font: {
							size: '13px',
							family: fontFamily
						  }
						}
					  },
					},
					aspectRatio: 2,
				  }
				});
				</script>
			  </div>
			</div>
			</div>
			
			<div class="col-6 col-xl-4 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline">
                  <h6 class="card-title mb-0"><?php echo date('Y'); ?> Spending Per Category</h6>
                </div>
				<div class="row align-items-start">
                  <div class="col-md-0">
                    <p class="text-muted tx-13 mb-3 mt-2 mb-md-0">Your Expenditure Per Category For year <?php echo date('Y'); ?>. Hover on colors to see how much you spent.</p>
                  </div>
                </div>
				<?php 
				include "config.php"; 
				$sqlyear = "SELECT *, sum(e.expense_amount) as se FROM expense e JOIN category c ON e.category_id = c.category_id WHERE e.id = $id AND YEAR(expense_date) = YEAR(now()) GROUP BY e.category_id;";
				$resultyear = $conn->query($sqlyear);
				$resultyear = $resultyear->fetchAll(PDO::FETCH_OBJ);
				$rowyear = count($resultyear);
				
				if($rowyear>0) {
					foreach($resultyear as $r) {
						$expense_amount_year = $r->se;
						$category_name_year = $r->category_name;
						
						$datayear[] = $expense_amount_year;
					$labelyear[] = $category_name_year; }
						
				echo '<canvas id="expyear" class="mt-2"></canvas>'; } else { echo '<div class = "text-center" style = "margin-top:70px; font-size:15px;";>Expense Not Entered for current year</div><div class = "text-center" style = "margin-top:0px; font-size:15px; margin-bottom:70px;";>(Add Some Expenses)</div>'; }
				?>
				<script>
				var colors = {
				primary        : "#6571ff",
				secondary      : "#7987a1",
				success        : "#05a34a",
				info           : "#66d1d1",
				warning        : "#fbbc06",
				danger         : "#ff3366",
				light          : "#e9ecef",
				dark           : "#060c17",
				muted          : "#7987a1",
				gridBorder     : "rgba(77, 138, 240, .15)",
				bodyColor      : "#000",
				cardBg         : "#fff",
				orange		   : "#f78307",	
				electriclime   : "#ccff00",	
				purple   	   : "#660066"	
			  }

			  var fontFamily = "'Roboto', Helvetica, sans-serif"
			  
				new Chart($('#expyear'), {
				  type: 'pie',
				  data: {
					labels: <?php echo json_encode($labelyear) ?>,
					datasets: [{
					  label: "Expense",
					  backgroundColor: [colors.primary, colors.danger, colors.info, colors.warning, colors.muted, colors.success, colors.electriclime, colors.orange, colors.purple],
					  borderColor: colors.cardBg,
					  data: <?php echo json_encode($datayear) ?>
					}]
				  },
				  options: {
					plugins: {
					  legend: { 
						display: true,
						position: 'right',
						labels: {
						  color: colors.bodyColor,
						  font: {
							size: '13px',
							family: fontFamily
						  }
						}
					  },
					},
					aspectRatio: 2,
				  }
				});
				</script>
			  </div>
			</div>
			</div>
		</div>
		   <!--<div class = "row">  
          
		  <div class="col-6 col-xl-3 grid-margin stretch-card">
            <div class="card overflow-hidden">
              <div class="card-body">
<div class="globe mt-5"><script type="text/javascript" src="//rf.revolvermaps.com/0/0/6.js?i=5eznm6yqt2r&amp;m=6&amp;c=ff0000&amp;cr1=ffffff&amp;f=arial&amp;l=0" async="async"></script></div>
</div>
</div>
</div>
		  </div>-->
		  
         <!-- row -->
<!--<div class="col-6 col-xl-4 grid-margin stretch-card">
            <div class="card overflow-hidden" style="height:550px;">
              <div class="card-body">
			  <h6 class="card-title mb-0">Month Spending Per Category</h6>
			  <div class="row align-items-start">
                  <div class="col-md-12">
                    <p class="text-muted tx-13 mb-3 mb-md-0">This group will show your expenditure per category of today. This will be helpful for you to see where in which domain you spend the most in a day.</p>
                  </div>
                  
                </div>
                <div class="d-flex justify-content-between align-items-baseline mb-0 mb-md-0">
                  <div id="piechart2" style="width: 900px; height: 500px;"></div>
                </div>
              </div>
            </div>
          </div>-->

        <div class="row">
          <div class="col-lg-7 col-md-7 stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                  <h6 class="card-title mb-0">Your Top 5 Expenses</h6>
                </div>
                <div class="table-responsive">
				<?php include "pagination.php"; $sqle = "SELECT * FROM expense e JOIN category c ON e.category_id = c.category_id WHERE e.id = $id ORDER BY e.expense_amount DESC limit 5";
$resulte = $conn->query($sqle);
$resulte = $resulte->fetchAll(PDO::FETCH_OBJ);
$rowe = count($resulte);
 ?>
                  <table class="table table-hover mb-3">
                    <thead>
                      <tr>
                        <th>Index</th>
						<th>Expense Amount</th>
						<th>Expense Date</th>
						<th>Expense Category</th>
						<th>Expense Description</th>
                      </tr>
                    </thead>
					
					<?php
					$index = 0;
						if($rowe>0) {
						foreach($resulte as $rse) {
						$expense_id = $rse->expense_id;
						$expense_amount = $rse->expense_amount;
						$expense_date = $rse->expense_date;
						$category_name = $rse->category_name;
						$expense_description = $rse->expense_description;
						$index++;
					?>
											
                    <tbody>
                      <tr>
                        <th><?php echo $index; ?></th>
													<td><?php echo $expense_amount; ?> ₹</td>
													<td><?php echo $expense_date; ?></td>
													<td><?php echo $category_name; ?></td>
													<td><?php echo $expense_description; ?></td>
                      </tr>
					  <?php }} $conn = null;?>
                    </tbody>
                  </table>
				  
                </div>
              </div> 
            </div>
          </div>
		  <div class="col-lg-5 col-md-5 stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                  <h6 class="card-title mb-0">Your Top 5 Income</h6>
                </div>
                <div class="table-responsive">
		<?php include 'config.php'; $sqli = "SELECT * FROM income i JOIN incomecategory c ON i.i_category_id = c.i_category_id AND i.id = :id ORDER BY i.income_amount DESC limit 5";
$datai = array(":id" => $id);

    $resulti = $conn->prepare($sqli);
    $resulti->execute($datai);
$resulti = $resulti->fetchAll(PDO::FETCH_OBJ);
$rowi = count($resulti); ?>
                  <table class="table table-hover mb-3">
                    <thead>
                      <tr>
                        <th>Index</th>
						<th>Income Amount</th>
						<th>Income Date</th>
						<th>Income Category</th>
                      </tr>
                    </thead>
					
					<?php $index = 0;
											if($rowi>0) {
												foreach($resulti as $rsi) {
													$income_id = $rsi->income_id;
													$income_amount = $rsi->income_amount;
													$income_date = $rsi->income_date;
													$i_category_name = $rsi->i_category_name;
													$index++;
											?>
											
                    <tbody>
                      <tr>
                        <th><?php echo $index; ?></th>
													<td><?php echo $income_amount; ?> ₹</td>
													<td><?php echo $income_date; ?></td>
													<td><?php echo $i_category_name; ?></td>
                      </tr>
					  <?php }} $conn = null;?>
                    </tbody>
                  </table>
                </div>
              </div> 
            </div>
          </div>
        </div> <!-- row -->
		<!--<div class="row">
		<script type="text/javascript" src="//rf.revolvermaps.com/0/0/6.js?i=5aeg6np6e4z&amp;m=7&amp;c=e63100&amp;cr1=ffffff&amp;f=arial&amp;l=0&amp;bv=90&amp;lx=-420&amp;ly=420&amp;hi=20&amp;he=7&amp;hc=a8ddff&amp;rs=80" async="async"></script>
		</div>-->
		
			</div>

			<!-- partial:partials/_footer.html -->
			<footer class="footer border-top">
        <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between py-3 small" style="background-color: #F9FAFB;"">
          <p class="text-muted mb-1 mb-md-0">Copyright © 2022 <a href="https://www.nobleui.com" target="_blank">NobleUI</a>.</p>
          <p class="text-muted">Handcrafted With <i class="mb-1 text-primary ms-1 icon-sm" data-feather="heart"></i></p>
        </div>
			</footer>
			<!-- partial -->
		</div>
	</div>
</body>
</html>