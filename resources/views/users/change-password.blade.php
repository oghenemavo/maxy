<style type="text/css">
    #e1 {
    width: 500px;       
}
.bigdrop{
    width: 600px !important;

}
</style>
<div class="m-login__signup">
	<div class="m-login__head">
		{{-- <div class="m-login__desc">Enter user details:</div> --}}
	</div>
	<form class="m-login__form m-form" action="{{ route('change-password') }}" method="post">
        {{ csrf_field() }}
		<div class="form-group m-form__group">
			<input class="form-control m-input" type="password" placeholder="Current password" value="" required="" name="curr_pass">
		</div>
		<div class="form-group m-form__group">
			<input class="form-control m-input" type="password" placeholder="New password"  value="{{ @$user->last_name }}" required="" name="new_pass" id="new_pass">
		</div>

		<div class="form-group m-form__group">
			<input class="form-control m-input" type="password" placeholder="New password again"  value="" required="" name="new_pass2">
		</div>
		

		<div class="m-login__form-action">
			<input type="submit" id="m_login_signup_submit" value="Change password" class="btn-primary btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">&nbsp;&nbsp;
			<!-- <button id="m_login_signup_cancel" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn">Cancel</button> -->
		</div>
	</form>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                                                {{ csrf_field() }}
                                                                            </form>

<script type="text/javascript">
$('.select2').select2({dropdownCssClass : 'bigdrop'});

     var url = "{{ route('change-password') }}";
    
	$("#m_login_signup_submit").click(function(l) {
                l.preventDefault();
                var t = $(this),
                    r = $(this).closest("form");
                r.validate({
                    rules: {
                        curr_pass: {
                            required: !0
                        },
                        new_pass: {
                            required: !0
                        },
                       
                        new_pass2: {
                            required: !0,
                            equalTo: "#new_pass"
                        },
                        
                    }
                }), r.valid() && (t.addClass("m-loader m-loader--right m-loader--light").attr("disabled", !0), r.ajaxSubmit({
                    url: url,
                    success: function(l, s, n, o) {

                    	if(l.status == 200){

                            $.bootstrapGrowl("Password changed successfully. Please log in again.", { type: 'success' });

                            setTimeout(function(){
                                document.getElementById('logout-form').submit();

                            }, 2000);
	                        
                    	}else{

                            $.bootstrapGrowl("Invalid current password. Please put in the correct password.", { type: 'danger' });
                        }

                    }
                }))
            });

</script>