@extends('layouts.main')

@section('content')

<style type="text/css">
    .quick-nav-trigger {
        position: absolute;
        z-index: 10103;
        top: 0;
        right: 0;
        height: 60px;
        width: 60px;
        border-radius: 50%!important;
        overflow: hidden;
        white-space: nowrap;
        color: transparent;
    }

    .quick-nav {
        position: fixed;
        z-index: 10103;
        top: 50%;
        right: 10px;
        margin-top: -230px;
        pointer-events: none;
    }

    .quick-nav .quick-nav-bg {
        position: absolute;
        z-index: 10102;
        top: 0;
        right: 0;
        width: 60px;
        height: 60px;
        border-radius: 30px!important;
        background: #36C6D3;
        box-shadow: 0 1px 4px rgba(0,0,0,.2);
        webkit-transition: height .2s,box-shadow .2s;
        -moz-transition: height .2s,box-shadow .2s;
        -ms-transition: height .2s,box-shadow .2s;
        -o-transition: height .2s,box-shadow .2s;
        transition: height .2s,box-shadow .2s;
    }
   
</style>

<div class="m-grid__item m-grid__item--fluid  m-grid m-grid--ver-desktop m-grid--desktop m-page__container m-body">
                <div class="m-grid__item m-grid__item--fluid m-wrapper">

                    <!-- BEGIN: Subheader -->
                    <div class="m-subheader ">
                        <div class="d-flex align-items-center">
                            <div class="mr-auto">
                                <h3 class="m-subheader__title ">Dashboard</h3>
                            </div>
                            <div>
                               {{--  <span class="m-subheader__daterange" id="m_dashboard_daterangepicker">
                                    <span class="m-subheader__daterange-label">
                                        <span class="m-subheader__daterange-title"></span>
                                        <span class="m-subheader__daterange-date m--font-brand"></span>
                                    </span>
                                    <a href="#" class="btn btn-sm btn-brand m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill">
                                        <i class="la la-angle-down"></i>
                                    </a>
                                </span> --}}
                            </div>
                        </div>
                    </div>

                    <!-- END: Subheader -->
                    <div class="m-content">

                        @if($agent->isMobile() || $agent->isTablet())
                            <form action="{{ route('new-file-upload') }}">

                                <button type="submit" class="btn btn-primary btn-sm">Initiate workflow</button>
                            </form>
                            {{-- <a href="{{ route('new-file-upload') }}">
                                <span>
                                    <span>Initiate workflow</span>
                                </span>
                            </a> --}}
                        @endif
                        <!--Begin::Section-->
                        <div class="row">
                            
                             <div class="col-xl-7">

                                <!--begin:: Widgets/Audit Log-->
                                <div class="m-portlet m-portlet--full-height  m-portlet--rounded">
                                    <div class="m-portlet__head">
                                        <div class="m-portlet__head-caption">
                                            <div class="m-portlet__head-title">
                                                <h3 class="m-portlet__head-text">
                                                    Files Assigned to me
                                                </h3>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="m-portlet__body">
                                            <table class="table m_datatable" id="file_table"> 
                                                    <thead>
                                                        
                                                        <th>Name</th>
                                                        <th>Workflow</th>
                                                        <th>Supplier name</th>
                                                        <th>Amount</th>
                                                        <th>Priority</th>
                                                        {{-- <th>Current Version</th> --}}
                                                        <th>Updated at</th> 
                                                        <th>Actions</th>
                                                    </thead>
                                                    <tbody>

                                                       @foreach($assignedFiles as $file)
                                                            @foreach($file->step->assignees as $assignee)
                                                                @php
                                                                    if ($assignee->recipient_type === 'GROUP') {
                                                                        $groupUsers = App\Models\Group::with('users')
                                                                            ->find($assignee->recipient_id)->users->pluck('id')->toArray();
                                                                    }
                                                                @endphp
                                                                
                                                                @if(($assignee->recipient_type === 'USER' && $assignee->recipient_id == Auth::user()->id ) || 
                                                                    ($assignee->recipient_type === 'GROUP' && in_array(Auth::user()->id, $groupUsers) )  || 
                                                                    ($assignee->recipient_type === 'DEFAULT' && $file->created_by == Auth::user()->id ))
                                                                
                                                                 
                                                                <tr>
                                                                
                                                                    <td> {{ $file->name }} </td>
                                                                    <td> {{ $file->folder->workflow->name }} </td>
                                                                    <td> {{ @$file->fields->where('name', 'Supplier Name')->first()->pivot->value}}  </td>
                                                                    <td> {{ number_format(@$file->fields->where('name', 'Amount Requested')->first()->pivot->value,2)}} </td>
                                                                    <td> {{ @$file->fields->where('name', 'Priority')->first()->pivot->value}}  </td>
                                                                    
                                                                    <td> {{ ($file->last_modified) }} </td> 
                                                                    <td>
                                                                        
                                                                        <a data-view="{{ route('view-file').'/'.$file->id .'/1'}}" data-toggle="modal" data-placement="bottom" title="View details" data-target="#commonModal" href="" id="modalButton" data-type='wide' data-title="View" class="btn btn-primary text-light">
                                                                            <i class="fa fa-eye"></i> View
                                                                        </a>        
                        
                        
                                                                    </td>
                                                                </tr>
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                    </div>
                                </div>

                                <!--end:: Widgets/Audit Log-->
                            </div>

                            <div class="col-xl-4 m--hide">

                                <!--begin:: Widgets/Blog-->
                                <div class="m-portlet m-portlet--head-overlay m-portlet--full-height   m-portlet--rounded m-portlet--rounded-force">
                                    <div class="m-portlet__head m-portlet__head--fit">
                                        <div class="m-portlet__head-caption">
                                            <div class="m-portlet__head-title">
                                                <h3 class="m-portlet__head-text m--font-light">
                                                    Recent uploads by File Type
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="m-portlet__head-tools m--hide">
                                            <ul class="m-portlet__nav">
                                                <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover">
                                                    <a href="#" class="m-portlet__nav-link m-dropdown__toggle dropdown-toggle btn btn--sm m-btn--pill m-btn btn-outline-light m-btn--hover-light">
                                                        2018
                                                    </a>
                                                    <div class="m-dropdown__wrapper">
                                                        <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                                        <div class="m-dropdown__inner">
                                                            <div class="m-dropdown__body">
                                                                <div class="m-dropdown__content">
                                                                    <ul class="m-nav">
                                                                        <li class="m-nav__section m-nav__section--first">
                                                                            <span class="m-nav__section-text">Reports</span>
                                                                        </li>
                                                                        <li class="m-nav__item">
                                                                            <a href="" class="m-nav__link">
                                                                                <i class="m-nav__link-icon flaticon-share"></i>
                                                                                <span class="m-nav__link-text">Activity</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="m-nav__item">
                                                                            <a href="" class="m-nav__link">
                                                                                <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                                                <span class="m-nav__link-text">Messages</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="m-nav__item">
                                                                            <a href="" class="m-nav__link">
                                                                                <i class="m-nav__link-icon flaticon-info"></i>
                                                                                <span class="m-nav__link-text">FAQ</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="m-nav__item">
                                                                            <a href="" class="m-nav__link">
                                                                                <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                                                                <span class="m-nav__link-text">Support</span>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="m-portlet__body">
                                        <div class="m-widget28">
                                            <div class="m-widget28__pic m-portlet-fit--sides" style="min-height: 190px;"></div>
                                            <div class="m-widget28__container">

                                                <!-- begin::Nav pills -->
                                                <ul class="m-widget28__nav-items nav nav-pills nav-fill" role="tablist">
                                                    <li class="m-widget28__nav-item nav-item">
                                                        <a class="nav-link active" data-toggle="pill" href="#menu11"><span><i class="fa fa-file-pdf"></i></span><span>PDF</span></a>
                                                    </li>
                                                    <li class="m-widget28__nav-item nav-item">
                                                        <a class="nav-link" data-toggle="pill" href="#menu21"><span><i class="fa fa-file-image"></i></span><span>Images</span></a>
                                                    </li>
                                                    <li class="m-widget28__nav-item nav-item">
                                                        <a class="nav-link" data-toggle="pill" href="#menu31"><span><i class="fa fa-file"></i></span><span>Text</span></a>
                                                    </li>
                                                </ul>

                                                <!-- end::Nav pills -->

                                                <!-- begin::Tab Content -->
                                                <div class="m-widget28__tab tab-content">
                                                    <div id="menu11" class="m-widget28__tab-container tab-pane active">
                                                        <div class="m-widget28__tab-items">
                                                            <div class="m-widget28__tab-item">
                                                                <span>Product manuals</span>
                                                                <span>Sample file.pdf</span>
                                                            </div>
                                                            <div class="m-widget28__tab-item">
                                                                <span>Product manuals</span>
                                                                <span>Sample file2.pdf</span>
                                                            </div>
                                                            <div class="m-widget28__tab-item">
                                                                <span>Manual</span>
                                                                <span>Sample file3.pdf</span>
                                                            </div>
                                                            <div class="m-widget28__tab-item">
                                                                <span>Manual</span>
                                                                <span>Sales management.pdf</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="menu21" class="m-widget28__tab-container tab-pane fade">
                                                        <div class="m-widget28__tab-items">
                                                            <div class="m-widget28__tab-item">
                                                                <span>Root</span>
                                                                <span>image.png</span>
                                                            </div>
                                                            <div class="m-widget28__tab-item">
                                                                <span>Demos</span>
                                                                <span>Screenshot 2018-11-06 at 5.26.06 PM.png</span>
                                                            </div>
                                                            <div class="m-widget28__tab-item">
                                                                <span>Demos</span>
                                                                <span>Screenshot 2018-11-06 at 5.26.06 PM.png</span>
                                                            </div>
                                                            <div class="m-widget28__tab-item">
                                                                <span>Root</span>
                                                                <span>image2.png</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="menu31" class="m-widget28__tab-container tab-pane fade">
                                                        <div class="m-widget28__tab-items">
                                                            <div class="m-widget28__tab-item">
                                                                <span>Manuals</span>
                                                                <span>notes.txt</span>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- end::Tab Content -->
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--end:: Widgets/Blog-->
                            </div>
                            <div class="col-xl-5">

                                <!--begin:: Packages-->
                                <div class="m-portlet m--bg-warning m-portlet--bordered-semi m-portlet--full-height  m-portlet--rounded">
                                    <div class="m-portlet__head">
                                        <div class="m-portlet__head-caption">
                                            <div class="m-portlet__head-title">
                                                <h3 class="m-portlet__head-text m--font-light">
                                                    File Statistics
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="m-portlet__head-tools">
                                            <ul class="m-portlet__nav">
                                                <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover">
                                                    <a href="#" class="m-portlet__nav-link m-dropdown__toggle dropdown-toggle btn btn--sm m-btn--pill btn-primary m-btn btn-outline-light m-btn--hover-info" id="currentPeriodLabel">
                                                        This week
                                                    </a>
                                                    <div class="m-dropdown__wrapper">
                                                        <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                                        <div class="m-dropdown__inner">
                                                            <div class="m-dropdown__body">
                                                                <div class="m-dropdown__content">
                                                                    <ul class="m-nav">
                                                                        <li class="m-nav__item">
                                                                            <a href="" onclick="return showStats('thisWeek');" class="m-nav__link">
                                                                                <i class="m-nav__link-icon flaticon-share"></i>
                                                                                <span class="m-nav__link-text">This week</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="m-nav__item">
                                                                            <a href="" onclick="return showStats('lastWeek');" class="m-nav__link">
                                                                                <i class="m-nav__link-icon flaticon-share"></i>
                                                                                <span class="m-nav__link-text">Last week</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="m-nav__item">
                                                                            <a href="" onclick="return showStats('thisMonth');" class="m-nav__link">
                                                                                <i class="m-nav__link-icon flaticon-share"></i>
                                                                                <span class="m-nav__link-text">This month</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="m-nav__item">
                                                                            <a href="" onclick="return showStats('lastMonth');" class="m-nav__link">
                                                                                <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                                                <span class="m-nav__link-text">Last Month</span>
                                                                            </a>
                                                                        </li>
                                                                        
                                                                       
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="m-portlet__body" id="statsBody">

                                        

                                        <!--end::Widget 29-->
                                    </div>
                                </div>

                                <!--end:: Packages-->
                            </div>
                        </div>

                        <!--End::Section-->

                        
                        

                        <!--Begin::Section-->
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="m-portlet m-portlet--mobile  m-portlet--rounded">
                                    <div class="m-portlet__head">
                                        <div class="m-portlet__head-caption">
                                            <div class="m-portlet__head-title">
                                                <h3 class="m-portlet__head-text">
                                                    Recent files uploaded.
                                                </h3>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="m-portlet__body">

                                        <!--begin: Datatable -->
                                <table class="table"> 
                                    <thead>
                                        
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Size</th>
                                        <th>Current Version</th>
                                        <th>Uploaded at</th>
                                        <th>Actions</th>
                                    </thead>
                                    <tbody>
                                       @foreach($files as $key => $file)

                                            @php if(count($file->auth_user) == 0) continue; @endphp
                                                
                                        <tr>
                                            
                                            <td> {{ $file->name }} </td>
                                            <td> {{ $file->type }} </td>
                                            <td> {{ sizeFilter($file->size) }} </td>
                                            <td> {{ ($file->current_version) }} </td>
                                            <td> {{ ($file->created_at) }} </td>
                                            <td>
                                                
                                                <a data-view="{{ route('view-file').'/'.$file->id .'/1'}}" data-toggle="modal" data-placement="bottom" title="View details" data-target="#commonModal" href="" id="modalButton" data-type='wide' data-title="View" class="btn btn-primary text-light">
                                                    <i class="fa fa-eye"></i> View
                                                </a>        


                                            </td>
                                        </tr>
                                    
                                            
                                        @endforeach
                                    </tbody>
                                </table>

                                        <!--end: Datatable -->
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                        <!--End::Section-->
                    </div>
                </div>
            </div>


            <nav class="quick-nav" style="display: none;">
                <a class="quick-nav-trigger" href="#0">
                    <span aria-hidden="true"></span>
                    Upload files
                </a>
                
                <span aria-hidden="true" class="quick-nav-bg"></span>
            </nav>


            
@endsection

@section('scripts')

<script type="text/javascript">

    $(document).ready(function () {

        showStats("thisWeek");

        @if($file_id)

            $('#commonModal').modal('show').find('.modal-body').load("{{ route('view-file').'/'.$file_id .'/1'}}");
            // swal({type:"success",title:"{{ $message }}",showConfirmButton:!1,timer:1500})
            setTimeout('swal({type:"success",title:"{{ $message }}",showConfirmButton:!1,timer:3500})',1000);

        @endif

        var table = $('#file_table').DataTable({
            responsive: true,
            order: [[ 4, "desc" ]], //or asc 
            pagination: true,
            "bSortable": true,
    
        });
    });

    function showStats(period){

        $("#currentPeriodLabel").html(period);

        $.ajax({
                type: "GET",   
                url: "{{ route('ajax-stats') }}",
                data: {  'period': period },
                // dataType: "json",
                success: function(l) {
                   
                    $("#statsBody").html(l);

                },
                error: function() {
                    // toastr.error("An error occurred displaying the details", "Error");
                }
            }); 


        return false;

    }

</script>

@endsection
