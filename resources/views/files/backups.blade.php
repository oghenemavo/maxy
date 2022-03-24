@extends('layouts.main')

@section('styles')
    <link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">
@endsection

@section('content')

<style type="text/css">
    .m-timeline-3 .m-timeline-3__item:before {
        position: absolute;
        display: block;
        width: 0.28rem;
        border-radius: .3rem;
        height: 70%;
        left: 12.1rem;
        top: 0.46rem;
        content: "";
    }
</style>


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
                                                    
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-portlet__body">
                                        
                                        <!--begin: Search Form -->
                               
                                        
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
                                <h3 class="m-subheader__title m-subheader__title--separator">All backups</h3>
                                Backup snapshots that has been taken in the past.
                            </div>
                            <div>

                                <button class="btn btn-primary" id="createBtn" onclick="backup()">Backup now</button>
                                
                            </div>
                        </div>
                    </div>

                    <!-- END: Subheader -->
                    
                    <div class="m-content">
                        
                        <div class="m-portlet m-portlet--mobile">
                            
                            <div class="m-portlet__body">

                                


                            <div class="m-timeline-3">
                                <div class="m-timeline-3__items">


                                    @foreach($backups as $backup)
                                    <div class="m-timeline-3__item {{ ($backup->status == 'COMPLETED') ? 'm-timeline-3__item--success' : 'm-timeline-3__item--warning' }} " style="margin-bottom: 3em;">
                                        <span class="m-timeline-3__item-time" style="width: 10.57rem;">
                                            {{ $backup->created_at->diffForHumans() }}
                                        </span>
                                        <div class="m-timeline-3__item-desc" style="    padding-left: 13rem; width: 70em">
                                            <span class="m-timeline-3__item-text">
                                                {{ $backup->name }} 
                                                <span class="m-badge {{ ($backup->status == 'COMPLETED')? 'm-badge--success' : 'm-badge--warning' }} m-badge--wide">{{ $backup->status }}</span>
                                                
                                                @if($backup->status != 'COMPLETED')
                                                    <button type="button" class="btn m-btn--pill m-btn--air    btn-danger" style="float: right;" onclick="cancel({{ $backup->id }})" >Cancel</button>
                                                @else

                                                    <button type="button" class="btn m-btn--pill m-btn--air  btn-secondary" style="float: right;" onclick="restore({{ $backup->id }})">Restore to this backup</button>
                                                
                                                @endif    
                                            </span><br>
                                            <span class="m-timeline-3__item-user-name">
                                                <a href="#" class="m-link m-link--metal m-timeline-3__item-link">
                                                    By {{ $backup->createdBy->full_name }}
                                                </a>
                                            </span>
                                            
                                        </div>
                                        
                                    </div>

                                    @endforeach


                                    {{-- <div class="m-timeline-3__item m-timeline-3__item--warning">
                                        <span class="m-timeline-3__item-time">10:00</span>
                                        <div class="m-timeline-3__item-desc">
                                            <span class="m-timeline-3__item-text">
                                                Lorem ipsum dolor sit amit
                                            </span><br>
                                            <span class="m-timeline-3__item-user-name">
                                                <a href="#" class="m-link m-link--metal m-timeline-3__item-link">
                                                    By Sean
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="m-timeline-3__item m-timeline-3__item--brand">
                                        <span class="m-timeline-3__item-time">11:00</span>
                                        <div class="m-timeline-3__item-desc">
                                            <span class="m-timeline-3__item-text">
                                                Lorem ipsum dolor sit amit eiusmdd tempor
                                            </span><br>
                                            <span class="m-timeline-3__item-user-name">
                                                <a href="#" class="m-link m-link--metal m-timeline-3__item-link">
                                                    By James
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="m-timeline-3__item m-timeline-3__item--success">
                                        <span class="m-timeline-3__item-time">12:00</span>
                                        <div class="m-timeline-3__item-desc">
                                            <span class="m-timeline-3__item-text">
                                                Lorem ipsum dolor
                                            </span><br>
                                            <span class="m-timeline-3__item-user-name">
                                                <a href="#" class="m-link m-link--metal m-timeline-3__item-link">
                                                    By James
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="m-timeline-3__item m-timeline-3__item--danger">
                                        <span class="m-timeline-3__item-time">14:00</span>
                                        <div class="m-timeline-3__item-desc">
                                            <span class="m-timeline-3__item-text">
                                                Lorem ipsum dolor sit amit,consectetur eiusmdd
                                            </span><br>
                                            <span class="m-timeline-3__item-user-name">
                                                <a href="#" class="m-link m-link--metal m-timeline-3__item-link">
                                                    By Derrick
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="m-timeline-3__item m-timeline-3__item--info">
                                        <span class="m-timeline-3__item-time">15:00</span>
                                        <div class="m-timeline-3__item-desc">
                                            <span class="m-timeline-3__item-text">
                                                Lorem ipsum dolor sit amit,consectetur
                                            </span><br>
                                            <span class="m-timeline-3__item-user-name">
                                                <a href="#" class="m-link m-link--metal m-timeline-3__item-link">
                                                    By Iman
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="m-timeline-3__item m-timeline-3__item--brand">
                                        <span class="m-timeline-3__item-time">17:00</span>
                                        <div class="m-timeline-3__item-desc">
                                            <span class="m-timeline-3__item-text">
                                                Lorem ipsum dolor sit consectetur eiusmdd tempor
                                            </span><br>
                                            <span class="m-timeline-3__item-user-name">
                                                <a href="#" class="m-link m-link--metal m-timeline-3__item-link">
                                                    By Aziko
                                                </a>
                                            </span>
                                        </div>
                                    </div> --}}
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
 <script type="text/javascript">
    function backup(){

        if(confirm("Are  you sure you want to create a new backup?\n\n This will create a new backup of the files and data on the system as at now.")){

            $("#createBtn").html('Backing up....');
            $("#createBtn").addClass('m-loader m-loader--light m-loader--right');

            $.ajax({
                type: "GET",   
                url: "{{ route('create-backup') }}",
                success: function(l) {
                   
                    // toastr.success(l.message);
                    if(l.success){
                        swal({type:"success",title:l.message,showConfirmButton:!1,timer:0})
                        setTimeout(function(){
                            location.reload();
                        }, 1000)    
                    }else
                        swal({type:"error",title:l.message,showConfirmButton:1})


                    $("#createBtn").html('Backup now');
                    $("#createBtn").removeClass('m-loader m-loader--light m-loader--right');
                    

                },
                error: function() {
                    toastr.error("An error occurred while creating the backup.", "Error");
                    $("#createBtn").html('Backup now');
                    $("#createBtn").removeClass('m-loader m-loader--light m-loader--right');
                }
            }); 
        }

    }


    function cancel(id){

        if(confirm("Are  you sure you want to cancel this backup process?\n\n This will cancel the backup process and remove all backup and files.")){

            $.ajax({
                type: "GET",   
                url: "{{ route('cancel-backup') }}?backup_id="+ id,
                success: function(l) {
                   
                    // toastr.success(l.message);
                    if(l.success){
                        swal({type:"success",title:l.message,showConfirmButton:!1,timer:0})
                        setTimeout(function(){
                            location.reload();
                        }, 1000)    
                    }else
                        swal({type:"error",title:l.message,showConfirmButton:1})
                    

                },
                error: function() {
                    toastr.error("An error occurred while canceling the backup.", "Error");
                }
            }); 
        }

    }


    function restore(id){

        if(confirm("Are  you sure you want to restore the system to this backup?\n\n This will remove all changes between then and now and make the system as it was before this backup was done.")){

            $.ajax({
                type: "GET",   
                url: "{{ route('restore-backup') }}?backup_id="+ id,
                success: function(l) {
                   
                    toastr.success(l.message);
                    if(l.success){
                        swal({type:"success",title:l.message,showConfirmButton:!1,timer:0})
                        setTimeout(function(){
                            location.reload();
                        }, 1000)    
                    }else
                        swal({type:"error",title:l.message,showConfirmButton:1})
                 

                },
                error: function() {
                    toastr.error("An error occurred while creating the backup.", "Error");
                }
            }); 
        }

    }

</script>
@endsection
