@extends('layouts.main')

@section('content')


<div class="m-grid__item m-grid__item--fluid  m-grid m-grid--ver-desktop m-grid--desktop m-page__container m-body">

    <div class="m-grid__item m-grid__item--fluid m-wrapper">

                    <!-- BEGIN: Subheader -->
                    <div class="m-subheader ">
                        <div class="d-flex align-items-center">
                            <div class="mr-auto">
                                <h3 class="m-subheader__title m-subheader__title--separator">Unindexed files</h3>
                                {{ number_format($uncategorized_count) }} files remaining

                            </div>
                            <div class="m--hide">
                                <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
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

@if(!@$file)

        <div class="m-alert m-alert--icon m-alert--air m-alert--square alert alert-dismissible m--margin-bottom-30" role="alert">
            <div class="m-alert__icon">
                <i class="flaticon-exclamation m--font-brand"></i>
            </div>
            <div class="m-alert__text ">
               You do not have any un-indexed file waiting to be indexed.
            </div>
        </div>

@else

<form class="m-login__form m-form" action="{{ route('file-categorize') }}" method="post" >

    @csrf
    {!! Form::hidden('file_id', @$file->id) !!}

    <div class="row">
                            <div class="col-lg-6" >

                                <!--begin::Portlet-->
                                <div class="m-portlet" style="background-color: #f8f3ef">
                                    <div class="m-portlet__head " style="background-color: #b24135">
                                        <div class="m-portlet__head-caption">
                                            <div class="m-portlet__head-title" >

                                                <!-- <span class="m-portlet__head-icon">
                                                    <i class="flaticon-map-location"></i>
                                                </span> -->
                                                <h3 class="m-portlet__head-text" style="color: #ffffff; text-align: center">
                                                   Approval Form
                                                </h3>

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


                                         {{-- <div class="form-group m-form__group row">
                                            <label for="example-text-input" class="col-4 col-form-label">File Category </label>
                                            <div class="col-8">
                                                {!! Form::select('folder_id', $folders, $file->folder_id, ['class' =>'form-control select2', 'id'=>'catSelect']) !!}
                                            </div>
                                        </div> --}}



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

                                                    <h3>Please reload the page...</h3>

                                        {{-- @foreach($file->folder->fields as $field)

                                            <div class="form-group m-form__group row">
                                                    <label for="recipient-name" class="col-4 col-form-label">{{ $field->name }}</label>
                                                    <div class="col-8">
                                            @if($field->type == "Text")

                                                    {!! Form::text('fld_'.$field->id, null, ['class' =>'form-control', 'required']) !!}


                                            @elseif($field->type == "Number")
                                                    {!! Form::number('fld_'.$field->id, null, ['class' =>'form-control', 'required']) !!}
 

                                            @elseif($field->type == "Decimal")
                                                    {!! Form::number('fld_'.$field->id, null, ['class' =>'form-control', 'required', 'step'=>'any']) !!}


                                            @elseif($field->type == "Long Text")
                                                    {!! Form::textarea('fld_'.$field->id, null, ['class' =>'form-control', 'required']) !!}


                                            @elseif(in_array($field->type, ["Dropdown"]))
                                            {!! Form::select('fld_'.$field->id, prepDropdownItemsFromValueList($field->list), null, ['class' =>['form-control','select2'],'required']) !!}


                                            @elseif(in_array($field->type, [ 'Multiple selection']))
                                                <select name={!!'fld_'.$field->id.'[]'!!} class="form-control select2" ($isMetadataEnabled) ?  readonly: "" multiple="multiple">
                                                    @foreach(prepDropdownItemsFromValueList($field->list) as $field)
                                                        <option value="{{ $field }}" {{ in_array($field, explode(",", $value) ) ? 'selected' : '' }} >
                                                            {{ $field }}
                                                        </option>
                                                    @endforeach
                                                </select>
            

                                            @endif

                                                </div>
                                            </div>

                                        @endforeach --}}

                                    </div>

                                    </div>



                                </div>

                                <!--end::Portlet-->




                            </div>
                            <div class="col-lg-6">



                                <!--begin::Portlet-->
                                <div class="m-portlet m-portlet--danger m-portlet--head-solid-bg">
                                    <div class="m-portlet__head" style="background-color: #b24135">
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
                    <div class="col-lg-3"></div>
                    <div class="col-lg-2">
                        <button type="submit" class="m-btn btn btn-lg btn-right btn-primary"  style="background-color: #b24135">
                            <i class="fa fa-save"></i> Save and Next
                        </button>


                    </div>
                    <div class="col-lg-2">

                        <a href="{{ route('cancel-index', ['fileId' => $file->id]) }}" onclick="return confirm('Are you sure you want cancel indexing for this file? It wont be stored.');" class="m-btn btn btn-lg btn-right btn-danger" >
                            <i class="fa fa-times"></i> Cancel this file
                        </a>
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
                                            </div> --}}




                        </form>

@endif

                        </div>
                        </div>
</div>





@endsection

@section('scripts')
<script src="{{ asset('assets/demo/default/custom/components/base/treeview.js') }}" type="text/javascript"></script>
<script type="text/javascript">
       $('.select2').select2({dropdownCssClass : 'bigdrop', 'width' : '350px'});



   $(document).ready(function () {
       $('#catSelect').on('change', function() {
            console.log('loading cat fields....');
            loadCatFields();
        });


       @if (session('info'))

            toastr.success("{{ session('info') }}", "Info");

        @endif

        @if (session('error'))

            {{-- toastr.error("{{ session('error') }}", "Error"); --}}
            swal({type:"error",title:"{!! session('error') !!}",showConfirmButton:1,timer:5500})

        @endif

        @if (session('success'))

            setTimeout('swal({type:"success",title:"{{ session('success') }}",showConfirmButton:!1,timer:1500})',1000);
            toastr.info("{{ session('success') }}", "Success");


        @endif



    });


   function loadCatFields() {
             $("#catFieldDiv").html("Please wait...");
             $.ajax({
                    url: '{{ route('cat-fields') }}/' + $("#catSelect").val() + '/{{ $file['id'] }}' ,
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
