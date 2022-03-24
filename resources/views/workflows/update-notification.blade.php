<div class="m-login__signup">
    @php
        if($notification && $isEdit) {
            if($notification->recipient_type == 'USER')
                $recipient = getUserName($notification->recipient_id);
            else if($notification->recipient_type == 'GROUP')
                $recipient = getGroupName($notification->recipient_id);
            else 
                $recipient  =   'Initiator';    
        }
    @endphp
	<div class="m-login__head">
		
	</div>
	<form class="m-login__form m-form" action="#" method="post">
		<div class="form-group m-form__group">       
            <label>Recipient:</label>
			{!! Form::select('recipient_id', $recipients, '', [
			        'class'=>'form-control m-input', 'required',
			        'id' => 'recipient_id'
			    ])
            !!}
            
		</div>

        <div class="form-group m-form__group">
			
            <label>Notification message template:</label>
            <textarea  class="form-control m-input" name="template" rows="5" required>{{ @$notification->template }}</textarea>
            <div class="help-text">You can include the workflow metadata in the template. The system will auto replace them when sending message. <br/>Metadata are: <em>{{ $metaNames }}</em></div>
		</div>

        @csrf

        
        {!! Form::hidden('workflow_step_id', $step_id) !!}
        {!! Form::hidden('recipient_type', '', [ 'id' => 'recipient_type' ]) !!}


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
            var url = "{{ route('update-step-notification', [ $step_id, null ] ) }}";
        @else
            var url = "{{ route('update-step-notification', [ $step_id, @$notification->id ] ) }}";

            @if($recipient) 
                var text1 = "{{$recipient}}";
                $("#recipient_id option").filter(function() {
                //may want to use $.trim in here
                return $(this).text() == text1;
                }).prop('selected', true);          
            @endif
            
        @endif

    	$("#m_login_signup_submit").click(function(l) {
                    l.preventDefault();

                    //Get Selected opt group label either USER / GROUP
                    var selected = $('#recipient_id :selected');                 
                    var group = selected.parent().attr('label');
                    // var group = selected.parent().attr('label');
                    console.log(group)
                    $("#recipient_type").val(group);
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
