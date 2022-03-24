@extends('layouts.main')

@section('content')


<div class="m-grid__item m-grid__item--fluid  m-grid m-grid--ver-desktop m-grid--desktop m-page__container m-body">

    <div class="m-grid__item m-grid__item--fluid m-wrapper">

                    <!-- BEGIN: Subheader -->
                    <div class="m-subheader ">
                        <div class="d-flex align-items-center">
                            <div class="mr-auto">
                                <h3 class="m-subheader__title m-subheader__title--separator">Edit file</h3>

                            </div>
                            <div>
                                <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push m--hide" m-dropdown-toggle="hover" aria-expanded="true">
                                    <a href="#" class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--outline-2x m-btn--air m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
                                        <i class="la la-plus m--hide"></i>
                                        <i class="la la-ellipsis-h"></i>
                                    </a>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- END: Subheader -->


                    
                    <div class="m-content">

<form class="m-login__form m-form" action="{{ route('edit-file', [$file->id]) }}" method="post">

    @csrf
    {!! Form::hidden('file_id', @$file->id) !!}

    <div class="row">
                            <div class="col-lg-6">

                                <!--begin::Portlet-->
                                <div class="m-portlet">
                                    <div class="m-portlet__head">
                                        <div class="m-portlet__head-caption">
                                            <div class="m-portlet__head-title">
                                                <span class="m-portlet__head-icon">
                                                    <i class="flaticon-map-location"></i>
                                                </span>
                                                
                                            </div>
                                        </div>
                                        <div class="m-portlet__head-tools m--hide">
                                            <ul class="m-portlet__nav">
                                                <li class="m-portlet__nav-item">
                                                    <a href="" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-close"></i></a>
                                                </li>
                                                <li class="m-portlet__nav-item">
                                                    <a href="" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-refresh"></i></a>
                                                </li>
                                                <li class="m-portlet__nav-item">
                                                    <a href="" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-circle"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="m-portlet__body">
                                        <dl>
                                            <dt>Name:</dt>
                                            <dd>{{ $file->name }}</dd>

                                            <dt>Type:</dt>
                                            <dd>{{ $file->type }}</dd>

                                            <dt>Category:</dt>
                                            <dd>{{ @$file->folder->name }}</dd>

                                        </dl>
                                    </div>

                                    <hr/>

                                    <div class="m-login__signup m-login__form m-form" style="padding: 40px;">
    

                                      

                                        @include('files.categories.selector', ['name' => 'folder_id', 'value'=>$file->folder_id, 'id'=>'catSelect'] )


                                        


                                                    
{{-- 
                                        <div class="form-group">
                                            <label for="recipient-name" class="form-control-label">Description:</label>
                                            {!! Form::textarea('description', @$file->description, ['class' =>'form-control']) !!}
                                        </div>

                                        <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">Full Name</label>
                                                        <div class="col-7">
                                                            <input class="form-control m-input" type="text" value="Mark Andre">
                                                        </div>
                                                    </div> --}}

                                        <div id="catFieldDiv"  >

                                                <div class="m-form__heading">
                                                        <h3 class="m-form__heading-title">Metadata:</h3>
                                                    </div>
                                                    
                                                    
                                                     <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">File Name</label>
                                                        <div class="col-7">
                                                            {!! Form::text('name', @$file->name, ['class' =>'form-control']) !!}
                                                        </div>
                                                    </div>

                                            @foreach($file->folder->fields as $field)

                                                @php  
                                                    $filledField = $file->fields()->where('id', $field->id)->first();
                                                    $value = ($filledField) ? $filledField->pivot->value : ''; @endphp
                                                
                                                <div class="form-group m-form__group row">
                                                        <label for="recipient-name" class="col-4 col-form-label">{{ $field->name }}</label>
                                                        <div class="col-8">
                                                @if($field->type == "Text")
                                                    
                                                        {!! Form::text('fld_'.$field->id, $value, ['class' =>'form-control', 'required']) !!}
                                                    

                                                @elseif($field->type == "Number")
                                                        {!! Form::number('fld_'.$field->id, $value, ['class' =>'form-control', 'required']) !!}
                                                    
                                                    
                                                @elseif($field->type == "Decimal")
                                                        {!! Form::number('fld_'.$field->id, $value, ['class' =>'form-control', 'required', 'step'=>'any']) !!}
                                                    
                                                    
                                                @elseif($field->type == "Long Text")
                                                        {!! Form::textarea('fld_'.$field->id, $value, ['class' =>'form-control', 'required']) !!}
                                                    
                                                    
                                                 @elseif(in_array($field->type, ["Dropdown"]))
                                                    {!! Form::select('fld_'.$field->id, prepDropdownItemsFromValueList($field->list), null, ['class' =>'form-control', 'required']) !!}
                                                
                                                
                                                @elseif(in_array($field->type, [ 'Multiple selection']))
                                                        {!! Form::select('fld_'.$field->id.'[]', prepDropdownItemsFromValueList($field->list, "None"), null, ['class' =>'form-control select2', 'required', 'multiple']) !!}
                                                    
                                                    
                                                @endif

                                                    </div>
                                                </div>    

                                            @endforeach

                                        </div>

                                    </div>

                                    

                                </div>

                                <!--end::Portlet-->

                               


                            </div>
                            <div class="col-lg-6">

                               

                                <!--begin::Portlet-->
                                <div class="m-portlet m-portlet--primary m-portlet--head-solid-bg">
                                    <div class="m-portlet__head">
                                        <div class="m-portlet__head-caption">
                                            <div class="m-portlet__head-title">
                                                <span class="m-portlet__head-icon">
                                                    <i class="flaticon-line-graph"></i>
                                                </span>
                                                <h3 class="m-portlet__head-text">
                                                    Preview
                                                </h3>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="m-portlet__body">
                                        @include('files.view.preview')
                                    </div>
                                </div>

                                <!--end::Portlet-->

                            </div>
                        </div>  

                <div class="row">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4">
                        <button type="submit" class="m-btn btn btn-lg btn-right btn-primary" >
                            <i class="fa fa-save"></i> Update
                        </button>

                        
                    </div>
                </div>

               {{--  <div class="m-form__actions m-form__actions">
                                                <div class="row">
                                                    <div class="col-lg-3"></div>
                                                    <div class="col-lg-6">
                                                        <button type="reset" class="btn btn-success">Submit</button>
                                                        <button type="reset" class="btn btn-secondary">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                        
                        


                        </form> --}}


                        </div>
                        </div>            
</div>



 

@endsection

@section('scripts')
<script src="{{ asset('assets/demo/default/custom/components/base/treeview.js') }}" type="text/javascript"></script>



<script type="text/javascript">
    
    @if($saved)
    
    setTimeout('swal({type:"success",title:"File metadata saved successfully",showConfirmButton:!1,timer:1500})',1000);
    toastr.info("File metadata saved successfully", "Success");

    @endif

   $(document).ready(function () {
       $('#catSelect').on('change', function() {
           loadCatFields();
        });

       
    });


   function loadCatFields() {
             $("#catFieldDiv").html("Please wait...");
             $.ajax({
                    url: '{{ route('cat-fields') }}/' + $("#catSelect").val() + '/{{ $file->id }}',
                    data: {'d': 'sfd'},
                    dataType: 'html',
                    success: function(res) {
                        $("#catFieldDiv").html(res);

                    },
                    error: function(res) {
                        
                        
                    }
                });  
        }   

</script>

@endsection
