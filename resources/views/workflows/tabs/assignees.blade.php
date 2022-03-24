@forelse( $step->assignees as $ass )

	<div class="m-list-timeline">
		<div class="m-list-timeline__items">
			<div class="m-list-timeline__item" >
				<span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
				<span class="m-list-timeline__icon flaticon-user" ></span>
				<span class="m-list-timeline__text">{{ ($ass->recipient_type == 'USER') ? getUserName($ass->recipient_id) .' | '. $ass->template : (($ass->recipient_type == 'GROUP') ? getGroupName($ass->recipient_id)  .' | '. $ass->template : 'Initiator'.' | '. $ass->template )}}</span>
				<span class="m-list-timeline__time">
					<a href="{{ route('update-step-assignee',[$step->id, $ass->id]) }}" title="Edit" data-view="{{ route('update-step-assignee', [$step->id, $ass->id]) }}" data-toggle="modal" data-placement="bottom" title="Profile" data-target="#commonModal" class="" href="" id="modalButton" data-type='wide' data-title="Edit notification"  >
						<i class="fa fa-edit"></i>
					</a> | 
					<a href="{{ route('delete-assignee',[$ass->id]) }}" onclick="return confirm('Are you sure you want to remove the user from the step?')" >
						<i class="fa fa-trash m--danger danger text-danger"></i>
					</a>
				</span>
			</div>
			
		</div>
	</div>

								@empty

									<em>No user is assigned for this step</em>

								@endforelse

								<a href="{{ route('update-step-assignee', $step->id) }}" title="Edit" data-view="{{ route('update-step-assignee', $step->id) }}" data-toggle="modal" data-placement="bottom" title="Profile" data-target="#commonModal" class="" href="" id="modalButton" data-type='wide' data-title="Add a user to this step"  style="float: right;" >
									<button class="btn btn-primary m-btn m-btn--pill m-btn--air m-tabs-line--successs"><i class="fa fa-plus"></i></button>
								</a>