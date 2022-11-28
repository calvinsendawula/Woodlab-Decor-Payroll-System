<?php include 'db_connect.php' ?>
<style>
   
</style>

<div style="margin-top:-64px;margin-left:3px;">
	<div class="row" style="background: #115173;border:none;">
		<div class="container-fluid mt-2 mb-2">
			<div class="col-lg-12">
				<div class="col-md-1 float-left" style="display: flex;">
				
				</div>
				<div class="col-md-5 float-left text-white">
					<h4>Woodlab Decor Payroll Management System</h4>
				</div>
				<div class="col-md-3 float-right text-white mt-2 mb-2">
					<!-- <a href="ajax.php?action=logout" class="text-white"><?php //echo $_SESSION['login_name'] ?>&emsp; <i class="fa fa-power-off"></i></a> -->
					<text class="text-white" style="padding-top:30px;">Logged in as <?php echo $_SESSION['login_name'] ?></text>
					<a href="ajax.php?action=logout" title="Logout"><button class="float-right btn btn-outline-danger">Logout<i class="fa fa-power-off"></i></button></a>
				</div>
			</div>
		</div>
	</div>
	<div class="row mt-3 ml-3 mr-3">
			<div class="col-lg-12" style="background: #022c43;">
                <div class="card" style="background: #022c43;border:none;">
                    <div class="card-body text-white" style="background: #022c43;border:none;">
                    <?php echo "<h5>Currently logged in as: <b>". $_SESSION['login_name']."</b></h5>"  ?>
                                        
                    </div>
                    
                </div>
            </div>
	</div>


</div>
<script>
	
</script>