<?php

session_start();

require_once 'includes.php';

require_once("../dashboard/conn.php");

require_once '../dashboard/dbconfig4.php';

if(isset($_SESSION['tid'])){

	$user_qury=mysqli_query($conn,"SELECT * FROM lmstealmsr WHERE tid='$_SESSION[tid]'");

	$user_resalt=mysqli_fetch_array($user_qury);

	

	if($user_resalt['image']==""){

		$image_path="../profile/images/hd_dp.jpg";

	}

	else{

		$image_path="../dashboard/images/teacher/".$user_resalt['image'];

	}

}

if(isset($_GET['id'])){
	$id=mysqli_real_escape_string($conn,$_GET['id']);
	$status=mysqli_real_escape_string($conn,$_GET['status']);
	
	if($status==1){
	$to="+94".(int)$_GET['mobile'];
	$message="Your pending payment approved. Now start learning.";
	echo "<img src='http://app.newsletters.lk/smsAPI?sendsms&apikey=$sms_api_key&apitoken=$sms_api_token&type=sms&from=$sms_sender_id&to=$to&text=$message' style='display: none;'>";
	}
	
	mysqli_query($conn,"UPDATE lmspayment SET status='$status' WHERE pid='$id'");
	//echo "<script>window.location='bank_payments.php';</script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Bank Payments | Teacher Panel | Online Learning Platforms  </title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../dashboard/images/favicon.png">
    <link rel="stylesheet" href="../dashboard/vendor/bootstrap-select/dist/css/bootstrap-select.min.css">
	<!-- Datatable -->
    <link href="../dashboard/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../dashboard/css/style.css">

</head>

<body>

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <?php require_once 'navheader.php';?>

        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            
                        </div>

                        <ul class="navbar-nav header-right">
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                    <img src="../profile/images/hd_dp.jpg" width="20" alt=""/>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="admin.php" class="dropdown-item ai-icon">
                                        <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        <span class="ml-2"><?php echo $username;?></span>
                                    </a>
                                    <a href="logout.php" class="dropdown-item ai-icon">
                                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                        <span class="ml-2">Logout </span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="deznav">
            <div class="deznav-scroll">
<?php

require_once 'sidebarmenu.php';

?>
            </div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->
		
        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <!-- row -->
            <div class="container-fluid">
				    
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>All Bank Payments</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">Bank Payments</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">All Bank Payments</a></li>
                        </ol>
                    </div>
                </div>
				
				<div class="row">
					<div class="col-lg-12">
						<ul class="nav nav-pills mb-3">
							<li class="nav-item"><a href="#list-view" data-toggle="tab" class="nav-link btn-primary mr-1 show active">List View</a></li>
							<li class="nav-item"><a href="#grid-view" data-toggle="tab" class="nav-link btn-primary">Grid View</a></li>
						</ul>
					</div>
					<div class="col-lg-12">
						<div class="row tab-content">
							<div id="list-view" class="tab-pane fade active show col-lg-12">
								<div class="card">
									<div class="card-header">
										<h4 class="card-title">All Bank Payments</h4>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="example3" class="table table-bordered">
												<thead>
													<tr>
														<th>#</th>
<th>Action</th>
<th>Slip</th>
<th>Status</th>
<th>Student ID</th>
<th>Student Name</th>
<th>Subject - Grade</th>
<th>Payment</th>
<th>Bank/Branch</th>
<th>Institute</th>
<th>Payment Date</th>
<th>Payment Valid Until</th>
													</tr>
												</thead>
												<tbody>
<?php
$count=0;
$payment_qury=mysqli_query($conn,"SELECT * FROM lmspayment WHERE paymentMethod='Bank' ORDER BY status ASC");
while($payment_resalt=mysqli_fetch_array($payment_qury)){
$count++;
	
$user_qury=mysqli_query($conn,"SELECT * FROM lmsregister WHERE reid='$payment_resalt[userID]'");
$user_resalt=mysqli_fetch_array($user_qury);
?>
<tr>
<td><?php echo number_format($count,0); ?></td>
<td>	
<?php if($payment_resalt['status']==0){ ?>
<a href="bank_payaments.php?id=<?php echo $payment_resalt['pid']; ?>&status=1&mobile=<?php echo "0".(int)$user_resalt['contactnumber']; ?>" title="Approval Payment" onClick="JavaScript:return confirm('Are your sure change this payment status?');" class="badge badge-success"><i class="fa fa-check"></i> Approval</a>
<?php } ?>
<?php if($payment_resalt['status']==1){ ?>
<a href="bank_payaments.php?id=<?php echo $payment_resalt['pid']; ?>&status=0" title="Unapproval Payment" onClick="JavaScript:return confirm('Are your sure change this payment status?');" class="badge badge-danger"><i class="la la-trash-o"></i> Reject</a>
<?php } ?>	
</td>
<td>
<a href="<?php echo "$url/profile/uploadImg/".$payment_resalt['fileName']; ?>" target="_blank" class="badge badge-primary">View Slip</a>
</td>
<td>
<?php if($payment_resalt['status']==0){ ?>
<a href="approve_payment.php?pid=<?=$payment_resalt['pid']?>&inti_loca=bank_payment"><span class="badge badge-warning">Make Approve</span></a>
<?php } ?>
<?php if($payment_resalt['status']==1){ ?>
<span class="badge badge-success">Approval</span>
<?php } ?>	
</td>
<td><?php echo $user_resalt['studentno']; ?></td>
<td><?php echo $user_resalt['fullname']; ?></td>
<td><?php
$sub_qury=mysqli_query($conn,"SELECT * FROM lmssubject WHERE sid='$payment_resalt[pay_sub_id]'");
while($sub_resalt=mysqli_fetch_array($sub_qury)){
?> <?php echo $sub_resalt['name']; ?>

- 

<?php
$cl_qury=mysqli_query($conn,"SELECT * FROM lmsclass WHERE cid='$sub_resalt[class_id]'");
while($cl_resalt=mysqli_fetch_array($cl_qury)){
?> <?php echo $cl_resalt['name']; ?> <?php }} ?> 
</td>
<td>
<span class="badge badge-secondary">Pay Rs.<?php echo number_format($payment_resalt['amount'],2); ?></span>
</td>
<td><?php echo $payment_resalt['bank']; ?></td>
<td><?php echo $payment_resalt['branch']; ?></td>
<td><?php echo date_format(date_create($payment_resalt['created_at']),"M d, Y - h:i:s A"); ?></td>
<td><?php echo date_format(date_create($payment_resalt['expiredate']),"M d, Y"); ?></td>
</tr>
<?php
}
?>
												</tbody>
											</table>
										</div>
									</div>
                                </div>
                            </div>
							<div id="grid-view" class="tab-pane fade col-lg-12">
								<div class="row">
									<tbody>
<?php
$count=0;
$payment_qury=mysqli_query($conn,"SELECT * FROM lmspayment WHERE paymentMethod='Bank' ORDER BY status ASC");
while($payment_resalt=mysqli_fetch_array($payment_qury)){
$count++;
	
$user_qury=mysqli_query($conn,"SELECT * FROM lmsregister WHERE reid='$payment_resalt[userID]'");
$user_resalt=mysqli_fetch_array($user_qury);
?>
									<div class="col-lg-4 col-md-6 col-sm-6 col-12">
										<div class="card">
											<div class="card-body">
												<div class="text-center">
													<div class="profile-photo">
													<a href="<?php echo "$url/profile/uploadImg/".$payment_resalt['fileName']; ?>" target="_blank" class="badge badge-primary">View Slip</a>
													</div>
													<h3 class="mt-4 mb-1"><strong><?php echo $user_resalt['fullname']; ?></strong></h3>
													<p class="text-muted"><strong>Subject/Grade : <?php
$sub_qury=mysqli_query($conn,"SELECT * FROM lmssubject WHERE sid='$payment_resalt[pay_sub_id]'");
while($sub_resalt=mysqli_fetch_array($sub_qury)){
?> <?php echo $sub_resalt['name']; ?>

- 

<?php
$cl_qury=mysqli_query($conn,"SELECT * FROM lmsclass WHERE cid='$sub_resalt[class_id]'");
while($cl_resalt=mysqli_fetch_array($cl_qury)){
?> <?php echo $cl_resalt['name']; ?> <?php }} ?> 
</strong></p>
													<hr>
													<ul class="list-group mb-3 list-group-flush">
													<li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">Class Fee : </span><strong>Pay Rs.<?php echo number_format($payment_resalt['amount'],2); ?></strong></li>
													<li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">Bank/Branch : </span><strong><?php echo $payment_resalt['bank']; ?></strong></li>
													<li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">Institute : </span><strong><?php echo $payment_resalt['branch']; ?></strong></li>
													<li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">Pay Date : </span><strong><?php echo date_format(date_create($payment_resalt['created_at']),"M d, Y - h:i:s A"); ?></strong></li>
													<li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">Status : </span><strong>
<?php if($payment_resalt['status']==0){ ?>
<span class="badge badge-warning">Not Approval</span>
<?php } ?>
<?php if($payment_resalt['status']==1){ ?>
<span class="badge badge-success">Approval</span>
<?php } ?></strong></li>

													</ul>
<?php if($payment_resalt['status']==0){ ?>
<a href="bank_payaments.php?id=<?php echo $payment_resalt['pid']; ?>&status=1&mobile=<?php echo "0".(int)$user_resalt['contactnumber']; ?>" title="Approval Payment" onClick="JavaScript:return confirm('Are your sure change this payment status?');" class="badge badge-success btn-rounded mt-3 px-4"><i class="fa fa-check"></i> Approval</a>
<?php } ?>
<?php if($payment_resalt['status']==1){ ?>
<a href="bank_payaments.php?id=<?php echo $payment_resalt['pid']; ?>&status=0" title="Unapproval Payment" onClick="JavaScript:return confirm('Are your sure change this payment status?');" class="badge badge-danger btn-rounded mt-3 px-4"><i class="la la-trash-o"></i> Reject</a>
<?php } ?>
												</div>
											</div>
										</div>
									</div>
<?php
}
?>
								</div>
							</div>
						</div>
					</div>
				</div>
				
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->


        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>Copyright © Designed &amp; Developed by <a href="https://yogeemedia.com" target="_blank">Yogeemedia</a> 2021</p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->

		<!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="../dashboard/vendor/global/global.min.js"></script>
    <script src="../dashboard/js/deznav-init.js"></script>	
	<script src="../dashboard/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="../dashboard/js/custom.min.js"></script>
	
	<!-- Datatable -->
    <script src="../dashboard/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../dashboard/js/plugins-init/datatables.init.js"></script>
	
    <!-- Svganimation scripts -->
    <script src="../dashboard/vendor/svganimation/vivus.min.js"></script>
    <script src="../dashboard/vendor/svganimation/svg.animation.js"></script>
	
</body>
</html>