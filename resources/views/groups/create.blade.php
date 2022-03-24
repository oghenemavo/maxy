<div class="m-login__signup">
	<div class="m-login__head">
		<div class="m-login__desc">Enter  details:</div>
	</div>
	<form class="m-login__form m-form" action="{{ route('create-group') }}" method="post">
		<div class="form-group m-form__group">
			<input class="form-control m-input" type="text" placeholder="Name of the group/ department" value="{{ @$group->name }}" required="" name="name">
		</div>
		<div class="form-group m-form__group">
			
            <label>Description</label>
            <textarea  class="form-control m-input" name="details"> 
                {{ @$group->details }}
            </textarea>
		</div>

        @csrf

        <div class="form-group m-form__group">
            <label>Users</label>
            <select name="users[]" class="form-control select2" id="e1" multiple="" width="200px">
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {!! ( in_array($user->id, $userIds) ) ? 'selected="selected"': "" !!} > {{ $user->first_name.' '.$user->last_name }} </option>
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
    
    $(document).ready(function () {

        $('.select2').select2({dropdownCssClass : 'bigdrop', 'width': '300px'});
        
        @if(!$isEdit)
        var url = "{{ route('create-group') }}";
        @else
        var url = "{{ route('edit-group', @$group->id) }}";
        @endif

    	$("#m_login_signup_submit").click(function(l) {
                    l.preventDefault();
                    var t = $(this),
                        r = $(this).closest("form");
                    r.validate({
                        rules: {
                            name: {
                                required: !0
                            },
                        }
                    }), r.valid() && (t.addClass("m-loader m-loader--right m-loader--light").attr("disabled", !0), r.ajaxSubmit({
                        url: url,
                        success: function(l, s, n, o) {

                        	if(l.status == 200){
    	                        window.location.href = "";
                        	}

                        }
                    }))
                });
    });


</script>