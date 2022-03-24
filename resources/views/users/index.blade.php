@extends('layouts.main')

@section('content')


<div class="m-grid__item m-grid__item--fluid  m-grid m-grid--ver-desktop m-grid--desktop m-page__container m-body">

                <!-- BEGIN: Left Aside -->
                <button class="m-aside-left-close m-aside-left-close--skin-light" id="m_aside_left_close_btn"><i class="la la-close"></i></button>
                <div id="m_aside_left" class="m-grid__item m-aside-left m--hide">

                    <!-- BEGIN: Aside Menu -->
                    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-light m-aside-menu--submenu-skin-light " data-menu-vertical="true" m-menu-scrollable="0" m-menu-dropdown-timeout="500">


                        <div class="m-portlet">
                                    <div class="m-portlet__head">
                                        <div class="m-portlet__head-caption">
                                            <div class="m-portlet__head-title">
                                                <h3 class="m-portlet__head-text">
                                                    Folders
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
                                <h3 class="m-subheader__title m-subheader__title--separator">Users</h3>
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

                        @include('common.alerts')
                      
                        <div class="m-portlet m-portlet--mobile">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title">
                                        <h3 class="m-portlet__head-text">
                                            All users
                                        </h3>
                                    </div>
                                </div>
                                <div class="m-portlet__head-tools">
                                    <ul class="m-portlet__nav">
                                        <li class="m-portlet__nav-item">

                                            <a data-view="{{ route('import-user') }}" data-toggle="modal" data-placement="bottom" title="import users" data-target="#commonModal" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air" href="" id="modalButton" data-type='wide' data-title="Import User" > <i class="fa fa-file-import"></i> Import Users</a>         
                                            
                                        </li>
                                        <li class="m-portlet__nav-item"></li>
                                       
                                    </ul>
                                </div>
                                <div class="m-portlet__head-tools">
                                    <ul class="m-portlet__nav">
                                        <li class="m-portlet__nav-item">

                                            <a data-view="{{ route('create-user') }}" data-toggle="modal" data-placement="bottom" title="add user" data-target="#commonModal" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air" href="" id="modalButton" data-type='wide' data-title="Add a new User" > <i class="la la-plus"></i> Add User </a>        
                                            
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
                                            <th>Staff Id</th>
                                            
                                            <th>Email</th>
                                            <th>Is Active</th>
                                            
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $key => $user)
                                            
                                            @php
                                            $view_url = route('view-user', $user->id);
                                            $edit_url = route('edit-user', $user->id);
                                            $reset_url = route('reset-user-password', $user->id);
                                            $activate = route('activate-user', [$user->id, 1]);
                                            $deactivate = route('activate-user', [$user->id, 0]);
                                            $options = [ 
                                                ['id'=>$user->id, 'action_type'=>'modal', 'action_label'=>'View User', 'action_title'=>'View User', 'action_url' => $view_url],
                                            ];

                                             $options = [ 
                                                ['id'=>$user->id, 'action_type'=>'link', 'action_label'=>'Reset Password', 'action_title'=>'Reset User Password', 'action_url' => $reset_url],
                                            ];

                                            $options[] = ['id'=>$user->id, 'action_type'=>'modal', 'action_label'=>'Edit User' , 'action_title'=>'Edit User', 'action_url' => $edit_url];
                                            
                                            if(!$user->is_active)
                                             $options[] = ['id'=>$user->id, 'action_type'=>'link', 'action_label'=>'Activate User' , 'action_title'=>'Activate User', 'action_url' => $activate];

                                            if($user->is_active)
                                              $options[] = ['id'=>$user->id, 'action_type'=>'link', 'action_label'=>'Deactivate User' , 'action_title'=>'Deactivate User', 'action_url' => $deactivate];


                                            @endphp
                                            
                                            <tr>
                                                
                                                <td> {{ $key+1 }}</td>
                                                <td> {{ $user->full_name }} </td>
                                                
                                                <td>{{ $user->username }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->is_active ? 'Yes' : 'No' }}</td>
                                                <td>
                                                    @include('common.actions')
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
            order: [[ 1, "asc" ]], //or asc 
            columnDefs: [
                {
                    "targets": [ 0 ],
                    "visible": false,
                    "searchable": false
                },
            ],
        });
        });
</script>
@endsection
