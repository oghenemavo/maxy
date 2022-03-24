<style type="text/css">
    #e1 {
    width: 500px;
}
.bigdrop{
    width: 600px !important;

}
</style>

<link href="{{ asset('assets/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.css" rel="stylesheet">

<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js"></script>


<div class="m-login__signup">
    <form class="m-login__form m-form" action="{{ route('store-folder') }}" method="post">
        {!! Form::hidden('folder_id', @$folder->id) !!}

                        <div class="form-group">
                            <label for="recipient-name" class="form-control-label">Name:</label>
                            {!! Form::text('name', @$folder->name, ['class' =>'form-control']) !!}
                        </div>

                        @if(@$parent_id == 1)

                           {{--  <div class="form-group">
                                <label for="recipient-name" class="form-control-label">Parent folder:</label>
                                {!! Form::select('parent_id', $folders, (@$folder) ? $folder->parent_id : $parent_id, ['class' =>'form-control', ]) !!}
                            </div> --}}

                            {{ Form::hidden('parent_id', 1) }}

                        
                    <div class="form-group">
                        <label for="recipient-name" class="form-control-label">Workflow:</label>
                        {!! Form::select('workflow_id', $workflows, (@$folder) ? $folder->workflow_id : '', ['class' =>'form-control']) !!}
                    </div>

                

                        
                        <div class="form-group">
                            <label for="recipient-name" class="form-control-label">Compulsory Metadata Fields:</label>
                            <select name="compulsory_fields[]" class="form-control select2" multiple="multiple">
                                @foreach($customFieldsList as $field)
                                    <option value="{{ $field['id'] }}" {{ in_array($field['id'],$compulsory_field_ids) ? 'selected' : '' }}>
                                        {{ $field['name'] }}
                                    </option>
                                @endforeach
                            </select>
{{--                            {!! Form::select('compulsory_fields[]', $fields, @$compulsory_field_ids, ['class' =>'form-control select2', 'multiple']) !!}--}}
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="form-control-label">Other Metadata Fields:</label>
                            <select name="fields[]" class="form-control select2" multiple="multiple">
                                @foreach($customOtherFields as $field => $id)
                                    <option value="{{$id }}" {{ in_array($id,$other_field_ids) ? 'selected' : '' }}>
                                        {{ $field }}
                                    </option>
                                @endforeach
                            </select>
{{--                            {!! Form::select('fields[]', $defaultFields, @$other_field_ids, ['class' =>'form-control select2', 'multiple']) !!}--}}
                        </div>

                
                @else

                          {!! Form::hidden('preset_parent_id', $parent_id) !!}
                          {!! Form::hidden('parent_id', $parent_id) !!}


                @endif

                <div class="form-group">
                    <label for="message-text" class="form-control-label">Create Template:</label>
                    <textarea class="form-control" name="description" id="description" rows="8">{{ @$folder->description }}</textarea>
                </div>

            @csrf


        <div class="m-login__form-action">

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="m_login_signup_submit" class="btn-primary btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">{{ (isset($folder->id))?"Update":"Create" }} Category</button>
            </div>

        </div>
    </form>
</div>



<script type="text/javascript">
$('.select2').select2({dropdownCssClass : 'bigdrop', width: '350px'});

$(window).on('load', function() {
                $('body').removeClass('m-page--loading');
                $(".m-select2").select2({placeholder:"Select a state"});
        });

    var url = "{{ route('store-folder', [(@$folder) ? $folder->parent_id : $parent_id , @$folder->id]) }}";

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

                        if(l.success){

                            toastr.success(l.message, "Success");
                            setTimeout('location.reload()',1000);

                        }else{

                            toastr.error(l.message, "Error");
                            t.removeClass("m-loader m-loader--right m-loader--light").removeAttr("disabled");
                        }

                    }
                }))
            });

</script>
<script>
$(document).ready(function() {

$('#description').summernote({

  height:300,

});

$(".select2").on("select2:select", function (evt) {
    var element = evt.params.data.element;
    var $element = $(element);
    $element.detach();
    $(this).append($element);
    $(this).trigger("change");
});

});
</script>
