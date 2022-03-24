@forelse( $step->notifications as $notif )

														<div class="m-list-timeline">
															<div class="m-list-timeline__items">
																<div class="m-list-timeline__item" >
																	<span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
																	<span class="m-list-timeline__icon flaticon-user" ></span>
																	<span class="m-list-timeline__text">{{ ($notif->recipient_type == 'USER') ? getUserName($notif->recipient_id) .' | '. $notif->template : (($notif->recipient_type == 'GROUP') ? getGroupName($notif->recipient_id)  .' | '. $notif->template : 'Initiator'.' | '. $notif->template )}}</span>
																	<span class="m-list-timeline__time">
																		<a href="{{ route('update-step-notification',[$step->id, $notif->id]) }}" title="Edit" data-view="{{ route('update-step-notification', [$step->id, $notif->id]) }}" data-toggle="modal" data-placement="bottom" title="Profile" data-target="#commonModal" class="" href="" id="modalButton" data-type='wide' data-title="Edit notification"  >
																			<i class="fa fa-edit"></i>
																		</a> | 
																		<a href="{{ route('delete-notif',[$notif->id]) }}" onclick="return confirm('Are you sure you want to remove this notification from the step?')" >
																			<i class="fa fa-trash m--danger danger text-danger"></i>
																		</a>
																	</span>
																</div>
																
															</div>
														</div>

																					@empty

																						<em>No notification for this step</em>

																					@endforelse

																					<a href="{{ route('update-step-notification', $step->id) }}" title="Edit" data-view="{{ route('update-step-notification', $step->id) }}" data-toggle="modal" data-placement="bottom" title="Profile" data-target="#commonModal" class="" href="" id="modalButton" data-type='wide' data-title="Create new notification"  style="float: right;" >
																						<button class="btn btn-accent m-btn m-btn--pill m-btn--air m-tabs-line--successs"><i class="fa fa-plus"></i></button>
																					</a>