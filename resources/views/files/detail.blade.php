@php 
    $userPivot = @$file->auth_user[0]->pivot;
    // Checks the autheticated user group and gets the id
    if(count(Auth::user()->groups) == 0){
        $auth_user_group_id = [];
        }
        else {
            foreach (Auth::user()->groups as $group){
                $auth_user_group_id[] = $group->id;
            }
        } 
    
    $groupPivot = @$file->groups[0]->pivot;
@endphp
    

<div class="m-portlet__head">
    
    <div class="m-portlet__head-tools">
        <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--right m-tabs-line-danger" role="tablist">
            <li class="nav-item m-tabs__item">
                <a class="nav-link m-tabs__link active show" data-toggle="tab" href="#m_portlet_tab_1_1" role="tab" aria-selected="true">
                    <i class="flaticon-file-2"></i>Metadata
                </a>
            </li>

            <li class="nav-item m-tabs__item">
                <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_portlet_tab_2_1" role="tab" aria-selected="true">
                    <i class="flaticon-file-2"></i>Details
                </a>
            </li>
            <li class="nav-item m-tabs__item">
                <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_portlet_tab_1_2" role="tab" aria-selected="false">
                    <i class="flaticon-search-1"></i>Preview
                </a>
            </li>
            <li class="nav-item m-tabs__item">
                <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_portlet_tab_1_7" role="tab" aria-selected="false">
                    <i class="flaticon-file-2"></i>Related Files
                </a>
            </li>
	    <li class="nav-item m-tabs__item">
                @if($isModal)
                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_portlet_tab_1_9" role="tab" aria-selected="false">
                        <i class="flaticon-file-2"></i>Upload
                    </a>
                @endif
            </li>

            {{-- <li class="nav-item m-tabs__item">
                <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_portlet_tab_1_3" role="tab" aria-selected="false">
                    <i class="fa project-diagram"></i>Workflow
                </a>
            </li> --}}
          {{--   <li class="nav-item m-tabs__item">
                <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_portlet_tab_1_3" role="tab" aria-selected="false">
                    <i class="flaticon-lock"></i>Permissions
                </a>
            </li> --}}

            <li class="nav-item dropdown m-tabs__item m--hide1">
                <a class="nav-link m-tabs__link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">More</a>
                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(91px, 65px, 0px);">

                    @if(@$userPivot->can_write && !$file->trashed())
                    <a class="dropdown-item" data-toggle="tab" href="#m_portlet_tab_1_6" role="tab" aria-selected="false">
                        Permissions
                    </a>
                    @endif


                    <a class="dropdown-item" data-toggle="tab" href="#m_portlet_tab_1_4" role="tab" aria-selected="false">
                        Versions
                    </a>
                   {{--  <a class="dropdown-item" data-toggle="tab" href="#m_portlet_tab_1_5" role="tab" aria-selected="false">
                        Logs
                    </a> --}}
                    {{-- <div class="dropdown-divider"></div>
                    <a class="dropdown-item" data-toggle="tab" href="#m_portlet_tab_2_3">Separated link</a> --}}
                </div>
            </li>
           {{--  <li class="nav-item m-tabs__item">
                <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_portlet_tab_1_3" role="tab" aria-selected="false">
                    Permissions
                </a>
            </li> --}}
           {{--  <li class="nav-item m-tabs__item">
                <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_portlet_tab_1_4" role="tab" aria-selected="false">
                    Versions
                </a>
            </li> --}}
           {{--  <li class="nav-item m-tabs__item">
                <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_portlet_tab_1_5" role="tab" aria-selected="false">
                    Logs
                </a>
            </li> --}}
        </ul>
    </div>
    
    @if(!$isModal)    
    <div class="m-portlet__head-caption">
        <div class="m-portlet__head-title">
           {{--  <h3 class="m-portlet__head-text">
                Details
            </h3> --}}
            
            
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item m-portlet__nav-item--last">
                            <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
                                <a href="#" id="closePreviewBtn"  class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
                                    <i class="la la-times"></i>
                                </a>
                                
                            </div>
                        </li>
                    </ul>
                </div>
            

        </div>
    </div>
    @endif

</div>
<div class="m-portlet__body">
    <div class="tab-content">
        <div class="tab-pane active show" id="m_portlet_tab_1_1">
           @include('files.view.metadata')
        </div>
        <div class="tab-pane" id="m_portlet_tab_2_1">
            @include('files.view.details')
        </div>
        <div class="tab-pane" id="m_portlet_tab_1_2">
            @include('files.view.preview')
        </div>

         {{-- <div class="tab-pane" id="m_portlet_tab_1_3">
            @include('files.view.workflow')
        </div> --}}
        <div class="tab-pane" id="m_portlet_tab_1_6">
            @include('files.view.permissions')
        </div>
        <div class="tab-pane" id="m_portlet_tab_1_4">
            @include('files.view.versions')
        </div>
        <div class="tab-pane" id="m_portlet_tab_1_5">
            @include('files.view.logs')
        </div>
        <div class="tab-pane" id="m_portlet_tab_1_7">
            @include('files.view.otherfiles')
        </div>
	<div class="tab-pane" id="m_portlet_tab_1_9">
            @include('files.view.upload')
        </div>
    </div>
</div>


<script type="text/javascript">

     $(document).ready(function () {
            $("#closePreviewBtn").on("click", function(){
                $("#tableDetail").addClass("m--hide"); 
                $("#tableMaster").removeClass('col-lg-5');
                $("#tableMaster").addClass('col-lg-12');
                console.log("pelase close....");
            });

     });

     function activateTab(tab){
      $('.nav-tabs a[href="#' + tab + '"]').tab('show');
    };
    
    
</script>


