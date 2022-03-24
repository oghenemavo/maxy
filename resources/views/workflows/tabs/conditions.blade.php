@php
	
	if($pre){
		$conditions = $step->preConditions;
		$mode = 'PRE';
	}
	else{
		$conditions = $step->postConditions;
		$mode = 'POST';
	}

@endphp
@forelse( $conditions as $condition )

	<div class="m-list-timeline">
		<div class="m-list-timeline__items">
			<div class="m-list-timeline__item" >
				
				<span class="m-list-timeline__icon flaticon-interface-10" ></span>
				<span class="m-list-timeline__text">Where {{ $condition->userField->name .' '. $condition->operator.' '. str_ireplace("::--::", " and ", $condition->value) }}</span>
				<span class="m-list-timeline__time">
					<a href="{{ route('update-step-condition',[$step->id, $mode, $condition->id]) }}" title="Edit" data-view="{{ route('update-step-condition', [$step->id, $mode, $condition->id]) }}" data-toggle="modal" data-placement="bottom" title="Profile" data-target="#commonModal" class="" href="" id="modalButton" data-type='wide' data-title="Edit notification"  >
						<i class="fa fa-edit"></i>
					</a> | 
					<a href="{{ route('delete-condition',[$condition->id]) }}" onclick="return confirm('Are you sure you want to remove this condition from the step?')" >
						<i class="fa fa-trash m--danger danger text-danger"></i>
					</a>
				</span>
			</div>
			
		</div>
	</div>

@empty

	<em>No {{ ($pre)?"pre-":"post-" }}conditions for this step</em>

@endforelse

<a href="{{ route('update-step-condition', [$step->id, $mode]) }}" title="Edit" data-view="{{ route('update-step-condition', [$step->id, $mode]) }}" data-toggle="modal" data-placement="bottom" title="Profile" data-target="#commonModal" class="" href="" id="modalButton" data-type='wide' data-title="Add a {{ ($pre)?"pre-":"post-" }}condition for this step"  style="float: right;" >
	<button class="btn btn-accent m-btn m-btn--pill m-btn--air m-tabs-line--successs"><i class="fa fa-plus"></i></button>
</a>