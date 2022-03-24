<div class="m-login__signup">
	<div class="m-login__head">
		
	</div>
	<form class="m-login__form m-form" action="{{ route('create-workflow') }}" method="post">
		<div class="form-group m-form__group">
            <label>Workflow name:</label>
			<input class="form-control m-input" type="text" disabled placeholder="" value="{{ @$workflow->name }}" required="" name="name">
		</div>
		<div class="form-group">
            <label for="recipient-name" class="form-control-label">Metadata Fields:</label>
            {!! Form::select('fields[]', $fields, @$workflow_fields, ['class' =>'form-control select2', 'multiple']) !!}
        </div>

        @csrf

        

		
		
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
        var url = "{{ route('create-workflow') }}";
        @else
        var url = "{{ route('edit-workflow-metadata', @$workflow->id) }}";
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