
@forelse( $step->combinedTriggers as $index => $trigger )
    <div class="m-list-timeline">
        <div class="m-list-timeline__items">
            <div class="m-list-timeline__item" >

                <span class="m-list-timeline__icon flaticon-interface-10" ></span>
                <span class="m-list-timeline__text">
                    If [<strong>{{ $trigger->userField->name .' '. $trigger->operator.' '. $trigger->value }}</strong>]
                    @if($index == count($step->combinedTriggers)-1 && $trigger->newStep )
                        then move to: [ <strong>{{ $trigger->newStep->name }}</strong>]
                    @endif
                </span>
                <span class="m-list-timeline__time">
					<a href="{{ route('update-step-combined-trigger',[$step->id, $trigger->id]) }}"
                       title="Edit" data-view="{{ route('update-step-combined-trigger', [$step->id, $trigger->id]) }}"
                       data-toggle="modal" data-placement="bottom" title="Profile" data-target="#commonModal" class=""
                       id="modalButton" data-type='wide' data-title="Edit notification"  >
						<i class="fa fa-edit"></i>
					</a> |
					<a href="{{ route('delete-combined-trigger',[$trigger->id]) }}"
                       onclick="return confirm('Are you sure you want to remove this combined trigger from the step?')" >
						<i class="fa fa-trash m--danger danger text-danger"></i>
					</a>
				</span>
            </div>

        </div>
    </div>

@empty


@endforelse

<em>If Post conditions have been met, Then move to next step on rank.</em>

<a href="{{ route('combined-trigger-action', [$step->id]) }}" title="Move to"
   data-view="{{ route('combined-trigger-action', [$step->id]) }}"
   data-toggle="modal" data-placement="bottom" data-target="#commonModal" class=""
   id="modalButton" data-type='wide' data-title="Add a combined trigger for this step"  style="float: right;" >
    <button class="btn btn-accent m-btn m-btn--pill m-btn--air m-tabs-line--successs"><i class="fa fa-pen-fancy"></i></button>
</a>

<a href="{{ route('update-step-combined-trigger', [$step->id]) }}" title="Edit"
   data-view="{{ route('update-step-combined-trigger', [$step->id]) }}"
   data-toggle="modal" data-placement="bottom" data-target="#commonModal" class=""
   id="modalButton" data-type='wide' data-title="Add a combined trigger for this step"  style="float: right;" >
    <button class="btn btn-accent m-btn m-btn--pill m-btn--air m-tabs-line--successs"><i class="fa fa-plus"></i></button>
</a>
