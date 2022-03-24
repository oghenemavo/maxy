
		@forelse( $step->metadata as $md)

		<div class="m-list-badge" style="width: 100%">
			<div class="m-list-badge__label m--font-success">{{ title_case($md->name) }}</div>
			<div class="m-list-badge__items">
				<span class="m-list-badge__item">{{ $md->type }}</span>
				
			</div>
		</div>

		@empty

			<em>No Metadata are attached to this workflow.</em>

		@endforelse



<a href="{{ route('update-step-metadata', $step->id) }}" title="Edit" data-view="{{ route('update-step-metadata', $step->id) }}" data-toggle="modal" data-placement="bottom" title="Profile" data-target="#commonModal" class="" href="" id="modalButton" data-type='wide' data-title="Assignee metadata to a User or Group"  style="float: right;" >
    <button class="btn btn-accent m-btn m-btn--pill m-btn--air m-tabs-line--successs"><i class="fa fa-plus"></i></button>
</a>