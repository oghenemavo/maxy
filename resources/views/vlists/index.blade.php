@extends('layouts.main')

@section('content')

<div class="m-grid__item m-grid__item--fluid  m-grid m-grid--ver-desktop m-grid--desktop m-page__container m-body">

                <!-- BEGIN: Left Aside -->
                <button class="m-aside-left-close m-aside-left-close--skin-light" id="m_aside_left_close_btn"><i class="la la-close"></i></button>
                <div id="m_aside_left" class="m-grid__item m-aside-left m--hide">

                    <!-- BEGIN: Aside Menu -->
                    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-light  m-aside-menu--submenu-skin-light " data-menu-vertical="true" m-menu-scrollable="0" m-menu-dropdown-timeout="500">


                        <div class="m-portlet">
                                    <div class="m-portlet__head">
                                        <div class="m-portlet__head-caption">
                                            <div class="m-portlet__head-title">
                                                <h3 class="m-portlet__head-text">
                                                    Value lists
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-portlet__body">
                                        <div id="m_tree_6" class="tree-demo">
                                        </div>
                                        
                                    </div>
                                </div>



                        
                    </div>

                    <!-- END: Aside Menu -->
                </div>

                <!-- END: Left Aside -->
                <div class="m-grid__item m-grid__item--fluid m-wrapper">

                    <!-- BEGIN: Subheader -->
                    <div class="m-subheader ">
                        <div class="d-flex align-items-center">
                            <div class="mr-auto">
                                <h3 class="m-subheader__title m-subheader__title--separator">Value lists</h3>
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
                       
                        <div class="m-portlet m-portlet--mobile">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title">
                                        <h3 class="m-portlet__head-text">
                                            All value lists
                                        </h3>
                                    </div>
                                </div>
                                <div class="m-portlet__head-tools">
                                    <ul class="m-portlet__nav">
                                        <li class="m-portlet__nav-item">
                                            
                                            <a data-view="{{ route('create-vlist') }}" data-toggle="modal" data-placement="bottom" title="Profile" data-target="#commonModal" class="btn btn-accent m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air" href="" id="modalButton" data-type='normal' data-title="Add a new Value List" > <i class="la la-plus"></i> Add a Value List now</a>        

                                            <!-- <a href="#" class="btn btn-accent m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                                                <span>
                                                    <i class="la la-plus"></i>
                                                    <span>New Record</span>
                                                </span>
                                            </a> -->
                                        </li>
                                        <li class="m-portlet__nav-item"></li>
                                        
                                    </ul>
                                </div>
                            </div>
                            <div class="m-portlet__body">

                                <!--begin: Datatable -->
                                <table class="table table-striped- table-bordered table-hover table-checkable" id="file_table">
                                    <thead>
                                       
                                        <tr>
                                            <th>S/N</th>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @foreach($vlists as $key => $vlist)
                                            
                                            @php
                                            $view_url = route('view-group', $vlist->id);
                                            $edit_url = route('edit-vlist', $vlist->id);
                                            $delete_url = route('delete-vlist', $vlist->id);
                                            $options = [ 
                                                ['id'=>$vlist->id, 'action_type'=>'modal', 'action_label'=>'View', 'action_title'=>'View', 'action_url' => $view_url],
                                            ];

                                            if($vlist->type == 'LOCAL' || $vlist->type == 'REMOTE')    
                                                $options[] = ['id'=>$vlist->id, 'action_type'=>'modal', 'action_label'=>'Edit ', 'action_title'=>'Edit ', 'action_url' => $edit_url];


                                            @endphp

                                            <tr>
                                                <td> {{ $key+1 }}</td>
                                                <td> {{ $vlist->name }} </td>
                                                <td>{{ str_limit($vlist->type, 40) }}</td>
                                                <td>

                                                    

                                                    @if($vlist->type == 'LOCAL' || $vlist->type == 'REMOTE')   

                                                    <a href="{{ $edit_url }}" title="Edit" data-view="{{ $edit_url }}" data-toggle="modal" data-placement="bottom" title="Profile" data-target="#commonModal" class="" href="" id="modalButton" data-type='wide' data-title="Edit value list" >
                                                        <button type="submit" class="btn btn-default btn-xs"><i class="fa fa-edit"></i></button>
                                                    </a> 
                                                    @endif
                                                    @if($vlist->type == 'LOCAL' || $vlist->type == 'REMOTE' || $vlist->type == 'EXCEL')

                                                    
                                                        <a type="submit" href="{{ $delete_url }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this value list?');"><i class="fa fa-trash"></i></a>
                                                    

                                                    @endif
                                                    @if($vlist->type == 'REMOTE')   

                                                <a href="{{route('refresh-database', $vlist->id)}}" class="btn btn-success btn-xs" role="button"><i class="fa fa-sync"></i></a>
                                                    
                                                    @endif 


                                                    {{-- @include('common.actions') --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- END EXAMPLE TABLE PORTLET-->
                    </div>




                </div>
            </div>



 

@endsection

@section('scripts')
<script src="{{ asset('assets/demo/default/custom/components/base/treeview.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {

      var table = $('#file_table').DataTable({
            responsive: true,
            select: true,
            order: [[ 2, "asc" ]], //or asc 
            columnDefs: [
                {
                    "targets": [ 0 ],
                    "visible": false,
                    "searchable": false
                },
            ],
        });
        });

        @if (session('info'))

        toastr.success("{{ session('info') }}", "Info");

        @endif

        @if (session('error'))

        toastr.error("{{ session('error') }}", "Error");

        @endif

        @if ($errors->any())
        {{dd($errors)}}
            @foreach ($errors->all() as $error)
            toastr.error("{{$error }}", "Error")
            @endforeach
    
        @endif

        @if (session('success'))

        setTimeout('swal({type:"success",title:"{{ session('success') }}",showConfirmButton:!1,timer:1500})',1000);
        toastr.info("{{ session('success') }}", "Success");


@endif
   
</script>
@endsection
