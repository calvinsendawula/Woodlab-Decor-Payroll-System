<?php 

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
<div class="container-fluid">
	
	<div class="row">
		<div class="col-lg-2"></div>
	<div class="col-lg-7">
		<button class="btn btn-dark float-right" id="new_user" style="background-color:#115173;"><i class="fa fa-plus"></i>Add New User</button>
	</div>
	</div>
	<br>
	<div class="row">
		<div class="col-lg-2"></div>
		<div class="card col-lg-7">
			<div class="card-body">
				<table class="table-striped table-bordered col-md-12">
			<thead>
				<tr class="text-center">
					<th class="text-center">#</th>
					<th class="text-center">Name</th>
					<th class="text-center">Username</th>
					<th class="text-center">Edit/Delete</th>
				</tr>
			</thead>
			<tbody>
				<?php
 					include 'db_connect.php';
 					$users = $conn->query("SELECT * FROM users order by name asc");
 					$i = 1;
 					while($row= $users->fetch_assoc()):
				 ?>
				 <tr class="text-center">
				 	<td>
				 		<?php echo $i++ ?>
				 	</td>
				 	<td>
				 		<?php echo $row['name'] ?>
				 	</td>
				 	<td>
				 		<?php echo $row['username'] ?>
				 	</td>
				 	<td>
						<div class="btn-group">
							<button type="button" class="btn btn-success">Action</button>
							<button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<span class="sr-only">Toggle Dropdown</span>
							</button>
							<div class="dropdown-menu">
							<a class="dropdown-item edit_user" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>Edit</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item delete_user" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>Delete</a>
							</div>
						</div>
				 	</td>
				 </tr>
				<?php endwhile; ?>
			</tbody>
		</table>
			</div>
		</div>
	</div>

</div>
<script>
	
$('#new_user').click(function(){
	uni_modal('New User','manage_user.php')
})
$('.edit_user').click(function(){
	uni_modal('Edit User','manage_user.php?id='+$(this).attr('data-id'))
})
$('.delete_user').click(function(){
		_conf("Are you sure to delete this user?","delete_user",[$(this).attr('data-id')])
	})
	function delete_user($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_user',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>