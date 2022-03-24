<!--begin::Section-->
													<div class="m-accordion m-accordion--default" id="m_accordion_1" role="tablist">

														@foreach($workflow->steps as $step)

														<!--begin::Item-->
														<div class="m-accordion__item">
															<div class="m-accordion__item-head" role="tab" id="m_accordion_1_item_1_head" data-toggle="collapse" href="#m_accordion_1_item_1_body-{{ $step->id }}" aria-expanded="false">
																<span class="m-accordion__item-icon"><i class="fa flaticon-layers"></i></span>
																<span class="m-accordion__item-title">{{ $step->name }}</span>
																<span class="m-accordion__item-mode"></span>
															</div>
															<div class="m-accordion__item-body collapse" id="m_accordion_1_item_1_body-{{ $step->id }}" role="tabpanel" aria-labelledby="m_accordion_1_item_1_head" data-parent="#m_accordion_1" style="">
																<div class="m-accordion__item-content">
																	

																	<div class="m-portlet m-portlet--tabs">
																		<div class="m-portlet__head">
																			<div class="m-portlet__head-tools">
																				<ul class="nav nav-tabs m-tabs-line m-tabs-line--danger m-tabs-line--2x m-tabs-line--right" role="tablist">
																					<li class="nav-item m-tabs__item">
																						<a class="nav-link m-tabs__link active" data-toggle="tab" href="#notifs-{{ $step->id }}" role="tab">
																							<i class="fa fa-bell" aria-hidden="true"></i>Notifications
																						</a>
																					</li>
																					<li class="nav-item m-tabs__item">
																						<a class="nav-link m-tabs__link" data-toggle="tab" href="#pre-conditions-{{ $step->id }}" role="tab">
																							<i class="fa fa-tag" aria-hidden="true"></i>Pre-conditions
																						</a>
																					</li>
																					<li class="nav-item m-tabs__item">
																						<a class="nav-link m-tabs__link" data-toggle="tab" href="#post-conditions-{{ $step->id }}" role="tab">
																							<i class="fa fa-tags" aria-hidden="true"></i>Post-conditions
																						</a>
																					</li>
																					<li class="nav-item m-tabs__item">
																						<a class="nav-link m-tabs__link" data-toggle="tab" href="#triggers-{{ $step->id }}" role="tab">
																							<i class="fa fa-bolt" aria-hidden="true"></i>
																							Triggers
																						</a>
																					</li>
                                                                                    <li class="nav-item m-tabs__item">
                                                                                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#combined-triggers-{{ $step->id }}" role="tab">
                                                                                            <i class="fa fa-bolt" aria-hidden="true"></i>
                                                                                            CTriggers
                                                                                        </a>
                                                                                    </li>
																					<li class="nav-item m-tabs__item">
																						<a class="nav-link m-tabs__link" data-toggle="tab" href="#assignees-{{ $step->id }}" role="tab">
																							<i class="fa fa-users" aria-hidden="true"></i>
																							Owners
																						</a>
																					</li>
																					<li class="nav-item m-tabs__item">
																						<a class="nav-link m-tabs__link" data-toggle="tab" href="#metadata-{{ $step->id }}" role="tab">
																							<i class="fa fa-file" aria-hidden="true"></i>
																							Metadata
																						</a>
																					</li>
																					<li class="nav-item m-tabs__item">
																						<a class="nav-link m-tabs__link" data-toggle="tab" href="#settings-{{ $step->id }}" role="tab">
																							<i class="fa fa-cogs" aria-hidden="true"></i>
																							
																						</a>
																					</li>
																				</ul>
																			</div>
																		</div>
																		<div class="m-portlet__body">
																			<div class="tab-content">
																				<div class="tab-pane active" id="notifs-{{ $step->id }}" role="tabpanel">
																					
																					@include('workflows.tabs.notifs', ['step' => $step] )


																				</div>
																				<div class="tab-pane" id="pre-conditions-{{ $step->id }}" role="tabpanel">
																					
																					@include('workflows.tabs.conditions', ['step' => $step, 'pre'=>true] )

																				</div>
																				<div class="tab-pane" id="post-conditions-{{ $step->id }}" role="tabpanel">
																					
																					@include('workflows.tabs.conditions', ['step' => $step, 'pre'=>false] )

																				</div>
																				<div class="tab-pane" id="triggers-{{ $step->id }}" role="tabpanel">
																					
																					@include('workflows.tabs.triggers', ['step' => $step] )

																				</div>
                                                                                <div class="tab-pane" id="combined-triggers-{{ $step->id }}" role="tabpanel">

                                                                                    @include('workflows.tabs.combined-triggers', ['step' => $step] )

                                                                                </div>
																				<div class="tab-pane" id="assignees-{{ $step->id }}" role="tabpanel">
																					
																					@include('workflows.tabs.assignees', ['step' => $step] )

																				</div>
																				<div class="tab-pane" id="metadata-{{ $step->id }}" role="tabpanel">
																					
																					@include('workflows.tabs.metadata', ['step' => $step] )

																				</div>
																				<div class="tab-pane" id="settings-{{ $step->id }}" role="tabpanel">
																					
																					<a href="{{ route('update-workflow-step', [$workflow->id, $step->id]) }}" title="Edit" data-view="{{ route('update-workflow-step', [$workflow->id, $step->id]) }}" data-toggle="modal" data-placement="bottom" title="Profile" data-target="#commonModal" class="" href="" id="modalButton" data-type='wide' data-title="Edit step"   >
																						<button class="btn btn-primary m-btn m-btn--pill m-btn--air m-tabs-line--default">Edit this state</button>
																					</a>

																					<a href="{{ route('delete-step', $step->id) }}" title="Delete" onclick="return confirm('Are you sure you want to delete this step?');"  >
																						<button class="btn btn-danger m-btn m-btn--pill m-btn--air m-tabs-line--danger">Delete this state</button>
																					</a>

																				</div>
																			</div>
																		</div>
																	</div>


																</div>
															</div>
														</div>

														<!--end::Item-->

														@endforeach


														

														
													</div>

													<a href="{{ route('update-workflow-step', $workflow->id) }}" title="Edit" data-view="{{ route('update-workflow-step', $workflow->id) }}" data-toggle="modal" data-placement="bottom" title="Profile" data-target="#commonModal" class="" href="" id="modalButton" data-type='wide' data-title="Create new step"  style="float: right;" >
															<button class="btn btn-accent m-btn m-btn--pill m-btn--air m-tabs-line--successs">Add a new State</button>
														</a>

													<!--end::Section-->
