<div class="m-login__signup">
    <div class="m-login__head">

    </div>
    <form class="m-login__form m-form" action="#" method="post">
        <div class="form-group m-form__group">
            <label>Move to step:</label>
            {!! Form::select('new_step_id', $otherSteps, @$trigger->new_step_id, ['class'=>'form-control m-input', 'required']) !!}
        </div>


        <div class="form-group m-form__group">
            <label>Rank:</label>
            {!! Form::number('rank', @$trigger->rank, ['class'=>'form-control m-input', 'required']) !!}
        </div>

        @csrf

        {!! Form::hidden('workflow_step_id', $step_id) !!}
        {!! Form::hidden('option', '') !!}

        <div class="m-login__form-action">
            <input type="submit" id="m_login_signup_submit" value="Update" class="btn-primary btn m-btn m-btn--pill
             m-btn--custom m-btn--air m-login__btn m-login__btn--primary">&nbsp;&nbsp;
        </div>
    </form>
</div>

<script type="text/javascript">

    $(document).ready(function () {

        $('.select2').select2({dropdownCssClass : 'bigdrop', 'width': '300px'});

        var url = "{{ route('combined-trigger-action', [ $step_id, @$trigger->id ] ) }}";

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
