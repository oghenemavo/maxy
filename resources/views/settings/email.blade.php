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
                                                    Email settings
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
                            
                            
			<!--begin::Form-->
			{{-- <form method="post" enctype="multipart/formdata" action="" class=""> --}}
            {!! Form::open([ 'files' => true, 'class'=>'m-form m-form--fit m-form--label-align-right']) !!}
				<div class="m-portlet__body">

					@include('common.alerts')

                    <div class="form-group m-form__group">
						<label for="exampleInputPassword1">Send email with notifications?</label>
						{!! Form::select('send_email', ['No'=>'No','Yes'=>'Yes'], $send_email, ['class'=>'form-control m-input', 'id'=>'sendEmailFld']) !!}
                        
					</div>

                    <div id="emailSettingsDiv" class="{{ ($send_email == 'Yes') ? '' : 'm--hide' }}">

					<div class="form-group m-form__group">
						<label for="exampleInputPassword1">Mail host</label>
						<input type="text" class="form-control m-input" name="host" value="{{ $host }}" required="" id="exampleInputPassword1">
					</div>

					<div class="form-group m-form__group">
						<label for="exampleInputPassword1">Mail port</label>
						<input type="text" class="form-control m-input" name="port" value="{{ $port }}" required="" id="exampleInputPassword1">
					</div>

                    <div class="form-group m-form__group">
                        <label for="exampleInputPassword1">Mail username</label>
                        <input type="" class="form-control m-input" name="username" value="{{ $username }}" required="email" id="exampleInputPassword1">
                    </div>

                    <div class="form-group m-form__group">
                        <label for="exampleInputPassword1">Mail password</label>
                        <input type="password" class="form-control m-input" name="password" value="{{ $password }}" required="" id="exampleInputPassword1">
                    </div>

                    <div class="form-group m-form__group">
                        <label for="exampleInputPassword1">Mail encryption</label>
                        {!! Form::select('encryption', [''=>'None','TLS'=>'TLS'], $encryption, ['class'=>'form-control m-input']) !!}
                    </div>

                    <div class="form-group m-form__group">
                        <label for="exampleInputPassword1">Mail sender</label>
                        <input type="text" class="form-control m-input" name="sender" value="{{ $sender }}" required="" id="exampleInputPassword1">
                    </div>

					

					</div>

                    <br/><br/>
                    
                    

                    

					
					@csrf
					
					<div class="m-portlet__foot m-portlet__foot--fit">
						<div class="m-form__actions">
							<button type="submit" class="btn btn-primary {{ ($send_email == 'Yes') ? '' : 'm--hide' }}" id="SaveValbtn">Save Settings</button>
                            <input  class="cancel btn btn-primary {{ ($send_email == 'Yes') ? 'm--hide' : '' }}"  formnovalidate="formnovalidate" type="submit" value="Save" id="SaveNoValBtn" />
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->			
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
