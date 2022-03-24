<div class="m-login__signup">
	<div class="m-login__head">
		
	</div>
	<form class="m-login__form m-form" action="#" method="post">
		<div class="form-group m-form__group">
            <label>Metadata field:</label>
			{!! Form::select('user_field_id', $fields, @$condition->user_field_id, ['class'=>'form-control m-input', 'required']) !!}
		</div>

        <div class="form-group m-form__group">
            
            {!! Form::select('operator', config('constants.operators'), @$condition->operator, ['class'=>'form-control m-input', 'required', 'id'=>'condition']) !!}
        </div>

        <div class="form-group m-form__group m--hide" id="option1Div">
            {!! Form::text('value1', @$condition->value, ['class'=>'form-control m-input', 'required', 'id'=>'value1']) !!}
        </div>

        <div class="form-group m-form__group m--hide" id="option2Div"> and 
            {!! Form::text('value2', @$condition->value, ['class'=>'form-control m-input', 'required', 'id'=>'value2']) !!}
        </div>

        @csrf

        {!! Form::hidden('workflow_step_id', $step_id) !!}
        {!! Form::hidden('mode', $mode) !!}
        {!! Form::hidden('option', '') !!}


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
            var url = "{{ route('update-step-condition', [ $step_id, $mode ] ) }}";
        @else
            var url = "{{ route('update-step-condition', [ $step_id, $mode, @$condition->id ] ) }}";
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


        $("#condition").on('change', function(){

           showValueListDiv();

        });

        showValueListDiv();




            
    });

    function showValueListDiv(){
         $("#option1Div").addClass("m--hide");
            $("#value1").removeAttr('required');
            $("#option2Div").addClass("m--hide");
            $("#value2").removeAttr('required');

            var condition = $("#condition").val();
            if(condition != 'is empty' && condition != 'is not empty'){
                //enabling option 1
                $("#option1Div").removeClass("m--hide");
                $("#value1").attr('required', !0);

            }

            if(condition == 'between'){
                //enabling option 2
                $("#option2Div").removeClass("m--hide");
                $("#value2").attr('required', !0);
            }

    }


</script>