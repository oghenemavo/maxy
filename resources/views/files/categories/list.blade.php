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
                                                    Categories
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
                                <h3 class="m-subheader__title m-subheader__title--separator">Categories</h3>
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
                                            Index
                                        </h3>
                                    </div>
                                </div>
                                <div class="m-portlet__head-tools">
                                    <ul class="m-portlet__nav">
                                        <li class="m-portlet__nav-item">

                                            <a data-view="{{ route('store-folder') }}" data-toggle="modal" data-placement="bottom" title="Profile" data-target="#commonModal" class="btn btn-primary text-light m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air" href="" id="modalButton" data-type='wide' data-title="Add a new category" > <i class="la la-plus"></i> Add a new category </a>        
                                            
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
                                            <th>Number of Files</th>
                                            <th>Associated metadata</th>
                                            <th>Created by</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @foreach($categories as $key => $field)
                                            
                                            @php
                                            $view_url = route('all-files', ['fld'=>$field->id] );
                                            $edit_url = route('store-folder', ['folder_id'=>$field->id]);
                                            $reset_url = route('trash-folder', ['folder_id'=>$field->id, '_token'=>csrf_token()]);
                                            $options = [ 
                                                ['id'=>$field->id, 'action_type'=>'link', 'action_label'=>'View files in the folder' , 'action_title'=>'Edit User', 'action_url' => $view_url],
                                                ['id'=>$field->id, 'action_type'=>'modal', 'action_label'=>'Edit Field' , 'action_title'=>'Edit User', 'action_url' => $edit_url],
                                               
                                            ];

                                            // $options = [ 
                                            //     ['id'=>$field->id, 'action_type'=>'link', 'action_label'=>'Reset Password', 'action_title'=>'Reset User Password', 'action_url' => $reset_url],
                                            // ];

                                            // $options[] = ['id'=>$field->id, 'action_type'=>'modal', 'action_label'=>'Edit User' , 'action_title'=>'Edit User', 'action_url' => $edit_url];


                                            @endphp

                                            <tr>
                                                <td> {{ $key+1 }}</td>
                                                <td> <strong>{{ $field->name }} </strong></td>
                                                <td>{{ number_format($field->files_count) }}</td>
                                                <td>{{ implode(", ", $field->fields()->pluck('name')->toArray()) }}</td>
                                                <td> {{ @$field->createdByUser->full_name }} </td>
                                                <td>
                                                    {{-- @include('common.actions') --}}

                                                    <a href="{{ route('all-files', ['fld'=>$field->id] ) }}" title="View files in this folder">
                                                        <button type="submit" class="btn btn-primary btn-xs"><i class="fa fa-list"></i></button>
                                                    </a> 

                                                    <a href="{{ route('store-folder', ['folder_id'=>$field->id]) }}" title="Edit" data-view="{{ route('store-folder', ['folder_id'=>$field->id]) }}" data-toggle="modal" data-placement="bottom" title="Profile" data-target="#commonModal" class="" href="" id="modalButton" data-type='wide' data-title="Edit category" >
                                                        <button type="submit" class="btn btn-default btn-xs"><i class="fa fa-edit"></i></button>
                                                    </a> 

                                                   {{--  <a href="{{ route('folder-perm', ['folder_id'=>$field->id]) }}" title="Permissions" data-view="{{ route('folder-perm', ['folder_id'=>$field->id]) }}" data-toggle="modal" data-placement="bottom" title="Profile" data-target="#commonModal" class="" href="" id="modalButton" data-type='wide' data-title="Folder Permissions" title="Permissions" >
                                                        <button type="submit" class="btn btn-default btn-xs"><i class="fa fa-key"></i></button>
                                                    </a>  --}}

                                                    <a href="#" title="">
                                                        <button type="submit" class="btn btn-danger btn-xs" onclick="return delFolder({{ $field->id }})"><i class="fa fa-trash"></i></button>
                                                    </a> 

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


    function delFolder(folderId){

        if(confirm("Are you sure you want to remove this category?")){
                $.ajax({
                    type: "POST",
                    url: "{{ route('trash-folder') }}",
                    data: { 'folder_id': folderId, '_token': '{{ csrf_token() }}' },
                    // dataType: "json",
                    success: function(l) {
                        console.log(l);
                         if(l.success){
                            
                            // toastr.success(l.message, "Success");
                            swal({type:"success",title:"File Category has been deleted",showConfirmButton:!1,timer:1500});
                            
                            setTimeout('location.reload()',1000);

                        }else{
                            
                            toastr.error(l.message, "Error");
                        }
                    },
                    error: function() {
                        toastr.error("Error removing the category. Please try again", "Error");
                    }
                }); 
            }


        return false;                
    }
</script>
@endsection
