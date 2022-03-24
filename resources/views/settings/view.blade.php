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
                                                    Settings
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
			{{-- <form method="post" enctype="multipart/formdata" action="" class="> --}}
            {!! Form::open([ 'files' => true, 'class'=>'m-form m-form--fit m-form--label-align-right']) !!}
				<div class="m-portlet__body">

					@include('common.alerts')

                    <div class="m-form__heading">
                        <h3 class="m-form__heading-title">1. Company details:</h3>
                    </div>
					
					<div class="form-group m-form__group">
						<label for="exampleInputPassword1">Company name</label>
						<input type="text" class="form-control m-input" name="name" value="{{ $name }}" required="" id="exampleInputPassword1">
					</div>

					{{-- <div class="form-group m-form__group">
						<label for="exampleInputPassword1">Company email</label>
						<input type="text" class="form-control m-input" name="email" value="{{ $email }}" required="" id="exampleInputPassword1">
					</div>

					<div class="form-group m-form__group">
						<label for="exampleInputPassword1">Company Phone</label>
						<input type="text" class="form-control m-input" name="phone" value="{{ $phone }}" required="" id="exampleInputPassword1">
					</div>

					<div class="form-group m-form__group">
						<label for="exampleInputPassword1">Company Address</label>
						<textarea name="address" class="form-control"> {{ $address }}  </textarea>
					</div> --}}

					<div class="form-group m-form__group">
						<label for="exampleInputPassword1">Company Logo</label>
                        <br>
                        <small>File must be an image (jpeg, png, bmp, gif, or svg). File size should not be more than 5MB</small>
                        <br>
						<input type="file" name="logo">
					</div>

                    {{-- <hr/> --}}
                    

                    <div class="m-form__seperator m-form__seperator--dashed"></div>
                    <div class="m-form__section m-form__section--last">
                        <div class="m-form__heading">
                            <h3 class="m-form__heading-title">2. Timeouts:</h3>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group m-form__group">
                                <label for="exampleInputPassword1">Warning inactivty in:</label>
                                <div class="input-group"> 
                                    {!! Form::number('inactivty_warn', $inactivty_warn, ['class'=>"form-control m-input"]) !!}
                                    <div class="input-group-apppend"><span class="input-group-text">Mins</span></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group m-form__group">
                                <label for="exampleInputPassword1">Logout inactivty in:</label>
                                <div class="input-group"> 
                                    {!! Form::number('inactivty_logout', $inactivty_logout, ['class'=>"form-control m-input"]) !!}
                                    <div class="input-group-apppend"><span class="input-group-text">Mins</span></div>
                                </div>
                            </div>
                        </div>

                        
                    </div>
                    <br/><br/>

                    <div class="m-form__seperator m-form__seperator--dashed"></div>
                    <div class="m-form__section m-form__section--last">
                        <div class="m-form__heading">
                            <h3 class="m-form__heading-title">3. Limitations:</h3>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group m-form__group">
                                <label for="exampleInputPassword1">User limit</label>
                                {!! Form::number('user_limit', $user_limit, ['class'=>"form-control"]) !!}
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group m-form__group">
                                <label for="exampleInputPassword1">File limit</label>
                                {!! Form::number('file_limit', $file_limit, ['class'=>"form-control"]) !!}
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group m-form__group">
                                <label for="exampleInputPassword1">Expiry date</label>
                                {!! Form::date('expiry_date', $expiry_date, ['class'=>"form-control"]) !!}
                            </div>
                        </div>
                    </div>
                    <br/><br/>
                    
                    

                    

					
					@csrf
					
					<div class="m-portlet__foot m-portlet__foot--fit">
						<div class="m-form__actions">
							<button type="submit" class="btn btn-primary">Save Details</button>
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
