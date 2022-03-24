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
                                                    Workflows
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
                                <h3 class="m-subheader__title m-subheader__title--separator">Workflows</h3>
                                

                            </div>
                              <a data-view="{{ route('create-workflow') }}" data-toggle="modal" data-placement="bottom" title="Profile" data-target="#commonModal" class="btn btn-accent m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air" href="" id="modalButton" data-type='normal' data-title="Create a new Workflow" style="float: right;" > <i class="la la-plus"></i> Create a new Workflow </a>
                            <div>
                               
                            </div>
                        </div>
                    </div>

                    <!-- END: Subheader -->


                    
                    <div class="m-content">
                       
                        <div class="m-portlet m-portlet--mobile">
                            <div class="m-portlet__body">

                                <!--begin: Datatable -->
                                <table class="table table-striped- table-bordered table-hover table-checkable" id="file_table">
                                    <thead>
                                       
                                        <tr>
                                            <th>S/N</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Steps</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @foreach($workflows as $key => $workflow)
                                            
                                            @php
                                            $view_url = route('view-workflow', $workflow->id);
                                            $edit_url = route('edit-workflow', $workflow->id);
                                            $options = [ 
                                                ['id'=>$workflow->id, 'action_type'=>'modal', 'action_label'=>'View workflow', 'action_title'=>'View workflow', 'action_url' => $view_url],
                                            ];

                                            $options[] = ['id'=>$workflow->id, 'action_type'=>'modal', 'action_label'=>'Edit workflow', 'action_title'=>'Edit workflow', 'action_url' => $edit_url];


                                            @endphp

                                            <tr>
                                                <td> {{ $key+1 }}</td>
                                                <td> {{ $workflow->name }} </td>
                                                <td>{{ str_limit($workflow->description, 40) }}</td>
                                                <td> {{ $workflow->steps_count }} </td>
                                                <td>
                                                    <a href="{{ $view_url }}" title="View workflow" >
                                                        <button type="submit" class="btn btn-default btn-xs"><i class="fa fa-eye"></i></button>
                                                    </a> 

                                                    <a href="{{ $edit_url }}" title="Edit" data-view="{{ $edit_url }}" data-toggle="modal" data-placement="bottom" title="Profile" data-target="#commonModal" class="" href="" id="modalButton" data-type='wide' data-title="Edit workflow" >
                                                        <button type="submit" class="btn btn-default btn-xs"><i class="fa fa-edit"></i></button>
                                                    </a> 

                                                    <a href="#" title="">
                                                        <button type="submit" class="btn btn-danger btn-xs" onclick="return delField({{ $workflow->id }})"><i class="fa fa-trash"></i></button>
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


    function delField(fieldId){

        if(confirm("Are you sure you want to remove this workflow?")){
                $.ajax({
                    type: "POST",
                    url: "{{ route('trash-user-field') }}",
                    data: { 'field_id': fieldId, '_token': '{{ csrf_token() }}' },
                    // dataType: "json",
                    success: function(l) {
                        console.log(l);
                         if(l.success){
                            
                            // toastr.success(l.message, "Success");
                            swal({type:"success",title:"field has been deleted",showConfirmButton:!1,timer:1500});
                            
                            // setTimeout('location.reload()',1000);

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
