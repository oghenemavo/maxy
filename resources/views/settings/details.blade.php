@extends('layouts.main')

@section('content')
<div class="m-grid__item m-grid__item--fluid  m-grid m-grid--ver-desktop m-grid--desktop m-page__container m-body">

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
                                                    Company Details
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
                   	


                    <!-- END: Subheader -->


                    
                    <div class="m-content">
                       
                        <div class="m-portlet m-portlet--mobile">
                            
                          <!--Begin::Portlet-->
                          <div class="m-portlet m-portlet--full-height  m-portlet--rounded">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title">
                                        <h3 class="m-portlet__head-text">
                                            License Details
                                        </h3>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="m-portlet__body">
                                <div class="tab-content">
                                    <div >
                                    <h5><strong>Company Name :</strong> {{$name}} </h4>
                                    <h5><strong>No of License :</strong> {{$user_limit}} </h5>
                                    <h5><strong>Date of expiration :</strong> {{$expiry_date}} </h5>
                                       
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                        <!--End::Portlet-->  
						
		                </div>
                            

                        <!-- END EXAMPLE TABLE PORTLET-->
                    </div>




                </div>
            </div>



 

@endsection
@section('scripts')
    
<script type="text/javascript">
    $(document).ready(function () {

      $("#sendEmailFld").on('change', function(){
            $send = $("#sendEmailFld").val();
            if($send == "Yes"){
                $("#emailSettingsDiv").removeClass("m--hide");
                $("#SaveValbtn").removeClass("m--hide");
                $("#SaveNoValBtn").addClass("m--hide");

            }
            else{
                $("#emailSettingsDiv").addClass("m--hide");
                $("#SaveNoValbtn").removeClass("m--hide");
                $("#SaveNoValBtn").addClass("m--hide");

            }

      });

    });
</script>

@endsection
