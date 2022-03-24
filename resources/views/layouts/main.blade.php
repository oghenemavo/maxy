@php
	use Carbon\Carbon;

	$settings = settings();





@endphp

<!DOCTYPE html>

<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 4
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en">

	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title>Document Management System | Dashboard</title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

		<!--begin::Web font -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>
			WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700","Asap+Condensed:500"]},
            active: function() {
                sessionStorage.fonts = true;
            }
          });
        </script>

		<!--end::Web font -->

		<!--begin::Global Theme Styles -->
		<link href="{{ asset('assets/vendors/base/vendors.bundle.css') }}" rel="stylesheet" type="text/css" />

		<!--RTL version:<link href="assets/vendors/base/vendors.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
		<link href="{{ asset('assets/demo/demo8/base/style.bundle.css') }}" rel="stylesheet" type="text/css" />

		<!--RTL version:<link href="assets/demo/demo8/base/style.bundle.rtl.css" rel="stylesheet" type="text/css" />-->

		<!--end::Global Theme Styles -->

		<!--begin::Page Vendors Styles -->
		<link href="{{ asset('assets/vendors/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />

		<link href="{{ asset('assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
		<!--RTL version:<link href="assets/vendors/custom/fullcalendar/fullcalendar.bundle.rtl.css" rel="stylesheet" type="text/css" />-->

		<!--end::Page Vendors Styles -->
		<link rel="shortcut icon" href="{{ asset('assets/demo8/demo/media/img/logo/favicon.ico') }}" />
		<link rel="shortcut icon" href="https://cdn.datatables.net/buttons/1.5.4/css/buttons.dataTables.min.css" />


		


		@yield('styles')
		<style>
			.table.dataTable tbody tr.selected a, table.dataTable tbody th.selected a, table.dataTable tbody td.selected a{
				color:black !important;
			}
			select[readonly].select2 + .select2-container {
				pointer-events: none;
				touch-action: none;
				}
		</style>

		<!--begin::Global Theme Bundle -->
		<script src="{{ asset('assets/vendors/base/vendors.bundle.js') }}" type="text/javascript"></script>
		<script src="{{ asset('assets/demo/demo8/base/scripts.bundle.js') }}" type="text/javascript"></script>

		<!--end::Global Theme Bundle -->

	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body style="background-image: url({{ asset('assets/app/media/img/bg/bg-12.jpg') }})" class="m-page--fluid m-page--loading-enabled m-page--loading m-header--fixed m-header--fixed-mobile m-footer--push m-aside--offcanvas-default"> 
	<!--  <body style="background: rgb(241,167,85);background: linear-gradient(90deg, rgba(241,167,85,1) 0%, rgba(236,154,75,1) 48%, rgba(223,132,38,1) 100%);" class="m-page--fluid m-page--loading-enabled m-page--loading m-header--fixed m-header--fixed-mobile m-footer--push m-aside--offcanvas-default gradient-bg"> -->
	{{-- <body style="background: rgb(180,115,58);background: linear-gradient(90deg, rgba(180,115,58,1) 0%, rgba(219,81,38,1) 44%, rgba(252,176,69,1) 100%);" class="m-page--fluid m-page--loading-enabled m-page--loading m-header--fixed m-header--fixed-mobile m-footer--push m-aside--offcanvas-default gradient-bg"> --}}

		<!-- begin::Page loader -->
		<div class="m-page-loader m-page-loader--base">
			<div class="m-blockui">
				<span>Please wait...</span>
				<span>
					<div class="m-loader m-loader--brand"></div>
				</span>
			</div>
		</div>

		<!-- end::Page Loader -->

		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">

			<!-- begin::Header -->
			<header id="m_header" class="m-grid__item m-header " m-minimize="minimize" m-minimize-mobile="minimize" m-minimize-offset="10" m-minimize-mobile-offset="10">
				<div class="m-header__top">
					<div class="m-container m-container--fluid m-container--full-height m-page__container" style=" padding: 0 20px;">
						<div class="m-stack m-stack--ver m-stack--desktop">

							<!-- begin::Brand -->
							<div class="m-stack__item m-brand m-stack__item--left">
								<div class="m-stack m-stack--ver m-stack--general m-stack--inline">
									<div class="m-stack__item m-stack__item--middle m-brand__logo">
										<a class="m-brand__logo-wrapper">
											<img  src="{{ asset('img/maxfiles-sm2.jpg') }}" alt="Logo">
										</a>
									</div>
									<div class="m-stack__item m-stack__item--middle m-brand__tools">
										<!-- begin::Responsive Header Menu Toggler-->
										<a id="m_aside_header_menu_mobile_toggle"  class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
											<span></span>
										</a>

										<!-- end::Responsive Header Menu Toggler-->

										<!-- begin::Topbar Toggler-->
										<a id="m_aside_header_topbar_mobile_toggle"  class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
											<i class="flaticon-more"></i>
										</a>

										<!--end::Topbar Toggler-->
									</div>
								</div>
							</div>

							<!-- end::Brand -->

							<!--begin::Search-->
							<div class="m-stack__item m-stack__item--middle m-dropdown m-dropdown--arrow m-dropdown--large m-dropdown--mobile-full-width m-dropdown--align-right m-dropdown--skin-light m-header-search m-header-search--expandable- m-header-search--skin-"
							 id="mm_quicksearch" m-quicksearch-mode="default">

								<!--begin::Search Form -->
								<form class="m-header-search__form">
									<div class="m-header-search__wrapper" style="background-color:white">
										<span class="m-header-search__icon-search" id="m_quicksearch_search">
											<i class="la la-search"></i>
										</span>
										<span class="m-header-search__input-wrapper">
											<input autocomplete="off" type="text" name="q" class="m-header-search__input" value="" placeholder="Search..." id="m_quicksearch_input">
										</span>
										<span class="m-header-search__icon-close" id="m_quicksearch_close">
											<i class="la la-remove"></i>
										</span>
										<span class="m-header-search__icon-cancel" id="m_quicksearch_cancel">
											<i class="la la-remove"></i>
										</span>
									</div>
								</form>

								<!--end::Search Form -->

								<!--begin::Search Results -->
								<div class="m-dropdown__wrapper">
									<div class="m-dropdown__arrow m-dropdown__arrow--center"></div>
									<div class="m-dropdown__inner">
										<div class="m-dropdown__body">
											<div class="m-dropdown__scrollable m-scrollable" data-scrollable="true" data-height="300" data-mobile-height="200">
												<div class="m-dropdown__content m-list-search m-list-search--skin-light">
												</div>
											</div>
										</div>
									</div>
								</div>

								<!--end::Search Results -->
							</div>

							<!--end::Search-->

							<!-- begin::Topbar -->
							<div class="m-stack__item m-stack__item--right m-header-head" id="m_header_nav">
								<div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
									<div class="m-stack__item m-topbar__nav-wrapper">
									<img alt="" src="{{ asset( 'storage/'.$settings['logo'] ) }}" class="m-brand__logo-default" height="70px" />
											<!-- <img alt="" src="{{ asset( 'storage/'.$settings['logo'] ) }}" height="75px" class="m-brand__logo-inverse" /> -->
										<ul class="m-topbar__nav m-nav m-nav--inline">


											<li class="m-nav__item m-topbar__user-profile  m-dropdown m-dropdown--medium m-dropdown--arrow  m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" m-dropdown-toggle="click">
												<a href="#" class="m-nav__link m-dropdown__toggle">
													<span class="m-topbar__userpic">
														<img src="{{ asset('avatar.png') }}" class="m--img-rounded m--marginless m--img-centered" alt="" />
													</span>
													<span class="m-nav__link-icon m-topbar__usericon  m--hide">
														<span class="m-nav__link-icon-wrapper"><i class="flaticon-user-ok"></i></span>
													</span>
													<span class="m-topbar__username m--hide">Nick</span>
												</a>
												<div class="m-dropdown__wrapper">
													<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
													<div class="m-dropdown__inner">
														<div class="m-dropdown__header m--align-center">
															<div class="m-card-user m-card-user--skin-light">
																{{-- <div class="m-card-user__pic">
																	<img src="{{ asset('img/avatar.png') }}" class="m--img-rounded m--marginless" alt="" />
																</div> --}}
																<div class="m-card-user__details">
																	<span class="m-card-user__name m--font-weight-500">{{ Auth::user()->first_name.' '.Auth::user()->last_name }}</span>
																	<a  class="m-card-user__email m--font-weight-300 m-link">{{ Auth::user()->email }}</a>
																</div>
															</div>
														</div>
														<div class="m-dropdown__body">
															<div class="m-dropdown__content">
																<ul class="m-nav m-nav--skin-light">
																	<li class="m-nav__section m--hide">
																		<span class="m-nav__section-text">Section</span>
																	</li>

																	<li class="m-nav__item">
																		<a data-view="{{ route('change-password') }}" data-toggle="modal" data-placement="bottom" title="Change password" data-target="#commonModal" href="" id="modalButton" data-type='wide' data-title="Change password"  class="m-nav__link">
																			<i class="m-nav__link-icon fa fa-key"></i>
																			<span class="m-nav__link-text">Change password</span>
																		</a>
																	</li>
																	<li class="m-nav__item">
																		<a href="{{ route('logout') }}"  onclick="event.preventDefault();
												                            document.getElementById('logout-form').submit();" class="m-nav__link">
																			<i class="m-nav__link-icon fa fa-sign-out-alt"></i>
																			<span class="m-nav__link-text">Logout</span>
																		</a>
																		 <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
													                            {{ csrf_field() }}
													                        </form>
																	</li>

																</ul>
															</div>
														</div>
													</div>
												</div>
											</li>
											<li id="m_quick_sidebar_toggle" class="m-nav__item">
												<a href="#" class="m-nav__link m-dropdown__toggle" id="m_topbar_notification_icon">
													<span class="m-nav__link-badge m-badge m-badge--dot m-badge--dot-small m-badge--danger"></span>
													<span class="m-nav__link-icon m-nav__link-icon-alt"><span class="m-nav__link-icon-wrapper"><i class="flaticon-alarm"></i></span></span>
												</a>
												{{-- <a href="#" class="m-nav__link m-dropdown__toggle">
													<span class="m-nav__link-icon m-nav__link-icon-alt"><span class="m-nav__link-icon-wrapper"><i class="flaticon-grid-menu"></i></span></span>
												</a> --}}
											</li>
										</ul>
									</div>
								</div>
							</div>

							<!-- end::Topbar -->
						</div>
					</div>
				</div>


				<div class="m-header__bottom" style="">

				@php

					$expDate = Carbon::parse($settings['expiry_date']);
					$today = Carbon::now();

				@endphp

				@if($expDate->lessThan($today))

					@php

						echo redirect()->route('logout', ['message'=>'Your access and subscription to MaxFiles has expired. Please contact DataMax Admin for renewal.']);

					@endphp


				@elseif( $expDate->diffInDays($today) < 20 )



						<div class="m-alert m-alert--icon alert alert-warning" role="alert">
							<div class="m-alert__icon">
								<i class="la la-warning"></i>
							</div>
							<div class="m-alert__text">
								<strong>
									Your access and subscription to MaxFiles will expire in {{ $expDate->diffInDays($today) }} days. Please contact Datamax Admin for renewal.
								</strong>
							</div>
							<div class="m-alert__close">
								<button type="button" class="close" data-close="alert" aria-label="Hide">
								</button>
							</div>
						</div>


		        @endif


					<div class="m-container m-container--fluid m-container--full-height m-page__container">
						<div class="m-stack m-stack--ver m-stack--desktop">

							<!-- begin::Horizontal Menu -->
							<div class="m-stack__item m-stack__item--fluid m-header-menu-wrapper">
								<button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-light " id="m_aside_header_menu_mobile_close_btn"><i class="la la-close"></i></button>

								@include('layouts.menu')

							</div>

							<!-- end::Horizontal Menu -->
						</div>
					</div>
				</div>
			</header>

			<!-- end::Header -->

			<!-- begin::Body -->
				@yield('content')
			

			<!-- end::Body -->

			<!-- begin::Footer -->
			<footer class="m-grid__item m-footer">
				<div class="m-container m-container--fluid m-container--full-height m-page__container">
					<div class="m-footer__wrapper">
						<div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
							<div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last">
								<span class="m-footer__copyright">
									<div class="pull-left" style="padding-top:20px">
										<p style="font-size:1.5em"><span class="text-light">&copy; {{ date('Y') }} &dash; MaxFiles | a Document Management System by</span> <a href="http://datamaxfiles.com/" class="m-link">DataMax Files</a></p>
</div>
									<div class="pull-right">
										<img  src="{{ asset('img/maxfiles-sm.png') }}" alt="Logo" class="m-brand__logo-default" height="70px">
									</div>
								</span>
							</div>
							<div class="m-stack__item m-stack__item--right m-stack__item--middle m-stack__item--first m--hide">
								<ul class="m-footer__nav m-nav m-nav--inline m--pull-right">
									<li class="m-nav__item">
										<a href="#" class="m-nav__link">
											<span class="m-nav__link-text">About</span>
										</a>
									</li>
									<li class="m-nav__item">
										<a href="#" class="m-nav__link">
											<span class="m-nav__link-text">Privacy</span>
										</a>
									</li>
									<li class="m-nav__item">
										<a href="#" class="m-nav__link">
											<span class="m-nav__link-text">T&C</span>
										</a>
									</li>
									<li class="m-nav__item">
										<a href="#" class="m-nav__link" data-toggle="m-tooltip" title="Support Center" data-placement="left">
											<i class="m-nav__link-icon flaticon-info m--icon-font-size-lg3"></i>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</footer>

			<!-- end::Footer -->
		</div>

		<!-- end:: Page -->

		<!-- begin::Quick Sidebar -->
		<div id="m_quick_sidebar" class="m-quick-sidebar m-quick-sidebar--tabbed m-quick-sidebar--skin-light">
			<div class="m-quick-sidebar__content m--hide">
				<span id="m_quick_sidebar_close" class="m-quick-sidebar__close"><i class="la la-close"></i></span>
				<ul id="m_quick_sidebar_tabs" class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--brand" role="tablist">

					<li class="nav-item m-tabs__item">
						<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_quick_sidebar_tabs_logs" role="tab">Notifications</a>
					</li>
				</ul>
				<div class="tab-content">

					<div class="tab-pane active" id="m_quick_sidebar_tabs_logs" role="tabpanel">
						<div class="m-list-timeline m-scrollable">
							<div class="m-list-timeline__group">
								{{-- <div class="m-list-timeline__heading">
									System Logs
								</div> --}}
								<div class="m-list-timeline__items">
									<a class="btn btn-danger" role="button" href="{{ route('clear-notification') }}" />Clear</a>
									@foreach(Auth::user()->notifications as $notif)

										@php
									        $type = 'file';

									    @endphp
									    @switch($notif->type)
									        @case('App\Notifications\FileUpdate')

									            @php
									                $type = 'File Update'
									            @endphp

									            @break
									        @default
									            @php
									                $type = 'Default'
									            @endphp
									    @endswitch
									<div class="m-list-timeline__item">
										<span class="m-list-timeline__badge m-list-timeline__badge--state-success"></span>
										<a href="{{ $notif->data['url'] }}" class="m-list-timeline__text">{{ @$notif->data['message'] }}
											<span class="m-badge m-badge--warning m-badge--wide">{{ $type }}</span></a>
										<span class="m-list-timeline__time">{{ $notif->created_at->diffForHumans() }}</span>
									</div>
									@endforeach
									
									{{-- <div class="m-list-timeline__item">
										<span class="m-list-timeline__badge m-list-timeline__badge--state-info"></span>
										<a href="" class="m-list-timeline__text">System shutdown</a>
										<span class="m-list-timeline__time">11 mins</span>
									</div>
									<div class="m-list-timeline__item">
										<span class="m-list-timeline__badge m-list-timeline__badge--state-danger"></span>
										<a href="" class="m-list-timeline__text">New invoice received</a>
										<span class="m-list-timeline__time">20 mins</span>
									</div>
									<div class="m-list-timeline__item">
										<span class="m-list-timeline__badge m-list-timeline__badge--state-warning"></span>
										<a href="" class="m-list-timeline__text">Database overloaded 89% <span class="m-badge m-badge--success m-badge--wide">resolved</span></a>
										<span class="m-list-timeline__time">1 hr</span>
									</div>
									<div class="m-list-timeline__item">
										<span class="m-list-timeline__badge m-list-timeline__badge--state-success"></span>
										<a href="" class="m-list-timeline__text">System error</a>
										<span class="m-list-timeline__time">2 hrs</span>
									</div>
									<div class="m-list-timeline__item">
										<span class="m-list-timeline__badge m-list-timeline__badge--state-info"></span>
										<a href="" class="m-list-timeline__text">Production server down <span class="m-badge m-badge--danger m-badge--wide">pending</span></a>
										<span class="m-list-timeline__time">3 hrs</span>
									</div>
									<div class="m-list-timeline__item">
										<span class="m-list-timeline__badge m-list-timeline__badge--state-success"></span>
										<a href="" class="m-list-timeline__text">Production server up</a>
										<span class="m-list-timeline__time">5 hrs</span>
									</div> --}}
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>



<!--begin::Modal-->
<div class="modal fade" id="commonModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg"  style="max-width: 1000px;" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>
<!--end::Modal-->



<!--begin::Modal-->
    <div class="modal fade" id="sel_cat_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">




            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Choose category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                        <div id="m_tree_6" class="tree-demo">
                        </div>


                    </form>
                </div>

            </div>


        </div>
    </div>





		<!-- end::Quick Sidebar -->

		<!-- begin::Scroll Top -->
		<div id="m_scroll_top" class="m-scroll-top">
			<i class="la la-arrow-up"></i>
		</div>

		<!-- end::Scroll Top -->




		{{-- @include('files.file-upload') --}}




		<!-- begin::Quick Nav -->
		{{-- <ul class="m-nav-sticky" style="margin-top: 30px;">
			<li class="m-nav-sticky__item" data-toggle="m-tooltip" title="Purchase" data-placement="left">
				<a href="https://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes" target="_blank"><i class="la la-cart-arrow-down"></i></a>
			</li>
			<li class="m-nav-sticky__item" data-toggle="m-tooltip" title="Documentation" data-placement="left">
				<a href="https://keenthemes.com/metronic/documentation.html" target="_blank"><i class="la la-code-fork"></i></a>
			</li>
			<li class="m-nav-sticky__item" data-toggle="m-tooltip" title="Support" data-placement="left">
				<a href="https://keenthemes.com/forums/forum/support/metronic5/" target="_blank"><i class="la la-life-ring"></i></a>
			</li>
		</ul> --}}

		<!-- begin::Quick Nav -->



		<!--begin::Page Vendors -->
		<script src="{{ asset('assets/vendors/custom/fullcalendar/fullcalendar.bundle.js') }}" type="text/javascript"></script>


		<script src="{{ asset('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
		<script src="{{ asset('assets/select2/js/select2.full.min.js') }}" type="text/javascript"></script>

		<!--end::Page Vendors -->

		<!--begin::Page Scripts -->
		{{-- <script src="{{ asset('assets/demo/default/custom/crud/metronic-datatable/base/data-local.js') }}" type="text/javascript"></script> --}}

		<!--end::Page Vendors -->
        <script src="{{ asset('assets/bsselect.js', 1) }}"></script>

		<!--begin::Page Scripts -->
		<script src="{{ asset('assets/app/js/dashboard.js') }}" type="text/javascript"></script>
		<script src="{{ asset('assets/app/js/my-script.js') }}" type="text/javascript"></script>
		<script src="{{ asset('assets/bootstrap-session-timeout.min.js') }}" type="text/javascript"></script>

		<script src="{{ asset('js/jquery.form.js') }}"></script>
		<script src="{{ asset('js/jquery.bootstrap-growl.min.js') }}"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.contextMenu.min.js"></script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.ui.position.js"></script>

	    <script src="{{ asset('assets/demo/default/custom/crud/datatables/extensions/select.js') }}" type="text/javascript"></script>
	    <script src="{{ asset('assets/demo/default/custom/crud/datatables/extensions/buttons.js') }}" type="text/javascript"></script>
	    <script src="https://cdn.datatables.net/buttons/1.5.4/js/dataTables.buttons.min.js" type="text/javascript"></script>
	    <script src="https://cdn.datatables.net/buttons/1.5.4/js/buttons.colVis.min.js" type="text/javascript"></script>


	    <script src="https://rawgit.com/enyo/dropzone/master/dist/dropzone.js"></script>

	    <script src="{{ asset('assets/demo/default/custom/crud/forms/widgets/bootstrap-daterangepicker.js') }}" type="text/javascript"></script>


		{{-- <script src="{{ asset('assets/demo/default/custom/crud/forms/widgets/select2.js') }}" type="text/javascript"></script> --}}

		<!--end::Page Scripts -->

		@yield('scripts')

		<!-- begin::Page Loader -->
		<script>
			$(window).on('load', function() {
				$('body').removeClass('m-page--loading');
				$(".m-select2").select2({placeholder:"Select a state"});


				toastr.options = {
				  "closeButton": false,
				  "debug": false,
				  "newestOnTop": false,
				  "progressBar": false,
				  "positionClass": "toast-top-right",
				  "preventDuplicates": false,
				  "onclick": null,
				  "showDuration": "300",
				  "hideDuration": "2000",
				  "timeOut": "5000",
				  "extendedTimeOut": "1000",
				  "showEasing": "swing",
				  "hideEasing": "linear",
				  "showMethod": "fadeIn",
				  "hideMethod": "fadeOut"
				};


				@if(!env('APP_DEBUG'))
					$.contextMenu({
				        selector: 'body',
				        items: {
				            refresh: {
				                name: "Refresh DMS",
				                callback: function(key, opt){
				                    location.reload();
				                }
				            },

				        }
				    });
				@endif



				if ($('#mm_quicksearch').length === 0 ) {
		            return;
		        }

		        quicksearch = new mQuicksearch('mm_quicksearch', {
		            mode: mUtil.attr( 'm_quicksearch', 'm-quicksearch-mode' ), // quick search type
		            minLength: 1
		        });

		        //<div class="m-search-results m-search-results--skin-light"><span class="m-search-result__message">Something went wrong</div></div>

		        quicksearch.on('search', function(the) {
		            the.showProgress();

					setTimeout(
						$.ajax({
		                url: '{{ route('file-quick-search') }}',
		                data: {q: the.query},
		                dataType: 'html',
		                success: function(res) {
		                    the.hideProgress();
		                    the.showResult(res);
		                },
		                error: function(res) {
		                    the.hideProgress();
		                    the.showError('Connection error. Pleae try again later.');
		                }
		            }), 5000
					)
		        });

			});

			    $('.select2').select2();
		</script>

		 <script>
		 	{{-- @if(env('APP_ENV') != 'local') --}}
		    $.sessionTimeout({
		        keepAliveUrl: '{{ route("user-check") }}',
		        logoutUrl: '{{ route("logout") }}',
		        redirUrl: '{{ route("logout") }}',
		        warnAfter: {{ $settings['inactivty_warn'] * 360 * 100 }},
        		redirAfter: {{ $settings['inactivty_logout'] * 360 * 100 }}
		    });
		    {{--  @endif --}}


		    function checkSessionValidity(){

		    	$.ajax({
		                url: '{{ route('session-check') }}',
		                data: {q: 'sfd'},
		                dataType: 'html',
		                success: function(res) {
		                    // console.log(res);
		                    if(!res)
		                    	document.location = '{{ route("logout") }}';


		                    setTimeout( function(){ checkSessionValidity(); }, 5000 );
		                },
		                error: function(res) {

		                    setTimeout( function(){ checkSessionValidity(); }, 5000 );
		                }
		            });

		    }

		    setTimeout( function(){ checkSessionValidity(); }, 5000 );



	var mQuickSidebar = function() {
    var topbarAside = $('#m_quick_sidebar');
    var topbarAsideTabs = $('#m_quick_sidebar_tabs');
    var topbarAsideContent = topbarAside.find('.m-quick-sidebar__content');

    var initMessages = function() {
        var messages = mUtil.find( mUtil.get('m_quick_sidebar_tabs_messenger'),  '.m-messenger__messages');
        var form = $('#m_quick_sidebar_tabs_messenger .m-messenger__form');

        mUtil.scrollerInit(messages, {
            disableForMobile: true,
            resetHeightOnDestroy: false,
            handleWindowResize: true,
            height: function() {
                var height = topbarAside.outerHeight(true) -
                    topbarAsideTabs.outerHeight(true) -
                    form.outerHeight(true) - 120;

                return height;
            }
        });
    }

    var initSettings = function() {
        var settings = mUtil.find( mUtil.get('m_quick_sidebar_tabs_settings'),  '.m-list-settings');

        if (!settings) {
            return;
        }

        mUtil.scrollerInit(settings, {
            disableForMobile: true,
            resetHeightOnDestroy: false,
            handleWindowResize: true,
            height: function() {
                return mUtil.getViewPort().height - topbarAsideTabs.outerHeight(true) - 60;
            }
        });
    }

    var initLogs = function() {
        var logs = mUtil.find( mUtil.get('m_quick_sidebar_tabs_logs'),  '.m-list-timeline');

        if (!logs) {
            return;
        }

        mUtil.scrollerInit(logs, {
            disableForMobile: true,
            resetHeightOnDestroy: false,
            handleWindowResize: true,
            height: function() {
                return mUtil.getViewPort().height - topbarAsideTabs.outerHeight(true) - 60;
            }
        });
    }

    var initOffcanvasTabs = function() {
        initMessages();
        initSettings();
        initLogs();
    }

    var initOffcanvas = function() {
        var topbarAsideObj = new mOffcanvas('m_quick_sidebar', {
            overlay: true,
            baseClass: 'm-quick-sidebar',
            closeBy: 'm_quick_sidebar_close',
            toggleBy: 'm_quick_sidebar_toggle'
        });

        // run once on first time dropdown shown
        topbarAsideObj.one('afterShow', function() {
            mApp.block(topbarAside);

            setTimeout(function() {
                mApp.unblock(topbarAside);

                topbarAsideContent.removeClass('m--hide');

                initOffcanvasTabs();
            }, 1000);
        });
    }

    return {
        init: function() {
            if (topbarAside.length === 0) {
                return;
            }

            initOffcanvas();
        }
    };
}();

$(document).ready(function() {
    mQuickSidebar.init();
});


		 </script>

		<!-- end::Page Loader -->
    
	</body>

	<!-- end::Body -->
</html>
