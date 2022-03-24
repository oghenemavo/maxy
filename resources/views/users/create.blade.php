<style type="text/css">
    #e1 {
    width: 500px;       
}
.bigdrop{
    width: 600px !important;

}
</style>
@php
    $staff = ['General Staff'=>'General Staff', 'COMPANY ADMIN'=>'COMPANY ADMIN', 'SPECIAL ADMIN'=>'SPECIAL ADMIN', 'Limited Staff'=>'Limited Staff'];
@endphp
<div class="m-login__signup">
	<div class="m-login__head">

		<div class="m-login__desc"><h3>Enter user details:</h3></div>
	</div>
	<form class="m-login__form m-form" action="{{ route('create-user') }}" method="post">
		<div class="form-group m-form__group">
            <label>First Name</label>

			<input class="form-control m-input" type="text" placeholder="First name" value="{{ @$user->first_name }}" required="" name="first_name">
		</div>
		<div class="form-group m-form__group">
        <label>Last Name</label>
			<input class="form-control m-input" type="text" placeholder="Last name"  value="{{ @$user->last_name }}" required="" name="last_name">
		</div>

		<div class="form-group m-form__group">

        <label>Staff ID</label>
			<input class="form-control m-input" type="text" placeholder="Staff ID"  value="{{ @$user->username }}" required="" name="username">

		</div>
		{{-- <div class="form-group m-form__group">
			<input class="form-control m-input" type="text" placeholder="Staff Id"  value="{{ @$user->staff_id }}" required="" name="staff_id">
		</div> --}}
		@csrf
		<div class="form-group m-form__group">

        <label>Email</label>
			<input class="form-control m-input" type="text" placeholder="Email" required=""  value="{{ @$user->email }}" name="email" autocomplete="off">

		</div>

        @if(!$isEdit)
		<div class="form-group m-form__group">

        <label>Password</label>
			<input class="form-control m-input" type="password" id="password" placeholder="Password" required="" name="password">

		</div>
		<div class="form-group m-form__group">
        <label>Confirm Password</label>
			<input class="form-control m-input m-login__form-input--last" type="password" placeholder="Confirm Password" required="" name="rpassword">
		</div>
        @endif

        @if(in_array(Auth::user()->access_type, [ "DATAMAX ADMIN", "COMPANY ADMIN", "SPECIAL ADMIN" ]))  

        <select class="form-control" name="access_type">
   
            <option>Choose staff access</option>
            
            @foreach ($staff as $key => $value)
                <option value="{{ $key }}" {{ ( $key == $user->access_type) ? 'selected' : '' }}> 
                    {{ $value }} 
                </option>
            @endforeach    
        </select>
        @endif
		
        <div class="form-group m-form__group">
            <label>Groups</label>
            <select name="groups[]" class="form-control select2" id="e1" multiple="" width="200px">
                @foreach($groups as $group)
                    <option value="{{ $group->id }}" {!! ( in_array($group->id, $groupIds) ) ? 'selected="selected"': "" !!} >  {{ $group->name }} </option>
                @endforeach
            </select>
        </div>

		<div class="m-login__form-action">
			<input type="submit" id="m_login_signup_submit" value="@if($isEdit) Update @else Create @endif" class="btn-primary btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">&nbsp;&nbsp;
			<!-- <button id="m_login_signup_cancel" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn">Cancel</button> -->
		</div>
	</form>
</div>

<script type="text/javascript">
$('.select2').select2({dropdownCssClass : 'bigdrop', 'width': '300px'});

     @if(!$isEdit)
    var url = "{{ route('create-user') }}";
    @else
    var url = "{{ route('edit-user', @$user->id) }}";
    @endif

	$("#m_login_signup_submit").click(function(l) {
                l.preventDefault();
                var t = $(this),
                    r = $(this).closest("form");
                r.validate({
                    rules: {
                        first_name: {
                            required: !0
                        },
                        last_name: {
                            required: !0
                        },
                        staff_id: {
                            required: !0
                        },
                        username: {
                            required: !0
                        },
                        email: {
                            required: !0,
                            email: !0
                        },
                        password: {
                            required: !0
                        },
                        rpassword: {
                            required: !0,
                            equalTo: "#password"
                        },
                        agree: {
                            required: !0
                        }
                    }
                }), r.valid() && (t.addClass("m-loader m-loader--right m-loader--light").attr("disabled", !0), r.ajaxSubmit({
                    url: url,
                    success: function(l, s, n, o) {

                    	if(l.status == 200){
	                        window.location.href = "";
                    	}else{

                            swal({type:"error",title:l.data,showConfirmButton:!1,timer:5000});
                        }

                    }
                }))
            });

</script>