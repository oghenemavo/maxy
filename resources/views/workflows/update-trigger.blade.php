<div class="m-login__signup">
	<div class="m-login__head">
		
	</div>
	<form class="m-login__form m-form" action="#" method="post">
		<div class="form-group m-form__group">
            <label>If metadata field:</label>
			{!! Form::select('user_field_id', $fields, @$trigger->user_field_id, ['id' => 'user_field_id', 'class'=>'form-control m-input', 'required']) !!}
		</div>

        <div class="form-group m-form__group">
            
            {!! Form::select('operator', config('constants.operators'), @$trigger->operator, ['class'=>'form-control m-input', 'required']) !!}
        </div>

        <div class="form-group m-form__group">
            {!! Form::text('value', @$trigger->value, ['id' => 'trigger_value', 'class'=>'form-control m-input']) !!}
            {!! Form::select('value_drop', [], null, ['id' => 'trigger_value_drop', 'class'=>'form-control m-input' ]) !!}
        </div>


        <div class="form-group m-form__group">
            <label>Then move to step:</label>
            {!! Form::select('new_step_id', $otherSteps, @$trigger->new_step_id, ['class'=>'form-control m-input', 'required']) !!}
        </div>


         <div class="form-group m-form__group">
            <label>Rank:</label>
            {!! Form::number('rank', @$trigger->rank, ['class'=>'form-control m-input', 'required']) !!}
        </div>

        @csrf

        {!! Form::hidden('workflow_step_id', $step_id) !!}
        {!! Form::hidden('option', '') !!}

        <input type="hidden" name="isdropdown" value="0" id="isdropdown">


		<div class="m-login__form-action">
			<input type="submit" id="m_login_signup_submit" value="@if($isEdit) Update @else Create @endif" class="btn-primary btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">&nbsp;&nbsp;
			<!-- <button id="m_login_signup_cancel" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn">Cancel</button> -->
		</div>
	</form>
</div>



<script type="text/javascript">

    $(document).ready(function () {
        //Hide dropdown onload
        $("#trigger_value_drop").hide();
        $('.select2').select2({dropdownCssClass : 'bigdrop', 'width': '300px'});

                @if(!$isEdit)
        var url = "{{ route('update-step-trigger', [ $step_id ] ) }}";
                @else
        var url = "{{ route('update-step-trigger', [ $step_id, @$trigger->id ] ) }}";
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

        $("#user_field_id").on('change', function () {
            var metaData = $(this).val();
            var fieldsType = @json($fieldsType);
            var metadataType = fieldsType[metaData];
            if(metadataType == 'Dropdown') {
                //Show Dropdown of possible value list
                var valueListItems = @json($valueListItems)[metaData];

                var $el = $("#trigger_value_drop");
                $el.empty(); // remove old options
                $.each(valueListItems, function(key,value) {
                    $el.append($("<option></option>").attr("value", value).text(value));
                });

                $('#trigger_value').hide();
                $('#trigger_value_drop').show();
                $('#isdropdown').val(1);
            } else {
                $('#trigger_value').show();
                $('#trigger_value_drop').hide();
                $('#isdropdown').val(0);
            }
        });

    });


</script>

