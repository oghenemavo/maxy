<h5>Permisions</h5>
<table id="permissionsTable" class="table">
<thead>
	<tr>
		<th>Actor</th>
		<th>Read?</th>
		<th>Write?</th>
		<th>Download?</th>
		
		<th>Lock?</th>
		<th>Check-in?</th>
		<th>Admin?</th>
		<th></th>
	</tr>
</thead >
<tbody id="permisiionData">
</tbody>

</table>


<hr>


<button class="btn btn-danger" onclick="showPermission()" >Add new </button>

<div id="selectPermissionType" style="display: none">
	<div class="form-group m-form__group"  >
		<label for="exampleSelect1">Select Permision type</label>
		<select class="form-control m-input" id="permType" onchange="permissionChange(this);">
			<option value="" >Select Permision</option>
			<option value="group" >Group</option>
			<option value="user" >User</option>
		</select>
	</div>

	<div class="form-group m-form__group" id="showUserPermissions" style="display: none;">
		<label for="exampleSelect1">Users</label>
		<select class="form-control m-input" id="userPermisionSelect" onchange="userChange(this);">
			@foreach($users as $user)
				<option value="{{ $user->id }}" > {{ $user->full_name }} </option>
			@endforeach
		</select>
	</div>

	<div class="form-group m-form__group" id="showGroupPermissions" style="display: none;">
		<label for="exampleSelect1">Groups</label>
		<select class="form-control m-input" id="groupPermissionSelect" onchange="groupChange(this);">
			@foreach($groups as $group)
				<option value="{{ $group->id }}" > {{ $group->name }} </option>
			@endforeach
		</select>
	</div>

	<div class="m-form__actions">
		<button type="reset" onclick="addPermissions()" class="btn btn-primary">Add</button>
	</div>
</div>


<script type="text/javascript">
	


	function removePermission(data) {
		
		var id = $(data).attr('data-id');
		var type = $(data).attr('data-type');
		
		$.ajax({ url:"{{ route('remove-permission') }}",
			data:{_token:"{{ csrf_token() }}", type:type, file_id:"{{ $file->id }}", id:id,  },
			type:'POST', success:function(res){
				
				// $.bootstrapGrowl("Record has been successfully deleted", { type: 'success' });
				swal({type:"success",title:"Record has been successfully deleted",showConfirmButton:!1,timer:1500})
				showPermissions();

			} });
				
	}



		showPermissions();

		function showPermission() {
			$('#selectPermissionType').show();
		}

		function doCheckBox(data) {
			var checked = 0;
			if(data.checked == true){
				 checked = 1;
		    }
	     	var id = $(data).attr('data-id');
			var property = $(data).attr('data-property');
			var type = $(data).attr('data-type');

			// Send data to Server
			$.ajax({ url:"{{ route('update-permisions') }}",
				data:{_token:"{{ csrf_token() }}", type:type, checked:checked, file_id:"{{ $file->id }}", id:id, property:property },
				type:'POST', 
				success:function(res){
					// $.bootstrapGrowl("Permission has been updated", { type: 'success' });
					// swal({title:"Permission has been updated",html:$("<div>").addClass("some-class").text("successfully."),animation:!1,customClass:"animated tada"});
					swal({type:"success",title:"Permission has been updated successfully",showConfirmButton:!1,timer:1500})
				} });
				
		}




	function showPermissions() {
	  $.ajax({ url: "{{ route('show-file-permisions') }}",
	  			data:{id:"{{ $file->id }}", _token:"{{ csrf_token() }}" },
	  			type:'POST', 
	  			success:function(res){
	  				$('#permisiionData').html(res);
	  			} });
	}
	
	function permissionChange(type) {
        var b = (type.value || type.options[type.selectedIndex].value); 
        
        $('#showGroupPermissions').hide();
        $('#showUserPermissions').hide();

        if(b == 'group'){
            $('#showGroupPermissions').show();
        }else if(b == 'user'){
            $('#showUserPermissions').show();
        }
    }

    function addPermissions() {
    	var pType = $('#permType').val();
    	var userSelect = $('#userPermisionSelect').val();
    	var groupPermission = $('#groupPermissionSelect').val();

    	var pTypeSelect = '';
    	console.log(pType);

    	if(pType == 'group'){
    		pTypeSelect = groupPermission;
    	}else{
    		pTypeSelect = userSelect;
    	}

    	// Add New Permission
    	$.ajax({ url: "{{ route('create-permission') }}",
    		data:{ id:"{{ $file->id }}", _token:"{{ csrf_token() }}", type:pType, type_id:pTypeSelect },
    		type:'POST', 
    		success:function(res){

    			if(res.status == 500){
					// $.bootstrapGrowl("Record exist already. Please try again", { type: 'danger' });
					swal({type:"error",title:"Record exist already. Please try again",showConfirmButton:!1,timer:1500})
    			}else{
	    			showPermissions();
					$('#selectPermissionType').hide(1000);
					// $.bootstrapGrowl("Permission added successfully", { type: 'success' });
					
					swal({type:"success",title:"Permission added successfully",showConfirmButton:!1,timer:1500})
    			}
    		} });
    
    }



</script>