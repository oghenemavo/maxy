<style>
.m-header-menu .m-menu__nav>.m-menu__item.m-menu__item--tabs>.m-menu__link .m-menu__link-text{
    color: #000000 !important;

}
.m-header-menu .m-menu__nav>.m-menu__item.m-menu__item--tabs.m-menu__item--active-tab>.m-menu__link .m-menu__link-text,
.m-menu__nav>.m-menu__item.m-menu__item--tabs.m-menu__item--hover>.m-menu__link .m-menu__link-text{
    color: #382244!important;

}

</style>
<div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-dark m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-light m-aside-header-menu-mobile--submenu-skin-light ">
    <ul class="m-menu__nav  m-menu__nav--submenu-arrow ">
        <li class="m-menu__item {{ (@$mainTab == 'dashboard')?"m-menu__item--active m-menu__item--active-tab":"" }}     m-menu__item--submenu1 m-menu__item--tabs"
            m-menu-submenu-toggle="tab" aria-haspopup="true" style="color:black"><a href="{{ route('dashboard') }}" class="m-menu__link m-menu__toggle1"><span 
                    class="m-menu__link-text">Dashboard</span><i class="m-menu__hor-arrow la la-angle-down"></i><i
                    class="m-menu__ver-arrow la la-angle-right"></i></a>
            <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left m-menu__submenu--tabs"><span
                    class="m-menu__arrow m-menu__arrow--adjust"></span>
                <ul class="m-menu__subnav">

                    <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                        <h5 class="m--font-success"> 
                            &nbsp;&nbsp;&nbsp;&nbsp; Welcome {{ Auth::user()->first_name.' '.Auth::user()->last_name }}</h5>
                    </li>

                    <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                        <div class="m-menu__link m-menu__link--toggle-skip">
                           
                            <a href="{{ route('new-file-upload') }}" class="btn btn-primary text-light m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill ">
                                <span>
                                    {{-- <i class="la la-upload"></i> --}}
                                        <span>Initiate workflow</span>
                                </span>
                            </a>
                        </div>
                    </li>
                

                    <li class="m-menu__item  m-menu__item--actions" aria-haspopup="true">
                        <div class="m-menu__link m-menu__link--toggle-skip">
                            <a href="{{ route('file-upload-page') }}" class="btn btn-primary text-light m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill ">
                                <span>
                                    <i class="la la-upload"></i>
                                        <span>Upload File</span>
                                </span>
                            </a>
                        </div>
                    </li>
                
                </ul>
            </div>
        </li>
        <li class="m-menu__item  {{ (@$mainTab == 'files')?"m-menu__item--active m-menu__item--active-tab":" " }}  m-menu__item--submenu m-menu__item--tabs"
            m-menu-submenu-toggle="tab" aria-haspopup="true"><a href="{{ route('all-files', ['fld'=>'-1']) }}" class="m-menu__link "
><span   class="m-menu__link-text" style="color:black">Files</span></a>
            <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left m-menu__submenu--tabs"><span
                    class="m-menu__arrow m-menu__arrow--adjust"></span>
                <ul class="m-menu__subnav">
                    <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="{{ route('all-files', ['fld'=>'-1']) }}"
                            class="m-menu__link "><i class="m-menu__link-icon flaticon-file"></i><span class="m-menu__link-text">All
                                Files</span></a></li>
                    {{-- <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="{{ route('all-files') }}"
                            class="m-menu__link "><i class="m-menu__link-icon fa fa-folder"></i><span class="m-menu__link-text">By
                                Categories</span></a></li> --}}


                    <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="{{ route('file-categorize') }}"
                            class="m-menu__link "><i class="m-menu__link-icon fa fa-list"></i><span class="m-menu__link-text">
                                Unindexed Files</span></a></li>

                    
                    


                    
                    

                    <li class="m-menu__item  m-menu__item--actions" aria-haspopup="true">
                        <div class="m-menu__link m-menu__link--toggle-skip">
                            <a href="{{ route('file-upload-page') }}" class="btn btn-primary text-light m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill ">
                                <span>
                                    <i class="la la-upload"></i>
                                        <span>Upload File</span>
                                </span>
                            </a>                
                        </div>
                    </li>
                </ul>
            </div>
        </li>


        @if( in_array( Auth::user()->access_type, ["COMPANY ADMIN", "DATAMAX ADMIN", "SPECIAL ADMIN"]))

        <li class="m-menu__item {{ (@$mainTab == 'file-controls')?"m-menu__item--active m-menu__item--active-tab":"" }} m-menu__item--submenu m-menu__item--tabs"
            m-menu-submenu-toggle="tab" aria-haspopup="true"><a href="{{ route('file-categories') }}" class="m-menu__link "><span  class="m-menu__link-text" style="color:black">File Control</span><i class="m-menu__hor-arrow la la-angle-down"></i><i
                    class="m-menu__ver-arrow la la-angle-right"></i></a>
            <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left m-menu__submenu--tabs"><span
                    class="m-menu__arrow m-menu__arrow--adjust"></span>
                <ul class="m-menu__subnav">
                    <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="{{ route('file-categories') }}"
                            class="m-menu__link "><i class="m-menu__link-icon flaticon-user"></i><span class="m-menu__link-text">File Categories</span></a></li>
                    <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="{{ route('user-fields') }}"
                            class="m-menu__link "><i class="m-menu__link-icon  fa fa-cogs"></i><span class="m-menu__link-text">Metadata Fields</span></a></li>


                     <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="{{ route('value-lists') }}"
                            class="m-menu__link "><i class="m-menu__link-icon  fa fa-list"></i><span class="m-menu__link-text">Value lists</span></a></li>        


                     <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="{{ route('workflows') }}"
                            class="m-menu__link "><i class="m-menu__link-icon  fa fa-project-diagram"></i><span class="m-menu__link-text">Workflows</span></a></li>        


                    
                                                      
                </ul>
            </div>
        </li>

        
        <li  class="m-menu__item {{ (@$mainTab == 'users')?"m-menu__item--active m-menu__item--active-tab":"" }} m-menu__item--submenu m-menu__item--tabs"
            m-menu-submenu-toggle="tab" aria-haspopup="true" style="color:black"><a href="{{ url('users') }}" class="m-menu__link "><span  class="m-menu__link-text" style="color:#000000">Settings</span><i class="m-menu__hor-arrow la la-angle-down"></i><i
                    class="m-menu__ver-arrow la la-angle-right"></i></a>
                    <!-- Mayowa removed class "m-menu__toggle from the li above" -->
            <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left m-menu__submenu--tabs"><span
                    class="m-menu__arrow m-menu__arrow--adjust"></span>
                <ul class="m-menu__subnav">
                    <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="{{ route('all-files', ['fld'=>'-2']) }}"
                            class="m-menu__link "><i class="m-menu__link-icon  fa fa-trash"></i><span class="m-menu__link-text">Trash</span></a></li>
                    
                    <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="{{ url('users') }}"
                            class="m-menu__link "><i class="m-menu__link-icon flaticon-user"></i><span class="m-menu__link-text">Users</span></a></li>
                    <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="{{ url('groups') }}"
                            class="m-menu__link "><i class="m-menu__link-icon flaticon-users-1"></i><span class="m-menu__link-text">Groups</span></a></li>

                    <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="{{ url('backup') }}"
                            class="m-menu__link "><i class="m-menu__link-icon flaticon-box-1"></i><span class="m-menu__link-text">Backups</span></a></li>

                     <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="{{ route('email-settings') }}"
                            class="m-menu__link "><i class="m-menu__link-icon flaticon-email"></i><span class="m-menu__link-text">Email settings</span></a></li>        
                    <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="{{ route('company-details') }}"
                                class="m-menu__link "><i class="m-menu__link-icon  fa fa-info"></i><span class="m-menu__link-text">Company Details</span></a></li>
      
                    <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="{{ route('audits') }}"
                            class="m-menu__link "><i class="m-menu__link-icon  fa fa-eye"></i><span class="m-menu__link-text">Audit Trail</span></a></li>
                    

                            

                </ul>
            </div>
        </li>
        @endif

        
        @if(Auth::user()->access_type == "DATAMAX ADMIN")
        <li class="m-menu__item {{ (@$mainTab == 'settings')?"m-menu__item--active m-menu__item--active-tab":"" }} m-menu__item--submenu m-menu__item--tabs"
            m-menu-submenu-toggle="tab" aria-haspopup="true"><a href="{{ route('view-settings') }}" class="m-menu__link "><span  class="m-menu__link-text">Control Panel</span><i class="m-menu__hor-arrow la la-angle-down"></i><i
                    class="m-menu__ver-arrow la la-angle-right"></i></a>
            <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left m-menu__submenu--tabs"><span
                    class="m-menu__arrow m-menu__arrow--adjust"></span>
                <ul class="m-menu__subnav">
                    <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="{{ route('view-settings') }}"
                            class="m-menu__link "><i class="m-menu__link-icon fa fa-cogs"></i><span class="m-menu__link-text">Settings & Limitations</span></a></li>
                    
                </ul>
            </div>
        </li>
        @endif
    

        
    </ul>
</div>



