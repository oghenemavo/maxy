@extends('layouts.main')

@section('styles')
    <link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> -->

@endsection

@section('content')


<div class="m-grid__item m-grid__item--fluid  m-grid m-grid--ver-desktop m-grid--desktop m-page__container m-body">
                
            {{-- @if($curr_folder_id > -1)  --}}
            @if(TRUE) 
                <!-- BEGIN: Left Aside -->
                <button class="m-aside-left-close m-aside-left-close--skin-light" id="m_aside_left_close_btn"><i class="la la-close"></i> Close </button>
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

                                                <div class="m-portlet__head-tools">
                                                    <ul class="m-portlet__nav">
                                                        <li class="m-portlet__nav-item m-portlet__nav-item--last">
                                                            <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
                                                                <a href="#" id="closeTreeViewBtn"  class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
                                                                    <i class="la la-times"></i>
                                                                </a>
                                                                
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>

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

            @endif    
                <div class="m-grid__item m-grid__item--fluid m-wrapper">

                    <!-- BEGIN: Subheader -->
                    <div class="m-subheader ">
                        <div class="d-flex align-items-center">
                            <div class="mr-auto">
                                <h3 class="m-subheader__title m-subheader__title--separator">
                                    @if($curr_folder_id == -2)
                                        <span class="m--font-danger"> Deleted Files </span>
                                    @elseif($curr_folder_id == -1)
                                        All Files
                                    @elseif(!empty(@$q))
                                        Search result for "{{ $q }}"
                                    @else
                                        {{ $curr_folder->name }} Files
                                    @endif

                                    
                                </h3>
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

                                 {{-- <a href="#" id="openTreeViewBtn" class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--outline-2x m-btn--air m-btn--icon m-btn--icon-only1 m-btn--pill  >
                                        <i class="la la-plus m--hide"></i>
                                        
                                        File categories <i class="la la-ellipsis-h"></i>
                                    </a> --}}

                                
                                @if( in_array( Auth::user()->access_type, ["DATAMAX ADMIN", "SPECIAL ADMIN"]) && $curr_folder_id == -2)

                               <a  href="{{ route('empty-trash') }}" title="Empty trash" class="btn btn-danger m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air"  style="float: right;" onclick="return confirm('Are you sure you want to empty trash? This is irreverssible');"> <i class="la la-trash"></i> Empty Trash </a>      

                               @endif


                                <!-- drop down was here before -->
                                <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push {{ ($curr_folder_id < -1) ? "m--hide" : "" }}" m-dropdown-toggle="hover" aria-expanded="true">
                                    @if($filter)
                                    <a href="#" id="openTreeViewBtn" class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--outline-2x m-btn--air m-btn--icon m-btn--icon-only1 m-btn--pill  >
                                        <i class="la la-plus m--hide"></i>
                                        {{-- <i class="la la-ellipsis-h"></i> --}}
                                        Filter <i class="la la-filter"></i>
                                    </a>
                                    <div class="m-dropdown__wrapper">
                                        <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                        <div class="m-dropdown__inner">
                                            <div class="m-dropdown__body">
                                                <div class="m-dropdown__content">
                                                    <ul class="m-nav">
                                                        {{-- <li class="m-nav__section m-nav__section--first m--hide">
                                                                <a href="" class="m-nav__link jstree-anchor" >
                                                                    <span class="m-nav__section-text"></span>
                                                                </a>
                                                            </li> --}}

                                                        {{-- @foreach($folders as $id => $name) --}}
                                                            <li class="m-nav__item m-2">
                                                                <div class="m-form__label">
                                                                    <label class="m-label m-label--single">Date Created:</label>
                                                                </div>
                                                                <div class='input-group pull-right' id='m_daterangepicker_audit'>
                                                                        <input type='textr' class="form-control m-input" readonly placeholder="Filter by date" />     
                                                                </div>
                                                            </li>
                                                            <li class="m-nav__item m-2">
                                                                <div class="m-form__label">
                                                                    <label class="m-label m-label--single">Date Modified:</label>
                                                                </div>
                                                                <div class='input-group pull-right' id='m_daterangepicker_audit'>
                                                                        <input type='textr' class="form-control m-input" readonly placeholder="Filter by date" />     
                                                                </div>
                                                            </li>
                                                            <li class="m-nav__item m-2">
                                                                <div class="m-form__group m-form__group--inline">
                                                                        <div class="m-form__label">
                                                                            <label class="m-label m-label--single">Uploaded by:</label>
                                                                        </div>
                                                                        
                                                                        <div class="m-form__control">
                                                                            <select class="form-control m-bootstrap-select1 filetype" id="m_form_type1"  onchange="typeChange(this);">
                                                                                <option value="">All</option>
                                                                                @foreach($users as $user)
                                                                                <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                </div>
                                                            </li>
                                                            <li class="m-nav__item m-2">
                                                                <div class="m-form__group m-form__group--inline">
                                                                        <div class="m-form__label">
                                                                            <label class="m-label m-label--single">Metadata</label>
                                                                        </div>
                                                                        <div class="m-form__control">
                                                                            <select class="form-control m-bootstrap-select1 filetype" id="m_form_type1"  onchange="typeChange(this);">
                                                                                <option value="">All</option>
                                                                                @foreach($metadata as $list)
                                                                                <option value="{{ $list->id }}">{{ $list->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                </div>
                                                            </li>

                                                            
                                                        {{-- @endforeach --}}

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push {{ ($curr_folder_id < -1) ? "m--hide" : "" }}" m-dropdown-toggle="hover" aria-expanded="true">
                                    <a href="#" id="openTreeViewBtn" class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--outline-2x m-btn--air m-btn--icon m-btn--icon-only1 m-btn--pill  >
                                        <i class="la la-plus m--hide"></i>
                                        {{-- <i class="la la-ellipsis-h"></i> --}}
                                        File categories <i class="la la-ellipsis-h"></i>
                                    </a>
                                    <div class="m-dropdown__wrapper">
                                        <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                        <div class="m-dropdown__inner">
                                            <div class="m-dropdown__body">
                                                <div class="m-dropdown__content">
                                                    <ul class="m-nav">
                                                        <li class="m-nav__section m-nav__section--first m--hide">
                                                                <a href="" class="m-nav__link jstree-anchor" " >
                                                                    <span class="m-nav__section-text"></span>
                                                                </a>
                                                            </li>

                                                        @foreach($folders as $id => $name)
                                                            <li class="m-nav__item">
                                                                <a href="{{ route('all-files', ['fld'=>$id]) }}" class="m-nav__link jstree-anchor" id="{{ $id }}">
                                                                    <i class="m-nav__link-icon flaticon-folder"></i>
                                                                    <span class="m-nav__link-text">{{ $name }}</span>
                                                                </a>
                                                            </li>

                                                            
                                                        @endforeach

                                                        
                                                        {{-- <li class="m-nav__item">
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
                                                        </li> --}}
                                                        <li class="m-nav__separator m-nav__separator--fit">
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a  title="Profile" class="btn btn-outline-primary m-btn m-btn--pill m-btn--wide btn-sm m-btn--air" href="{{ route('file-categories') }}"  data-type='wide' data-title="Create new File Category"  >See all categories</a>
                                                        </li>

                                                        {{-- <li class="m-nav__separator m-nav__separator--fit">
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a data-view="{{ route('store-folder') }}" data-toggle="modal" data-placement="bottom" title="Profile" data-target="#commonModal" class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm m-btn--air" href="" id="modalButton" data-type='wide' data-title="Create new File Category"  >New Category</a>
                                                        </li> --}}
        



                                                        
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                

                                <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push m--hide" m-dropdown-toggle="hover" aria-expanded="true">
                                    <a href="#" class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--outline-2x m-btn--air m-btn--icon m-btn--icon-only1 m-btn--pill  m-dropdown__toggle">
                                        <i class="la la-plus m--hide"></i>
                                        {{-- <i class="la la-ellipsis-h"></i> --}}
                                        Columns <i class="la la-ellipsis-h"></i>
                                    </a>
                                    <div class="m-dropdown__wrapper">
                                        <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                        <div class="m-dropdown__inner">
                                            <div class="m-dropdown__body">
                                                <div class="m-dropdown__content">
                                                    <ul class="m-nav">
                                                        <li class="m-nav__section m-nav__section--first m--hide">
                                                                <a href="" class="m-nav__link jstree-anchor" " >
                                                                    <span class="m-nav__section-text"></span>
                                                                </a>
                                                            </li>

                                                        

                                                        
                                                        <li class="m-nav__item">
                                                            <a href="" class="m-nav__link">
                                                                <i class="m-nav__link-icon flaticon-add-circular-button m--font-success"></i>
                                                                <span class="m-nav__link-text m--font-success">Name</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="" class="m-nav__link">
                                                                <i class="m-nav__link-icon flaticon-cancel m--font-danger"></i>
                                                                <span class="m-nav__link-text m--font-danger">Size</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="" class="m-nav__link">
                                                                <i class="m-nav__link-icon flaticon-cancel m--font-danger"></i>
                                                                <span class="m-nav__link-text m--font-danger">Type</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="" class="m-nav__link">
                                                                <i class="m-nav__link-icon flaticon-cancel m--font-danger"></i>
                                                                <span class="m-nav__link-text m--font-danger">Last Modified</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="" class="m-nav__link">
                                                                <i class="m-nav__link-icon flaticon-cancel m--font-danger"></i>
                                                                <span class="m-nav__link-text m--font-danger">Category</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="" class="m-nav__link">
                                                                <i class="m-nav__link-icon flaticon-cancel m--font-danger"></i>
                                                                <span class="m-nav__link-text m--font-danger">Is Locked?</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="" class="m-nav__link">
                                                                <i class="m-nav__link-icon flaticon-cancel m--font-danger"></i>
                                                                <span class="m-nav__link-text m--font-danger">Uploaded by</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="" class="m-nav__link">
                                                                <i class="m-nav__link-icon flaticon-cancel m--font-danger"></i>
                                                                <span class="m-nav__link-text m--font-danger">Uploaded at</span>
                                                            </a>
                                                        </li>

                                                        
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <!-- END: Subheader -->
                    
                    <div class="m-content">

                        @if($curr_folder_id > -1)
                        <ul class="nav nav-tabs nav-fill" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('file-categories', ['catId'=>$curr_folder->id] ) }}" >Subfolders ({{ $curr_folder->children_count }})</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active show" >Files ({{ $curr_folder->files_count }})</a>
                            </li>
                            
                        </ul>

                        @endif


                        <div class="m-alert m-alert--icon m-alert--air m-alert--square alert alert-dismissible m--margin-bottom-30 m--hide" role="alert">
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

                                <!--begin: Search Form -->
                                
                                <form class="m-login__form m-form m--hide" action="{{ route('all-files') }}" method="post">

                                    @csrf
                                    {!! Form::hidden('fld', @$curr_folder_id) !!}

                                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30 m--hide1">
                                    <div class="row align-items-center">
                                        <div class="col-xl-8 order-2 order-xl-1">
                                            <div class="form-group m-form__group row align-items-center">
                                              @if(@$curr_folder)  
                                                @foreach($curr_folder->fields as $field)
                                                    @if($field->type == "Text")
                                                        <div class="col-md-3">
                                                            <div class="m-form__group m-form__group--inline">
                                                                <div class="m-form__label">
                                                                    <label>{{ $field->name }}:</label>
                                                                </div>
                                                                <div class="m-form__control">
                                                                    {!! Form::text('fld_'.$field->id,  null, ['class' =>'form-control']) !!}
                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="d-md-none m--margin-bottom-10"></div>
                                                        </div>
                                                    @elseif( in_array($field->type, ["Number", "Decimal" ]) )
                                                        <div class="col-md-3">
                                                            <div class="form-group m-form__group">
                                                                <label id="{{ 'fld_lb_'.$field->id }}">{{ $field->name }}:</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <select  name="{{ 'fld_opt_'.$field->id }}" data-labelid="{{ 'fld_lb_'.$field->id }}" data-label="{{ $field->name }}" class="form-control m-bootstrap-select m_form_status" id="m_form_status">
                                                                                        <option value="=">=</option>
                                                                                        <option value=">">></option>
                                                                                        <option value="<"><</option>
                                                                                        <option value="Between">Between (separate by comma)</option>
                                                                                    </select>
                                                                    </div>
                                                                    {!! Form::text('fld_'.$field->id,  null, ['class' =>'form-control']) !!}
                                                                </div>
                                                            </div>
                                                           
                                                            <div class="d-md-none m--margin-bottom-10"></div>
                                                        </div>
                                                    @elseif( in_array($field->type, ["Dropdown", "Multiple selection" ]) )
                                                        <div class="col-md-3">
                                                            <div class="m-form__group m-form__group--inline">
                                                                <div class="m-form__label">
                                                                    <label>{{ $field->name }}:</label>
                                                                </div>
                                                                <div class="m-form__control">
                                                                    {!! Form::select('fld_'.$field->id, prepDropdownItemsFromCsv($field->options, "All"), null, ['class' =>'form-m-bootstrap-select form-control']) !!}
                                                                </div>
                                                            </div>
                                                            <div class="d-md-none m--margin-bottom-10"></div>
                                                        </div>
                                                    @endif    
                                                @endforeach

                                              @endif  

                                               

                                                <div class="col-md-3">
                                                    <button class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">Search</button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>

                                </form>

                                <hr/>

                                <!--end: Search Form -->
                                
                                
                                

                                <!--begin: Datatable -->
                                <div class="row">
                                
                                <div id="tableMaster" class="col-lg-12">        

                                <table class="table table-striped- table-bordered table-hover table-checkable" id="file_table">
                                    <thead>
                                        <tr>
                                            <th>File Id</th>
                                            <th>Name</th>
                                            <th>Size</th>
                                            <th>Type</th>
                                            <th>Version</th>
                                            <th>Last Modified</th>
                                            <th style="width:60%">Request Details</th>
                                            <th>Amount</th>
                                            <th>Category</th>

                                            @if($curr_folder_id > 0)
                                                
                                                @foreach($curr_folder->fields as $field)
                                                   <th>{{ $field->name }}</th>     

                                                @endforeach

                                            @endif

                                            <th>Locked?</th>
                                            <th>Uploaded by</th>
                                            <th>Uploaded at</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Group Permission logic --}}
                                        @php
                                            // Checks the autheticated user group and gets the id
                                            if(count(Auth::user()->groups) == 0){
                                            $auth_user_group_id = [];
                                           }
                                           else {
                                               foreach (Auth::user()->groups as $group){
                                                   $auth_user_group_id[] = $group->id;
                                               }
                                           }    
                                        @endphp
                                        @foreach($files as $file) 
                                            
                                           {{-- {{($file->groups[0]->pivot->group_id)}} --}}
                                           {{-- {{dd(Auth::user()->groups[0]->id)}} --}}
                                           @php
                                            //  checks the group that has permission to the specific file
                                           if(count($file->groups) == 0){
                                            $file_group_id = "";
                                           }
                                           else {
                                            $file_group_id = $file->groups[0]->pivot->group_id;
                                           }
                                         
                                            //  dump($file->groups[0]->pivot->group_id);

                                            //checks if the autheticated users has permission usto the specific file
                                            if(in_array($file_group_id,$auth_user_group_id)){
                                                $fileGroup = $file->groups;
                                            }
                                            else {
                                                $fileGroup = [];
                                            }
                                            
                                           @endphp
                                           {{-- {{$fileGroup}} --}}
                                           {{----}}
                                           {{-- {{$file->is_permission_set}} --}}
                                            @php 
                                                // if($file->is_permission_set == 1) continue;
                                                // else {
                                                //     if(count($file->auth_user) == 0 && count($fileGroup) == 0 ) continue;
                                                // } 
                                                 if(count($file->auth_user) == 0 && count($fileGroup) == 0 && $file->is_permission_set == 1)   
                                                continue; 
                                            @endphp

                                        <tr>
                                            <td>{{ $file->id }}</td>
                                            <td>{{ $file->name }}</td>
                                            <td>{{ $file->size }}</td>
                                            <td>{{ format_type($file->type) }}</td>
                                            <td>{{ $file->current_version }}</td>
                                            <td>{{ $file->last_modified->toDateTimeString() }}</td>
                                            <td> {{ @$file->fields->where('name', 'Request Details')->first()->pivot->value}}  </td>
                                            <td> {{ number_format(@$file->fields->where('name', 'Amount Requested')->first()->pivot->value,2)}} </td>
                                            <td>{{ $file->folder->name }}</td>
                                            
                                            @if($curr_folder_id > 0)
                                                
                                                @foreach($curr_folder->fields as $field)
                                                   <th>{{ @$file->fields()->find($field->id)->pivot->value }}</th>     

                                                @endforeach

                                            @endif



                                            <td>{{ ($file->is_locked)?"Yes":"No" }}</td>
                                            
                                            <td>{{ $file->createdByUser->first_name.' '.$file->createdByUser->last_name }}</td>
                                            <td>{{ $file->created_at->toDateTimeString() }}</td>
                                            
                                           
                                        </tr>
                                       @endforeach 
                                       
                                    </tbody>
                                    {{-- <tfoot>
                                         <tr>
                                            <th>File Id</th>
                                            <th>Name</th>
                                            <th>Size</th>
                                            <th>Type</th>
                                            <th>Last Modified</th>
                                            <th>Category</th>
                                            <th>Is Locked?</th>
                                            <th>Uploaded by</th>
                                            <th>Uploaded at</th>
                                           
                                        </tr>
                                    </tfoot> --}}
                                </table>
                                                    

                                </div>  
                                <div id="tableDetail" class="col-lg-7 m--hide">
                                    <div class="m-portlet m-portlet--tabs "  id="tableDetailContent">
                                        
                                    </div>

                                   


                                </div>

                                </div>



                                

                                <!--end: Datatable -->
                            </div>
                        </div>

                        <!-- END EXAMPLE TABLE PORTLET-->
                    </div>




                </div>
            </div>




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
                            {!! Form::select('folder_id', $folders, null, ['class' =>'form-control', 'id'=>'folder_id', 'required']) !!}
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
        
        <h4 class="modal-title" id="orgModalTitle">Modal title</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
<!-- {{-- <script src="{{ asset('assets/demo/default/custom/components/base/treeview.js') }}" type="text/javascript"></script> --}} -->


<script type="text/javascript">

    $(document).ready(function () {

        
        $(".m_form_status").on('change', function(){

            $("#"+$(this).data('labelid')).html( $(this).data('label') + " " + $(this).val());
            // console.log("#"+$(this).data('labelid'));
            // console.log($(this).data('label') + " " + $(this).val());

        });
        
       
       @if(false) 
       {{--  @if(TRUE) --}}
        //folder tree....
        $("#m_tree_6")
        // listen for event
          .on('select_node.jstree', function (e, data) {
            var i, j, r = [];
            for(i = 0, j = data.selected.length; i < j; i++) {
               // r.push(data.instance.get_node(data.selected[i]).text);
               if(data.selected[i] != '{{ @$curr_folder_id }}')
                document.location = '{{ route('all-files') }}?fld='+data.selected[i]
            }
            // $('#event_result').html('Selected: ' + r.join(', '));
          })
          // create the instance
          .on('loaded.jstree', function() {
                $("#m_tree_6").jstree('select_node', '{{ @$curr_folder_id }}');
          })   
        .jstree({
            "core" : {
                "themes" : {
                    "responsive": false
                }, 
                // so that create works
                "check_callback" : true,
                'data' : {
                    'url' : function (node) {
                      return '{{ route('get-folder-breakdown') }}';
                    },
                    'data' : function (node) {
                      return { 'parent' : node.id };
                    }
                }
            },
            "types" : {
                "default" : {
                    "icon" : "fa fa-folder m--font-brand"
                },
                "file" : {
                    "icon" : "fa fa-file  m--font-brand"
                }
            },
            "state" : { "key" : "demo3" },
            "plugins" : [ "dnd", "state", "types" ]
        });

        @elseif(false)



        $("#m_tree_6")
        // listen for event
          .on('select_node.jstree', function (e, data) {
            var i, j, r = [];
            for(i = 0, j = data.selected.length; i < j; i++) {
               // r.push(data.instance.get_node(data.selected[i]).text);
               if(data.selected[i] != '{{ @$curr_folder_id }}')
                document.location = '{{ route('all-files') }}?fld='+data.selected[i]
            }
            // $('#event_result').html('Selected: ' + r.join(', '));
          })
          //create the instance
          // .on('loaded.jstree', function() {
          //       $("#m_tree_6").jstree('select_node', '{{ @$curr_folder_id }}');
          // })   
        .jstree({
            "core" : {
                "themes" : {
                    "responsive": false
                }, 
                // so that create works
                "check_callback" : true,
                'data' : {
                    'url' : function (node) {
                      return '{{ route('get-folder-breakdown') }}';
                    },
                    'data' : function (node) {
                      return { 'parent' : node.id };
                    }
                }
            },
            "types" : {
                "default" : {
                    "icon" : "fa fa-folder m--font-brand"
                },
                "file" : {
                    "icon" : "fa fa-file  m--font-brand"
                }
            },
            "state" : { "key" : "demo3" },
            "plugins" : [ "dnd", "state", "types" ]
        });




        @endif


        $.contextMenu({
            selector: '.jstree-anchor1',
            items: {
                edit: {
                    name: "Edit",
                    icon: "edit",
                    callback: function(key, opt){
                        // console.log("payroll ");
                        
                        var params = { 'folder_id' :  opt.$trigger[0].id};
                        loadModal("Edit Category", "{{ route('store-folder') }}", params);
                    }
                },

                @if((Auth::user()->access_type != "General staff" || Auth::user()->access_type !=  "Limited Staff"))
                delete: {
                    name: "Move to Trash",
                    icon: "delete",
                    callback: function(key, opt){
                        if(confirm("Are you sure you want to move this folder and the including files and folder to trash?")){
                            // console.log('folder id: '+ opt.$trigger[0].id);
                            $("#m_tree_6").addClass("m-loader m-loader--right m-loader--light");
                            $.ajax({
                                type: "POST",
                                url: "{{ route('trash-folder') }}",
                                data: { 'folder_id': opt.$trigger[0].id, '_token': '{{ csrf_token() }}' },
                                // dataType: "json",
                                success: function(l) {
                                    // console.log(l);
                                     if(l.success){
                                        
                                        toastr.success(l.message, "Success");
                                        
                                        setTimeout('location.reload()',1000);

                                    }else{
                                        
                                        toastr.error(l.message, "Error");
                                    }
                                },
                                error: function() {
                                    toastr.error("Error trashing the folder. Please try again", "Error");
                                }
                            }); 
                        }
                    }
                },

                @endif

                "sep1": "---------",
                permissions: {
                    name: "Permissions",
                    icon: "user",
                    callback: function(key, opt){
                        location.reload();
                    }
                },

            }
        });





        // list of folders...
        var dataString = JSON.stringify('{{ $files }}');
        var dataJSONArray = JSON.parse(dataString);
        var viewFile = "{{ route('create-group') }}"




        var table = $('#file_table').DataTable({
            dom: 'Bfrtip',
            responsive: true,
            select: true,
            order: [[ 4, "desc" ]], //or asc 
            columnDefs: [
                {
                    "targets": [ 0,2,4 ],
                    "visible": false,
                    "lengthChange": true,
                    "searchable": false
                },{
                    targets: [0,2],
                    className: 'noVis'
                }
            ],
            buttons: [
                {
                    extend: 'colvis',
                    columns: ':not(.noVis)',

                },
                'pageLength', 'copy','excel','print'
            ]
        });
        
        var filteredData = table.column(6)
                .data()
                .filter( function ( value, index ) {
                    // console.log(value);
                    return (value == 'Client') ?  true : false;
                } );
                

        table
        .on( 'select', function ( e, dt, type, indexes ) {
            var rowData = table.rows( indexes ).data().toArray();
            // console.log(rowData);
            $("#tableMaster").removeClass('col-lg-12');
            $("#tableMaster").addClass('col-lg-5');

            $("#tableDetail").removeClass('m--hide');

            $.ajax({
                type: "POST",   
                url: "{{ route('view-file') }}/"+rowData[0][0],
                data: {  '_token': '{{ csrf_token() }}' },
                // dataType: "json",
                success: function(l) {
                   
                    $("#tableDetailContent").html(l);

                },
                error: function() {
                    toastr.error("An error occurred displaying the details", "Error");
                }
            }); 

            
        } );
       




        var datatable = $('.m_datatable').mDatatable({
            // datasource definition
            data: {
                type: 'local',
                source: dataJSONArray,
                pageSize: 20
            },

            // layout definition
            layout: {
                theme: 'default', // datatable theme
                class: '', // custom wrapper class
                scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
                // height: 450, // datatable's body's fixed height
                footer: false // display/hide footer
            },

            // column sorting
            sortable: true,
            select: {
                style: 'single'
            },

            pagination: true,

            search: {
                input: $('#generalSearch')
            },

            // inline and bactch editing(cooming soon)
            // editable: false,

            // columns definition
            columns: [
             {
                field: "name",
                title: "File Name"
            }, {
                field: "type",
                title: "File Type",
                responsive: {visible: 'lg'}
            }, {
                field: "size",
                title: "Size",
                width: 100,
                type: "number"
            }, {
                field: "current_version",
                title: "Current version",
                responsive: {visible: 'lg'}
            }, {
                field: "last_modified",
                title: "Last Modified",
                type: "date",
                format: "MM/DD/YYYY"
            }, {
                field: "created_by",
                title: "Created By",
                template: function (row) {
                    
                    return row.created_by_user.first_name + " " +row.created_by_user.last_name;
                }
            }, {
                field: "type",
                title: "Type",
                // callback function support for column rendering
                template: function (row) {
                    var status = {
                        "image/png": {'title': 'text/plain', 'class': 'm-badge--brand'},
                        "text/plain": {'title': 'img/png', 'class': ' m-badge--metal'},
                        "text/x-php": {'title': 'img/jpg', 'class': ' m-badge--primary'},
                        4: {'title': 'Success', 'class': ' m-badge--success'},
                        5: {'title': 'Info', 'class': ' m-badge--info'},
                        6: {'title': 'Danger', 'class': ' m-badge--danger'},
                        7: {'title': 'Warning', 'class': ' m-badge--warning'}
                    };
                    return '<span class="m-badge ' + status[row.type].class + ' m-badge--wide">' + status[row.type].title + '</span>';
                }
            // }, {
            //     field: "Type",
            //     title: "Type",
            //     // callback function support for column rendering
            //     template: function (row) {
            //         var status = {
            //             1: {'title': 'Online', 'state': 'danger'},
            //             2: {'title': 'Retail', 'state': 'primary'},
            //             3: {'title': 'Direct', 'state': 'accent'}
            //         };
            //         return '<span class="m-badge m-badge--' + status[row.Type].state + ' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-' + status[row.Type].state + '">' + status[row.Type].title + '</span>';
            //     }
            }, {
                field: "Actions",
                width: 110,
                title: "Actions",
                sortable: false,
                overflow: 'visible',
                template: function (row, index, datatable) {
                    var dropup = (datatable.getPageSize() - index) <= 4 ? 'dropup' : '';
                    var viewFile = "{{ url('file/view') }}/"+row.id
                    var checkInFile = "{{ url('file/checkin') }}/"+row.id+"/1"

                    return '\
                        <div class="dropdown ' + dropup + '">\
                            <a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown">\
                                <i class="la la-ellipsis-h"></i>\
                            </a>\
                            <div class="dropdown-menu dropdown-menu-right">\
                                <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>\
                                <a class="dropdown-item" href="'+checkInFile+'"><i class="la la-edit"></i> Check-in</a>\
                                <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>\
                                <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>\
                            </div>\
                        </div>\
                       <a data-view='+viewFile+' data-toggle="modal" data-placement="bottom" title="Profile" data-target="#commonModal" class="btn btn-warning text-light m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air"  id="modalButton" data-type="wide" data-title="View File" > View </a>\
                    ';
                }
            }]
        });
        
                


        $('#m_form_status').on('change', function () {
            datatable.search($(this).val(), 'Status');
        });

        $('#m_form_type').on('change', function () {
            datatable.search($(this).val(), 'Type');
        });

        $('#m_form_status, #m_form_type').selectpicker();



        $('body').on("click", '.load-file', function (e) {

            // console.log( $(this).attr('ref'));

              var file_id     = $(this).attr('ref'),
                  url               = "{{ route('store-folder') }}",
                  datastring    = { folder_id : 1 };

              loadModal("File details", url, datastring);

              return false;

          });


        $("#closeTreeViewBtn").on("click", function(){
               $("#m_aside_left").addClass("m--hide"); 
        });

        $("#openTreeViewBtn").on("click", function(){
               // $("#m_aside_left").removeClass("m--hide"); 
        });

        
        


    });


    function loadModal(modalTitle, url, params){

        $("#orgModalTitle").html(modalTitle);
        $("#orgModalBody").html("please wait");
        $("#addPayrollItem").modal('show');

        $.ajax({
            type: "GET",
            url: url,
            data: params,
            // dataType: "json",
            success: function(data) {
                $('#orgModalBody').html( data );
            },
            error: function() {
                alert('error handing here');
            }
        }); 

    }


    @if (session('info'))

        toastr.success("{{ session('info') }}", "Info");

    @endif

    @if (session('error'))

        toastr.error("{{ session('error') }}", "Error");

    @endif

    @if (session('success'))

        setTimeout('swal({type:"success",title:"{{ session('success') }}",showConfirmButton:!1,timer:1500})',1000);
        toastr.info("{{ session('success') }}", "Success");
        

    @endif


</script>
@endsection
