<style type="text/css">
    #e1 {
    width: 500px;       
}
.bigdrop{
    width: 600px !important;

}
</style>
<div class="m-login__signup">
	<form class="m-login__form m-form" action="{{ route('create-user') }}" method="post">
		<div class="form-group m-form__group">
            <div class="m-login__desc">Field name:</div>
			<input class="form-control m-input" type="text" placeholder="Name" value="{{ @$field->name }}" required="" name="name">
		</div>
		<div class="form-group m-form__group">
            <div class="m-login__desc">Field title:</div>
			<input class="form-control m-input" type="text" placeholder="Title"  value="{{ @$field->title }}" required="" name="title">
		</div>

		<div class="form-group m-form__group">
            <div class="m-login__desc">Choose field type:</div>
            {!! Form::select("type", config('constants.user-field-types'), @$field->type, ['class'=>'form-control', 'required']) !!}
			
            
		</div>
		<div class="form-group m-form__group">
            <div class="m-login__desc">Enter field options (if applicable):</div>
			{!! Form::textarea('options', @$field->options, ['class'=>'form-control'])    !!}
		</div>
		@csrf

        {!! Form::hidden('id', @$field->id) !!}
		

		<div class="m-login__form-action">
			<input type="submit" id="m_login_signup_submit" value="@if(@$field) Update @else Create @endif" class="btn-primary btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">&nbsp;&nbsp;
			<!-- <button id="m_login_signup_cancel" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn">Cancel</button> -->
		</div>
	</form>
</div>

<script type="text/javascript">
$('.select2').select2({dropdownCssClass : 'bigdrop'});

     
    var url = "{{ route('store-user-field', @$field->id) }}";
    

	$("#m_login_signup_submit").click(function(l) {
                l.preventDefault();
                var t = $(this),
                    r = $(this).closest("form");
                r.validate({
                    rules: {
                        name: {
                            required: !0
                        },
                        title: {
                            required: !0
                        },
                        type: {
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

</script>