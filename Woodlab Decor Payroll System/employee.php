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
						<span><b>Employee List</b></span>
						<button class="btn btn-dark btn-sm btn-block col-md-3 float-right" style="background-color:#115173;" type="button" id="new_emp_btn"><span class="fa fa-plus"></span> Add Employee</button>
					</div>
					<div class="card-body">
						<table id="table" class="table table-bordered table-striped">
							<thead>
								<tr class="text-center">
									<th>Employee No</th>
									<th>Firstname</th>
									<th>Middlename</th>
									<th>Lastname</th>
									<th>Department</th>
									<th>Position</th>
									<th>View/Edit/Delete</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$d_arr[0] = "Unset";
									$p_arr[0] = "Unset";
									$dept = $conn->query("SELECT * from department order by name asc");
										while($row=$dept->fetch_assoc()):
											$d_arr[$row['id']] = $row['name'];
										endwhile;
										$pos = $conn->query("SELECT * from position order by name asc");
										while($row=$pos->fetch_assoc()):
											$p_arr[$row['id']] = $row['name'];
										 endwhile;
									$employee_qry=$conn->query("SELECT * FROM employee") or die(mysqli_error());
									while($row=$employee_qry->fetch_array()){
								?>
								<tr class="text-center">
									<td><?php echo $row['employee_no']?></td>
									<td><?php echo $row['firstname']?></td>
									<td><?php echo $row['middlename']?></td>
									<td><?php echo $row['lastname']?></td>
									<td><?php echo $d_arr[$row['department_id']]?></td>
									<td><?php echo $p_arr[$row['position_id']]?></td>
									<td>
										 <button title="View" class="btn btn-sm btn-outline-primary view_employee" data-id="<?php echo $row['id']?>" type="button"><i class="fa fa-eye"></i></button>
										 <button title="Edit" class="btn btn-sm btn-outline-success edit_employee" data-id="<?php echo $row['id']?>" type="button"><i class="fa fa-edit"></i></button>
										<button title="Delete" class="btn btn-sm btn-outline-danger remove_employee" data-id="<?php echo $row['id']?>" type="button"><i class="fa fa-trash"></i></button>
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
		</div><br>

		<div class="container-fluid " >
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header">
						<span><b>High earning employees</b></span>
					</div>
					<div class="card-body">
						<table id="table" class="table table-bordered table-striped">
							<thead>
								<tr class="text-center">
									<th>Employee No</th>
									<th>Firstname</th>
									<th>Middlename</th>
									<th>Lastname</th>
									<th>Department</th>
									<th>Position</th>
									<th>Salary</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$d_arr[0] = "Unset";
									$p_arr[0] = "Unset";
									$dept = $conn->query("SELECT * from department order by name asc");
										while($row=$dept->fetch_assoc()):
											$d_arr[$row['id']] = $row['name'];
										endwhile;
										$pos = $conn->query("SELECT * from position order by name asc");
										while($row=$pos->fetch_assoc()):
											$p_arr[$row['id']] = $row['name'];
										 endwhile;
									$employee_qry=$conn->query("SELECT * FROM high_earners") or die(mysqli_error());
									while($row=$employee_qry->fetch_array()){
								?>
								<tr class="text-center">
									<td><?php echo $row['employee_no']?></td>
									<td><?php echo $row['firstname']?></td>
									<td><?php echo $row['middlename']?></td>
									<td><?php echo $row['lastname']?></td>
									<td><?php echo $d_arr[$row['department_id']]?></td>
									<td><?php echo $p_arr[$row['position_id']]?></td>
									<td><?php echo $row['salary']?></td>
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

			

			
			$('.edit_employee').click(function(){
				var $id=$(this).attr('data-id');
				uni_modal("Edit Employee","manage_employee.php?id="+$id)
				
			});
			$('.view_employee').click(function(){
				var $id=$(this).attr('data-id');
				uni_modal("Employee Details","view_employee.php?id="+$id,"mid-large")
				
			});
			$('#new_emp_btn').click(function(){
				uni_modal("New Employee","manage_employee.php")
			})
			$('.remove_employee').click(function(){
				_conf("Are you sure to delete this employee?","remove_employee",[$(this).attr('data-id')])
			})
		});
		function remove_employee(id){
			start_load()
			$.ajax({
				url:'ajax.php?action=delete_employee',
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
