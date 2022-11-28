<?php include('db_connect.php') ?>
<?php
		$pay = $conn->query("SELECT * FROM payroll where id = ".$_GET['id'])->fetch_array();
		$pt = array(1=>"Monthly",2=>"Semi-Monthly");
?>
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
	</div></br>
		<div class="container-fluid " >
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header">
						<span><b>Payroll : <?php echo $pay['ref_no'] ?></b></span>
						
						<button class="btn btn-dark btn-sm btn-block col-md-2 float-right" style="background-color:#115173;" type="button" id="new_payroll_btn"><span class="fa fa-plus"></span> Re-Caclulate Payroll</button>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
							<p>Payroll Range: <b><?php echo date("M d, Y",strtotime($pay['date_from'])). " - ".date("M d, Y",strtotime($pay['date_to'])) ?></b></p>
							<p>Payroll Type: <b><?php echo $pt[$pay['type']] ?></b></p>
							<button class="btn btn-success btn-sm btn-block col-md-2 float-right" type="button" id="print_btn"><span class="fa fa-print"></span> Print</button>
							</div>
						</div>
						<hr>
						<table id="table" class="table table-bordered table-striped">
							<thead>
								<tr class="text-center">
									<th>Employee ID</th>
									<th>Name</th>
									<th>Days Absent</th>
									<th>Days Late</th>
									<th>Total Allowance</th>
									<th>Total Deduction</th>
									<th>Net</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
									
									$payroll=$conn->query("SELECT p.*,concat(e.lastname,', ',e.firstname,' ',e.middlename) as ename,e.employee_no FROM payroll_items p inner join employee e on e.id = p.employee_id ") or die(mysqli_error());
									while($row=$payroll->fetch_array()){
								?>
								<tr class="text-center">
									<td><?php echo $row['employee_no'] ?></td>
									<td><?php echo ucwords($row['ename']) ?></td>
									<td><?php echo $row['absent'] ?></td>
									<td><?php echo $row['late'] ?></td>
									<td>Kshs. <?php echo number_format($row['allowance_amount'],2) ?></td>
									<td>Kshs. <?php echo number_format($row['deduction_amount'],2) ?></td>
									<td>Kshs. <?php echo number_format($row['net'],2) ?></td>
									<td>
									
										 <button class="btn btn-sm btn-outline-primary view_payroll" data-id="<?php echo $row['id']?>" type="button"><i class="fa fa-eye"></i> View</button>
									
									</td>
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
			
		
		
	<script type="text/javascript">
		$(document).ready(function(){
			$('#table').DataTable();
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){

			

			$('#print_btn').click(function(){
				var nw = window.open("print_payroll.php?id=<?php echo $_GET['id'] ?>","_blank","height=500,width=800")
				setTimeout(function(){
					nw.print()
					setTimeout(function(){
						nw.close()
						},500)
				},1000)
			})

			
			
			$('.view_payroll').click(function(){
				var $id=$(this).attr('data-id');
				uni_modal("Employee Payslip","view_payslip.php?id="+$id,"large")
				
			});
			
			$('#new_payroll_btn').click(function(){
				start_load()
				$.ajax({
					url:'ajax.php?action=calculate_payroll',
					method:"POST",
					data:{id:'<?php echo $_GET['id'] ?>'},
					error:err=>console.log(err),
					success:function(resp){
							if(resp == 1){
								alert_toast("Payroll successfully computed","success");
									setTimeout(function(){
									location.reload();

								},1000)
							}
						}
				})
			})
		});
		function remove_payroll(id){
			start_load()
			$.ajax({
				url:'ajax.php?action=delete_payroll',
				method:"POST",
				data:{id:id},
				error:err=>console.log(err),
				success:function(resp){
						if(resp == 1){
							alert_toast("Employee's data successfully deleted","success");
								setTimeout(function(){
								location.reload();

							},1000)
						}
					}
			})
		}
	</script>
