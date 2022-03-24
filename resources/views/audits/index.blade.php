@extends('layouts.main')

@section('styles')
    <link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">
@endsection

@section('content')


<div class="m-grid__item m-grid__item--fluid  m-grid m-grid--ver-desktop m-grid--desktop m-page__container m-body">
                
                <!-- BEGIN: Left Aside -->


                <!-- BEGIN: Left Aside -->
                <button class="m-aside-left-close m-aside-left-close--skin-light" id="m_aside_left_close_btn"><i class="la la-close"></i></button>
                <div id="m_aside_left" class="m-grid__item m-aside-left ">

                    <!-- BEGIN: Aside Menu -->
                    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-light m-aside-menu--submenu-skin-light " data-menu-vertical="true" m-menu-scrollable="0" m-menu-dropdown-timeout="500">


                        <div class="m-portlet">
                                    <div class="m-portlet__head">
                                        <div class="m-portlet__head-caption">
                                            <div class="m-portlet__head-title">
                                                <h3 class="m-portlet__head-text">
                                                    Filter
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-portlet__body">
                                        
                                        <!--begin: Search Form -->
                                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                                    <div class="row align-items-center">
                                        <div class="col-xl-12 order-2 order-xl-1">
                                            <div class="form-group m-form__group row align-items-center">
                                                <div class="col-md-12">
                                                    <div class="m-form__group m-form__group--inline">
                                                        <div class="m-form__label">
                                                            <label>Users:</label>
                                                        </div>
                                                        <div class="m-form__control">
                                                            <select class="form-control m-bootstrap-select1 usersListSelect" id="m_form_type2" onchange="userChange(this);">
                                                                <option value="0">All</option>
                                                                @foreach($users as $user)
                                                                    <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="d-md-none m--margin-bottom-10"></div>
                                                </div>
                                                <br style="clear:both;" />
                                                <br style="clear:both;" />
                                                <br style="clear:both;" />
                                                <hr/>
                                                <br style="clear:both;" />
                                                <br style="clear:both;" />
                                                <br style="clear:both;" />
                                                <br/>
                                                <div class="col-md-12">
                                                    <div class="m-form__group m-form__group--inline">
                                                        <div class="m-form__label">
                                                            <label class="m-label m-label--single">Type:</label>
                                                        </div>
                                                        <div class="m-form__control">
                                                            <select class="form-control m-bootstrap-select1 filetype" id="m_form_type1"  onchange="typeChange(this);">
                                                                <option value="">All</option>
                                                                <option value="files">All Files</option>
                                                                <option value="others">Others</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="d-md-none m--margin-bottom-10"></div>
                                                </div>
                                                <br style="clear:both;" />
                                                <br style="clear:both;" />
                                                <br style="clear:both;" />
                                                <hr/>
                                                <br style="clear:both;" />
                                                <br style="clear:both;" />
                                                <br style="clear:both;" />
                                                <br/>
                                                <div class="form-group m-form__group row">
                                                   
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <label class="m-label m-label--single">Date:</label>
                                                    </div>    
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class='input-group pull-right' id='m_daterangepicker_audit'>
                                                            <input type='text' class="form-control m-input" readonly placeholder="Select date range" />
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                                          
                                            <div class="m-separator m-separator--dashed d-xl-none"></div>
                                        </div>
                                    </div>
                                </div>
                                        
                                    </div>
                                </div>



                        
                    </div>

                    <!-- END: Aside Menu -->
                </div>

                <!-- END: Left Aside -->
                

                <!-- END: Left Aside -->

                <div class="m-grid__item m-grid__item--fluid m-wrapper">

                    <!-- BEGIN: Subheader -->
                    <div class="m-subheader ">
                        <div class="d-flex align-items-center">
                            <div class="mr-auto">
                                <h3 class="m-subheader__title m-subheader__title--separator">All logs</h3>
                               All activities on the system.
                            </div>
                            <div>

                                <button class="btn btn-primary" onclick="exportData()">Export</button>
                                
                            </div>
                        </div>
                    </div>

                    <!-- END: Subheader -->
                    
                    <div class="m-content">
                        
                        <div class="m-portlet m-portlet--mobile">
                            
                            <div class="m-portlet__body">

                                

                                <!--end: Search Form -->


                                <div class="m-list-timeline__group">
                                <div class="m-list-timeline__heading">
                                    System Logs
                                </div>
                                <div class="m-list-timeline__items" id="audiLogs">
                                </div>
                            </div>

                                <!--begin: Datatable -->
                                <!-- <div class="m_datatable" id="local_data"></div> -->


                                <!--end: Datatable -->
                            </div>
                        </div>

                        <!-- END EXAMPLE TABLE PORTLET-->
                    </div>




                </div>
            </div>







    <!--begin::Modal-->
    <div class="modal fade" id="m_modal_5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            
            
        </div>
    </div>

    <!--end::Modal-->



    
<div id="addPayrollItem" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="orgModalTitle">Modal title</h4>
      </div>
      <div class="modal-body" id="orgModalBody">
        <p>One fine body&hellip;</p>
      </div>
      {{-- <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> --}}
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



 

@endsection

@section('scripts')
{{-- <script src="{{ asset('assets/demo/default/custom/components/base/treeview.js') }}" type="text/javascript"></script> --}}
<script src="https://rawgit.com/enyo/dropzone/master/dist/dropzone.js"></script>

<script type="text/javascript">

    $(document).ready(function () {
        Dropzone.options.myDropzone= {
            url: '{{ route('new-file-upload') }}',
            autoProcessQueue: false,
            uploadMultiple: true,
            parallelUploads: 5,
            maxFiles: 5,
            maxFilesize: 1,
            // acceptedFiles: '*',
            addRemoveLinks: true,
            init: function() {
                dzClosure = this; // Makes sure that 'this' is understood inside the functions below.

                // for Dropzone to process the queue (instead of default form behavior):
                document.getElementById("submit-all").addEventListener("click", function(e) {
                    // Make sure that the form isn't actually being sent.
                    e.preventDefault();
                    e.stopPropagation();
                    dzClosure.processQueue();
                });

                //send all the form data along with the files:
                this.on("sendingmultiple", function(data, xhr, formData) {
                    formData.append("recipient", jQuery("#recipient").val());
                    formData.append("description", jQuery("#description").val());
                    formData.append("_token", '{{ csrf_token() }}');
                });
            },
            complete: function(data, xhr){
                if(data.status == 'success')
                    // location.reload()

                console.log(data);
                console.log(xhr);
            }

        };






       
      
        $('#m_form_status').on('change', function () {
            datatable.search($(this).val(), 'Status');
        });

        $('#m_form_type').on('change', function () {
            datatable.search($(this).val(), 'Type');
        });

        $('#m_form_status, #m_form_type').selectpicker();



        // predefined ranges
        var start = moment().subtract(29, 'days');
        var end = moment();

         $('#m_daterangepicker_audit').daterangepicker({
            buttonClasses: 'm-btn btn',
            applyClass: 'btn-primary',
            cancelClass: 'btn-secondary',
            startDate: start,
            endDate: end,
            ranges: {
               'Today': [moment(), moment()],
               'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               'Last 7 Days': [moment().subtract(6, 'days'), moment()],
               'Last 30 Days': [moment().subtract(29, 'days'), moment()],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, function(start, end, label) {
            $('#m_daterangepicker_audit .form-control').val( start.format('MMM DD, YYYY') + ' - ' + end.format('MMM DD, YYYY'));

            refreshData();
        });

        
        


    });


    function loadModal(modalTitle, url, id){

        $("#orgModalTitle").html(modalTitle);
        $("#orgModalBody").html("please wait");

        $.ajax({
            type: "GET",
            url: url,
            data: { 'folder_id': id },
            // dataType: "json",
            success: function(data) {
                $('#orgModalBody').html( data );
            },
            error: function() {
                alert('error handing here');
            }
        }); 

    }

    refreshData();


    function userChange(type) {
        var b = (type.value || type.options[type.selectedIndex].value); 
        
        refreshData();
    }

    function typeChange(type) {
        var b = (type.value || type.options[type.selectedIndex].value); 
        
        refreshData();
    }

    function exportData(){
        
        var userId = ($('.usersListSelect :selected').val());
        var type = ($('.filetype :selected').val());
        if(!type) {
            type ='all';
        }
        var date  = $('#m_daterangepicker_audit .form-control').val();
        console.log(date)

         var url = "{{ url('audits/export/data') }}/"+userId+"/"+type+"/"+date;
        console.log('Exporting table...from '+url);

        document.location = url;
    }

 
    function refreshData() {
        var userId = ($('.usersListSelect :selected').val());
        var type = ($('.filetype :selected').val());
        var dateRange  = $('#m_daterangepicker_audit .form-control').val();

        console.log(dateRange);

        var url= "{{ route('audit-data') }}"
        $("#audiLogs").html('<div style="padding:20px;text-align:center;margin:auto;"><i class="fa fa-spinner fa-spin fa-4x"></i><br/>Please wait...</div>');

        $.ajax
        (
            {
               type: "POST",
               url: url,
               data: ({ rnd : Math.random() * 100000, 'user_id':userId, 'dateRange':dateRange ,'type':type,  _token:"{{ csrf_token() }}"}),
               success: function(html)
               {
                 $('#audiLogs').html(html);
                   
               },
               error: function(html){
                $('#audiLogs').html(html);
               }
         });
    }





</script>
@endsection
