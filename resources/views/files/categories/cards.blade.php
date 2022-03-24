@extends('layouts.main')

@section('content')


<div class="m-grid__item m-grid__item--fluid  m-grid m-grid--ver-desktop m-grid--desktop m-page__container m-body">

                

                <!-- END: Left Aside -->
                <div class="m-grid__item m-grid__item--fluid m-wrapper">

                    <!-- BEGIN: Subheader -->
                    <div class="m-subheader ">
                        <div class="d-flex align-items-center">
                            <div class="mr-auto">
                                <h3 class="m-subheader__title m-subheader__title--separator">
                                    {{ (isset($category)) ? (($category->parent_id != 1) ? $category->name." subfolder" : $category->name." category" ) : "File Categories"  }}
                                </h3>

                                @if(isset($category))
                                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline hidden">
                                    <li class="m-nav__item m-nav__item--home">
                                        <a href="{{ route('file-categories', ['catId'=>$category->parent_id] ) }}" class="m-nav__link m-nav__link--icon">
                                            <i class="m-nav__link-icon fa fa-angle-up"></i>
                                            Up one level
                                        </a>
                                    </li>
                                    {{-- <li class="m-nav__separator">-</li>
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
                                    </li> --}}
                                </ul>
                                @endif

                                 

                               
                            </div>

                            @php

                                $create_route = (@$category) ? route('store-folder', ['parent_id'=>$category->id]) : route('store-folder');
                                $folder_text = (@$category && $category->parent_id > 0) ? "subfolder" : "category";


                            @endphp

                            <a data-view="{{ $create_route }}" data-toggle="modal" data-placement="bottom" title="Profile" data-target="#commonModal" class="btn btn-accent m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air" href="" id="modalButton" data-type='wide' data-title="Add a new {{ $folder_text }}" style="float: right;"> <i class="la la-plus"></i> Add a new {{ $folder_text }} </a> 
                            <div>
                               
                            </div>
                        </div>
                    </div>

                    <!-- END: Subheader -->


                    
                    <div class="m-content">

                        @if($category)

                        <ul class="nav nav-tabs nav-fill" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active show" >Subfolders ({{ $category->children_count }})</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('all-files', ['fld'=>$category->id] ) }}">Files ({{ $category->files_count }})</a>
                            </li>
                            
                        </ul>

                        @endif



                        @include('common.alerts')






                        <div class="row" style="background-color: #f2f3f8; padding-top: 15px;">

                            @forelse($categories as $key => $field)

                             @php
                                $view_url = route('all-files', ['fld'=>$field->id] );
                                $edit_url = route('store-folder', ['folder_id'=>$field->id]);
                                $reset_url = route('trash-folder', ['folder_id'=>$field->id, '_token'=>csrf_token()]);
                                $options = [ 
                                    ['id'=>$field->id, 'action_type'=>'link', 'action_label'=>'View files in the folder' , 'action_title'=>'Edit User', 'action_url' => $view_url],
                                    ['id'=>$field->id, 'action_type'=>'modal', 'action_label'=>'Edit Field' , 'action_title'=>'Edit User', 'action_url' => $edit_url],
                                   
                                ];

                              
                                @endphp

                            <div class="col-lg-4">

                                <div class="m-portlet m-portlet--full-height ">
                                    <div class="m-portlet__head">
                                        <div class="m-portlet__head-caption">
                                            <div class="m-portlet__head-title">
                                                <i class="fa fa fa-folder"></i> 
                                                <br/><br/><br/>
                                                <h2 class="m-portlet__head-text">
                                                    
                                                     {{ $field->name }}
                                                </h2>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="m-portlet__body">
                                        <div class="m-widget13">

                                             <div class="m-widget13__item">
                                                <span class="m-widget13__desc m--align-right">
                                                    Files
                                                </span>
                                                <span class="m-widget13__text m-widget13__text-bolder fileCount" data-folderid="{{ $field->id }}">
                                                    {{ number_format($field->files_count) }}
                                                </span>
                                            </div>
                                            <div class="m-widget13__item">
                                                <span class="m-widget13__desc m--align-right">
                                                    Sub-folders
                                                </span>
                                                <span class="m-widget13__text m-widget13__text-bolder">
                                                    {{ number_format($field->children_count) }}
                                                </span>
                                            </div>
                                            <div class="m-widget13__item" style="min-height: 50px;">
                                                <span class="m-widget13__desc m--align-right">
                                                    Metadata
                                                </span>
                                                <span class="m-widget13__text">
                                                    {{ implode(", ", $field->fields()->pluck('name')->toArray()) }}
                                                </span>
                                            </div>
                                            <div class="m-widget13__item" style="min-height: 50px;">
                                                <span class="m-widget13__desc m--align-right">
                                                    Workflow
                                                </span>
                                                <span class="m-widget13__text">
                                                    {{ @$field->workflow->name }}
                                                </span>
                                            </div>
                                            <div class="m-widget13__item">
                                                <span class="m-widget13__desc m--align-right">
                                                    Created
                                                </span>
                                                <span class="m-widget13__text">
                                                    {{ @$field->createdByUser->full_name }}
                                                </span>
                                            </div>
                                            
                                            <div class="m-widget13__action m--align-right">
                                                
                                                <a href="{{ route('all-files', ['fld'=>$field->id] ) }}" data-skin="dark" data-toggle="m-tooltip" data-placement="top" title="" data-original-title="View files in this category">
                                                    <button type="submit" class="btn btn-success btn-xs"><i class="fa fa-list"></i></button>
                                                </a> 

                                                <a href="{{ route('file-categories', ['catId'=>$field->id] ) }}" data-skin="dark" data-toggle="m-tooltip" data-placement="top" title="" data-original-title="View sub-folders in this category">
                                                    <button type="submit" class="btn btn-primary btn-xs"><i class="fa fa-angle-down"></i></button>
                                                </a> 
                                                
                                                @if(in_array(Auth::user()->access_type, [ "DATAMAX ADMIN", "COMPANY ADMIN", "SPECIAL ADMIN" ]))   

                                                 <a href="#" data-skin="dark" data-toggle="m-tooltip" data-placement="top" title="" data-original-title="Duplicate folder structure" >
                                                    <button class="btn btn-primary btn-xs"  onclick="return duplicateFolder('{!! $field->id."', '".$field->name  !!}')"><i class="flaticon-add"></i></button>
                                                </a> 

                                                    

                                                <a href="{{ route('store-folder', [$field->parent_id, $field->id]) }}" data-skin="dark" data-placement="top" title="" data-original-title="Edit Category" data-view="{{ route('store-folder', [$field->parent_id, $field->id]) }}" data-toggle="modal" data-placement="bottom" title="Profile" data-target="#commonModal" class="" href="" id="modalButton" data-type='wide' data-title="Edit {{ ($field->parent_id > 1) ? "subfolder" : "category" }}" >
                                                        <button type="submit" class="btn btn-default btn-xs"><i class="fa fa-edit"></i></button>
                                                </a> 

                                                <a href="{{ route('folder-permission', [ "folderId" => $field->id]) }}"
                                                   data-skin="dark" data-placement="top"  data-original-title="Add Permission"
                                                   data-view="{{ route('folder-permission', [ "folderId" => $field->id]) }}"
                                                   data-toggle="modal" title="Add Permission" data-target="#commonModal"
                                                   id="modalButton" data-type='wide' data-title="Add Permission" >
                                                    <button type="submit" class="btn btn-default btn-xs"><i class="fa fa-lock"></i></button>
                                                </a>
                                                <a href="#" data-skin="dark" data-toggle="m-tooltip" data-placement="top" title="" data-original-title="Trash Category">
                                                    <button type="submit" class="btn btn-danger btn-xs" onclick="return delFolder({{ $field->id }})"><i class="fa fa-trash"></i></button>
                                                </a> 
                                                @endif    

                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                

                                
                            </div>


                            @empty

                                <em> There are no files and subfolders in the category</em>

                            @endforelse


                           
                           
                           
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

        $('.fileCount').each(function() {
            var currentElement = $(this);
            var value = getFileCount(currentElement.data('folderid'), currentElement); 
            
            
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

    function duplicateFolder(folderId, folderName){

        if(confirm("This will create a new subfolder with the name \""+folderName+"_copy\" and same folder structure. \n\nProceed")){
                $.ajax({
                    type: "POST",
                    url: "{{ route('duplicate-folder') }}",
                    data: { 'folder_id': folderId, '_token': '{{ csrf_token() }}' },
                    // dataType: "json",
                    success: function(l) {
                        console.log(l);
                         if(l.success){
                            
                            // toastr.success(l.message, "Success");
                            swal({type:"success",title:"File Category has been duplicated",showConfirmButton:!1,timer:1500});
                            
                            setTimeout('location.reload()',1000);

                        }else{
                            
                            toastr.error(l.message, "Error");
                        }
                    },
                    error: function() {
                        toastr.error("Error duplicating the category. Please try again", "Error");
                    }
                }); 
            }


        return false;                
    }

    // function getFileCount(folderId, element){

    //     $.ajax({
    //             type: "GET",
    //             url: "{{ route('file-count') }}",
    //             data: { 'folder_id': folderId, '_token': '{{ csrf_token() }}' },
    //             // dataType: "json",
    //             success: function(l) {
    //                  if(l.success){
                        
    //                     // toastr.success(l.message, "Success");
    //                     // swal({type:"success",title:"File Category has been duplicated",showConfirmButton:!1,timer:1500});
    //                     element.html(l.message);
                        
    //                     // setTimeout('location.reload()',1000);

    //                 }else{
                        
    //                     toastr.error(l.message, "Error");
    //                 }
    //             },
    //             error: function() {
    //                 toastr.error("Error duplicating the category. Please try again", "Error");
    //             }
    //         }); 
                       
    // }
</script>
@endsection
