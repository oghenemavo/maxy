@extends('layouts.main')

@section('content')

@php
  $isEdit = "";
@endphp

<div class="m-grid__item m-grid__item--fluid  m-grid m-grid--ver-desktop m-grid--desktop m-page__container m-body">

    <div class="m-grid__item m-grid__item--fluid m-wrapper">

                    <!-- BEGIN: Subheader -->
                    <div class="m-subheader ">
                        <div class="d-flex align-items-center">
                            <div class="mr-auto">
                                <h3 class="m-subheader__title m-subheader__title--separator">Upload a file</h3>
                                
                                {{-- <ul class="m-subheader__breadcrumbs m-nav m-nav--inline hidden">
                                    <li class="m-nav__item m-nav__item--home">
                                        <a href="#" class="m-nav__link m-nav__link--icon">
                                            <i class="m-nav__link-icon la la-home"></i>
                                        </a>
                                    </li>
                                    <li class="m-nav__separator">-</li>
                                    <li class="m-nav__item">
                                        <a href="" class="m-nav__link">
                                            <span class="m-nav__link-text">Dashboard</span>
                                        </a>
                                    </li>
                                    <li class="m-nav__separator">-</li>
                                    <li class="m-nav__item">
                                        <a href="" class="m-nav__link">
                                            <span class="m-nav__link-text">Customers</span>
                                        </a>
                                    </li>
                                    <li class="m-nav__separator">-</li>
                                    <li class="m-nav__item">
                                        <a href="" class="m-nav__link">
                                            <span class="m-nav__link-text">Annual Reports</span>
                                        </a>
                                    </li>
                                </ul> --}}
                            </div>
                            <div>
                                
                            </div>
                        </div>
                    </div>

                    <!-- END: Subheader -->

 
                    
                    <div class="m-content">

                        <div class="m-alert m-alert--icon m-alert--air m-alert--square alert alert-dismissible m--margin-bottom-30 collapse" role="alert" style="display: none;">
                            <div class="m-alert__icon">
                                <i class="flaticon-exclamation m--font-brand"></i>
                            </div>
                            <div class="m-alert__text ">
                                The example below shows a header spanning multiple cells over the contact information, with one of the columns that the span covers being hidden.
                                See official documentation <a href="https://datatables.net/examples/advanced_init/complex_header.html" target="_blank">here</a>.
                            </div>
                        </div>
                        <div class="m-portlet m-portlet--mobile">
                            
                            <div class="m-portlet__body">


                             {!! Form::open(['route' => 'new-file-upload', 'files' => true]) !!}
                                        
                                <div class="dropzone1" id="myDropzone">
                                        <div class="dz-default dz-message">Upload file here...</div>
                                </div>

                                @include('files.categories.selector', ['name' => 'folder_id', 'id'=>'folder_id','value'=>1])
                                <!-- {{--  <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Tags:</label>
                                    {!! Form::select('tags', $tags, null, ['class' =>'form-control m-select2', 'multiple']) !!}
                                </div> --}} -->
                                <!-- {{-- <div class="form-group">
                                    <label for="message-text" class="form-control-label">Comments:</label>
                                    <textarea class="form-control" name="description" id="description"></textarea>
                                </div> --}} -->
                            </form>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="close" data-dismiss="modal">Close</button>
                            <button type="submit" id="uploadAll" class="btn btn-primary">Upload</button>
                        </div>
                    

                    </form>


                            </div>
                        </div>        
  
   

               

              


                        </div>
                        </div>            
</div>



 

@endsection

@section("scripts")
    
    <script type="text/javascript">

    $(document).ready(function () {

         $('.select2').select2({dropdownCssClass : 'bigdrop', 'width' : '350px', 'height' : '200px'}); 

        // Dropzone.autoDiscover = false;

        $("#myDropzone").addClass('dropzone');

        $("div#myDropzone").dropzone({
            url: '{{ route('new-file-upload') }}',
            autoProcessQueue: false,
            uploadMultiple: true,
            parallelUploads: 50,
            maxFiles: 500,
            maxFilesize: 5000,
            addRemoveLinks: true,
            init: function() {
                dzClosure = this; // Makes sure that 'this' is understood inside the functions below.

                // for Dropzone to process the queue (instead of default form behavior):
                $("#uploadAll").on("click", function(e) {
                    // Make sure that the form isn't actually being sent.
                    console.log("uplaod all clciked.");
                    e.preventDefault();
                    e.stopPropagation();
                    dzClosure.processQueue();
                });

                // var submitButton = document.querySelector("#upload-all");
                // var wrapperThis = this;

                // submitButton.addEventListener("click", function () {
                //     wrapperThis.processQueue();
                // });

                // this.on("addedfile", function (file) {

                //     // Create the remove button
                //     var removeButton = Dropzone.createElement("<button class='btn btn-lg dark'>Remove File</button>");

                //     // Listen to the click event
                //     removeButton.addEventListener("click", function (e) {
                //         // Make sure the button click doesn't submit the form:
                //         e.preventDefault();
                //         e.stopPropagation();

                //         // Remove the file preview.
                //         wrapperThis.removeFile(file);
                //         // If you want to the delete the file on the server as well,
                //         // you can do the AJAX request here.
                //     });

                //     // Add the button to the file preview element.
                //     file.previewElement.appendChild(removeButton);
                // });


                console.log("enetered init.");

                //send all the form data along with the files:
                this.on("sendingmultiple", function(data, xhr, formData) {
                    formData.append("folder_id", jQuery("#folder_id").val());
                    formData.append("description", jQuery("#description").val());
                    formData.append("_token", '{{ csrf_token() }}');
                });
            },
            complete: function(data, xhr){
                if(data.status == 'success'){

                    toastr.success("Files uploaded successfully!", "Success");
                    // setTimeout('location.reload()',1000);
                    document.location = '{{ route('file-categorize') }}';
                }

                console.log(data);
                console.log(xhr);
            }

        });

    });        


</script>



@endsection