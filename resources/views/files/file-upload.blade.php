<!--begin::Modal-->
    <div class="modal fade" id="m_modal_4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            
            {!! Form::open(['route' => 'new-file-upload', 'files' => true]) !!}


            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload file</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                        <div class="dropzone1" id="myDropzone">
                              <div class="dz-default dz-message">Upload file here...</div>
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="form-control-label">Category:</label>
                            {!! Form::select('folder_id', getFolders(), null, ['class' =>'form-control', 'id'=>'folder_id', 'required']) !!}
                        </div>
                       {{--  <div class="form-group">
                            <label for="recipient-name" class="form-control-label">Tags:</label>
                            {!! Form::select('tags', $tags, null, ['class' =>'form-control m-select2', 'multiple']) !!}
                        </div> --}}
                        {{-- <div class="form-group">
                            <label for="message-text" class="form-control-label">Comments:</label>
                            <textarea class="form-control" name="description" id="description"></textarea>
                        </div> --}}
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="upload-all" class="btn btn-primary">Upload</button>
                </div>
            </div>

            </form>
        </div>
    </div>

    <!--end::Modal-->



<script type="text/javascript">

    $(document).ready(function () {

        // Dropzone.autoDiscover = false;

        $("#myDropzone").addClass('dropzone');

        $("div#myDropzone").dropzone({
            url: '{{ route('new-file-upload') }}',
            autoProcessQueue: false,
            uploadMultiple: true,
            parallelUploads: 5,
            maxFiles: 50,
            maxFilesize: 500,
            addRemoveLinks: true,
            init: function() {
                dzClosure = this; // Makes sure that 'this' is understood inside the functions below.

                // for Dropzone to process the queue (instead of default form behavior):
                $("#upload-all").on("click", function(e) {
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