@extends('layouts.main')

@section('content')

<div class="m-grid__item m-grid__item--fluid  m-grid m-grid--ver-desktop m-grid--desktop m-page__container m-body">

	<div class="m-grid__item m-grid__item--fluid m-wrapper">

					<!-- BEGIN: Subheader -->
					<div class="m-subheader ">
						<div class="d-flex align-items-center">
							<div class="mr-auto">
								<h3 class="m-subheader__title ">Workflow details</h3>
							</div>
							<div>
								<a href="{{ route('workflows') }}" class="btn btn-accent m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air" href="" id="modalButton" data-type='normal' data-title="Create a new Workflow" style="float: right;" > <i class="la la-plus"></i> back to workflows </a>
							</div>
						</div>
					</div>

					<!-- END: Subheader -->
					<div class="m-content">
						<div class="row">
							<div class="col-xl-3 col-lg-4">
								<div class="m-portlet m-portlet--full-height  ">
									<div class="m-portlet__body">
										<div class="m-card-profile">
											<div class="m-card-profile__title m--hide">
												Your Profile
											</div>
											<div class="m-card-profile__pic">
												<div class="m-card-profile__pic-wrapper">
													<img src="{{ asset('workflow.png') }}" alt="" />
												</div>
											</div>
											<div class="m-card-profile__details">
												<span class="m-card-profile__name">{{ $workflow->name }}</span>
												<a href="" class="m-card-profile__email m-link">{{ $workflow->description }}</a>
											</div>
										</div>
										
										<div class="m-portlet__body-separator"></div>
										<div class="m-widget1 m-widget1--paddingless">
											<div class="m-widget1__item">
												<div class="row m-row--no-padding align-items-center">
													<div class="col">
														<h3 class="m-widget1__title">Workflow states</h3>
														<span class="m-widget1__desc">~</span>
													</div>
													<div class="col m--align-right">
														<span class="m-widget1__number m--font-brand">{{ $workflow->steps_count }}</span>
													</div>
												</div>
											</div>
											<div class="m-widget1__item">
												<div class="row m-row--no-padding align-items-center">
													<div class="col">
														<h3 class="m-widget1__title">Metadata</h3>
														<span class="m-widget1__desc">~</span>
													</div>
													<div class="col m--align-right">
														<span class="m-widget1__number m--font-danger">{{ $workflow->metadata_count }}</span>
													</div>
												</div>
											</div>
											<div class="m-widget1__item">
												<div class="row m-row--no-padding align-items-center">
													<div class="col">
														<h3 class="m-widget1__title">Categories</h3>
														<span class="m-widget1__desc">~</span>
													</div>
													<div class="col m--align-right">
														<span class="m-widget1__number m--font-success">{{ $workflow->folders_count }}</span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-9 col-lg-8">
								<div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
									<div class="m-portlet__head">
										<div class="m-portlet__head-tools">
											<ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
												<li class="nav-item m-tabs__item">
													<a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_user_profile_tab_2" role="tab">
														States
													</a>
												</li>
												<li class="nav-item m-tabs__item">
													<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_user_profile_tab_1" role="tab">
														<i class="flaticon-share m--hide"></i>
														Metadata
													</a>
												</li>
												<li class="nav-item m-tabs__item">
													<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_user_profile_tab_3" role="tab">
														Categories
													</a>
												</li>
											</ul>
										</div>
										<div class="m-portlet__head-tools">
											<ul class="m-portlet__nav">
												<li class="m-portlet__nav-item m-portlet__nav-item--last">
													<div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
														<a href="#" class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
															<i class="la la-gear"></i>
														</a>
														<div class="m-dropdown__wrapper">
															<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
															<div class="m-dropdown__inner">
																<div class="m-dropdown__body">
																	<div class="m-dropdown__content">
																		<ul class="m-nav">
																			<li class="m-nav__item">
																				<a href="{{ route('edit-workflow', $workflow->id) }}" class="m-nav__link">
																					<i class="m-nav__link-icon flaticon-share"></i>
																					<span class="m-nav__link-text">Edit</span>
																				</a>
																			</li>
																			<li class="m-nav__item">
																				<a href="" class="m-nav__link">
																					<i class="m-nav__link-icon flaticon-chat-1"></i>
																					<span class="m-nav__link-text">Delete</span>
																				</a>
																			</li>
																			
																		</ul>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</li>
											</ul>
										</div>
									</div>
									<div class="tab-content">
										<div class="tab-pane" id="m_user_profile_tab_1">
											<div class="m-section__content">


												<!--begin::Preview-->
												<div class="m-demo">
													<div class="m-demo__preview  m--margin-top-15" style="background: #F7F8FC;">
														@forelse( $workflow->metadata as $md)

														<div class="m-list-badge" style="width: 100%">
															<div class="m-list-badge__label m--font-success">{{ title_case($md->name) }}</div>
															<div class="m-list-badge__items">
																<span class="m-list-badge__item">{{ $md->type }}</span>
																
															</div>
														</div>

														@empty

															<em>No Metadata are attached to this workflow.</em>

														@endforelse

														
													</div>
												</div>

												<a href="{{ route('edit-workflow-metadata', $workflow->id) }}" title="Edit" data-view="{{ route('edit-workflow-metadata', $workflow->id) }}" data-toggle="modal" data-placement="bottom" title="Profile" data-target="#commonModal" class="" href="" id="modalButton" data-type='wide' data-title="Edit metadata"  style="float: right;" >
														<button class="btn btn-accent m-btn m-btn--pill m-btn--air m-tabs-line--primary">Edit workflow metadata</button>
													</a>

												<!--end::Preview-->
											</div>
										</div>
										<div class="tab-pane active" id="m_user_profile_tab_2">

											<div class="m-portlet m-portlet--full-height">
												
												<div class="m-portlet__body">

													@include('workflows.tabs.steps', ['workflow'=>$workflow])

												</div>
											</div>

										</div>
										<div class="tab-pane " id="m_user_profile_tab_3">

											<!--begin::Preview-->
												<div class="m-demo">
													<div class="m-demo__preview  m--margin-top-15" style="background: #F7F8FC;">
														@forelse( $workflow->folders as $md)

														<div class="m-list-badge" style="width: 100%">
															<div class="m-list-badge__label m--font-success">{{ title_case($md->name) }}</div>
															
														</div>

														@empty

															<em>No categories are attached to this workflow.</em>

														@endforelse

														
													</div>
												</div>

										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

 </div>
@endsection


@section('scripts')
{{-- <script src="{{ asset('assets/demo/default/custom/components/base/treeview.js') }}" type="text/javascript"></script> --}}


<script type="text/javascript">

   


    @if (session('info'))

        toastr.success("{{ session('info') }}", "Info");

    @endif

    @if (session('error'))

        toastr.error("{{ session('error') }}", "Error");

    @endif

    @if (session('success'))

        toastr.info("{{ session('success') }}", "Success");
        swal({type:"success",title:"{{ session('success') }}",showConfirmButton:!1,timer:1500})

    @endif


</script>
@endsection
