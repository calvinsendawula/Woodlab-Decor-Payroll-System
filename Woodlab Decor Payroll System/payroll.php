<?php include('db_connect.php') ?>
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
						<span><b>Payroll List</b></span>
						<button class="btn btn-dark btn-sm btn-block col-md-3 float-right" style="background-color:#115173;" type="button" id="new_payroll_btn"><span class="fa fa-plus"></span> Add Payroll</button>
					</div>
					<div class="card-body">
						<table id="table" class="table table-bordered table-striped">
							<thead>
								<tr class="text-center">
									<th>Reference No</th>
									<th>Start Date</th>
									<th>End Date</th>
									<th>Status</th>
									<th>View/Edit/Delete</th>
								</tr>
							</thead>
							<tbody>
								<?php
									
									$payroll=$conn->query("SELECT * FROM payroll order by date(date_from) desc") or die(mysqli_error());
									while($row=$payroll->fetch_array()){
								?>
								<tr class="text-center">
									<td><?php echo $row['ref_no']?></td>
									<td><?php echo date("M d, Y",strtotime($row['date_from'])) ?></td>
									<td><?php echo date("M d, Y",strtotime($row['date_to'])) ?></td>
									<?php if($row['status'] == 0): ?>
									<td class="text-center"><span class="badge badge-primary">New</span></td>
									<?php else: ?>
									<td class="text-center"><span class="badge badge-success">Calculated</span></td>
									<?php endif ?>
									<td>
									<?php if($row['status'] == 0): ?>
										 <button class="btn btn-sm btn-outline-primary calculate_payroll" data-id="<?php echo $row['id']?>" type="button">Calculate</button>
									<?php else: ?>
										 <button title="View" class="btn btn-sm btn-outline-primary view_payroll" data-id="<?php echo $row['id']?>" type="button"><i class="fa fa-eye"></i></button>
									<?php endif ?>

										<button title="Edit" class="btn btn-sm btn-outline-success edit_payroll" data-id="<?php echo $row['id']?>" type="button"><i class="fa fa-edit"></i></button>
										<button title="Delete" class="btn btn-sm btn-outline-danger remove_payroll" data-id="<?php echo $row['id']?>" type="button"><i class="fa fa-trash"></i></button>
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

			

			
			$('.edit_payroll').click(function(){
				var $id=$(this).attr('data-id');
				uni_modal("Edit Employee","manage_payroll.php?id="+$id)
				
			});
			$('.view_payroll').click(function(){
				var $id=$(this).attr('data-id');
				location.href = "index.php?page=payroll_items&id="+$id;
				
			});
			$('#new_payroll_btn').click(function(){
				uni_modal("New Payroll","manage_payroll.php")
			})
			$('.remove_payroll').click(function(){
				_conf("Are you sure to delete this payroll?","remove_payroll",[$(this).attr('data-id')])
			})
			$('.calculate_payroll').click(function(){
				start_load()
				$.ajax({
					url:'ajax.php?action=calculate_payroll',
					method:"POST",
					data:{id:$(this).attr('data-id')},
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
