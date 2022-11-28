<?php include('db_connect.php');?>
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
	
	<div class="col-lg-12">
		<div class="row">
			<!-- FORM Panel -->
			<div class="col-md-4">
			<form action="" id="manage-deductions">
				<div class="card">
					<div class="card-header">
						  Add Deduction
				  	</div>
					<div class="card-body">
							<input type="hidden" name="id">
							<div class="form-group">
								<label class="control-label">Deduction Name</label>
								<textarea name="deduction" id="" cols="30" rows="2" class="form-control" required></textarea>
							</div>
							<div class="form-group">
								<label class="control-label">Description</label>
								<textarea name="description" id="" cols="30" rows="2" class="form-control" required></textarea>
							</div>
							
							
							
					</div>
							
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12">
								<button class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Save</button>
								<button class="btn btn-sm btn-default col-sm-3" type="button" onclick="_reset()"> Cancel</button>
							</div>
						</div>
					</div>
				</div>
			</form>
			</div>
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-8">
				<div class="card">
					<div class="card-body">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Deduction Information</th>
									<th class="text-center">Edit/Delete</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$deductions = $conn->query("SELECT * FROM deductions order by id asc");
								while($row=$deductions->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									
									<td class="">
										 <p>Name: <b><?php echo $row['deduction'] ?></b></p>
										 <p class="truncate"><small>Description: <b><?php echo $row['description'] ?></b></small></p>
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-success edit_deductions" type="button" data-id="<?php echo $row['id'] ?>" data-deduction="<?php echo $row['deduction'] ?>" data-description="<?php echo $row['description'] ?>" >Edit</button>
										<button class="btn btn-sm btn-danger delete_deductions" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
									</td>
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>	

</div>
<style>
	
	td{
		vertical-align: middle !important;
	}
	td p{
		margin: unset
	}
	img{
		max-width:100px;
		max-height:150px;
	}
</style>
<script>
	function _reset(){
		$('[name="id"]').val('');
		$('#manage-deductions').get(0).reset();
	}
	
	$('#manage-deductions').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_deductions',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully added",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
				else if(resp==2){
					alert_toast("Data successfully updated",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	})
	$('.edit_deductions').click(function(){
		start_load()
		var cat = $('#manage-deductions')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='deduction']").val($(this).attr('data-deduction'))
		cat.find("[name='description']").val($(this).attr('data-description'))
		end_load()
	})
	$('.delete_deductions').click(function(){
		_conf("Are you sure you want to delete this deduction? This action cannot be undone","delete_deductions",[$(this).attr('data-id')])
	})
	function displayImg(input,_this) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
        	$('#cimg').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}
	function delete_deductions($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_deductions',
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