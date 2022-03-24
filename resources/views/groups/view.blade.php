<dl>
    <dt>Name</dt>
    <dd>{{ $group->name }}</dd>

    <dt>details</dt>
    <dd>{{ $group->details }}</dd>

</dl>

<hr>
<h4>Members</h4>


@if(count($group->users))
<table class="table">
	<thead>
	<th>Name</th>
	<th>StaffID</th>
	</thead>
	<tbody>
		@foreach($group->users as $user)
		<tr>
			<td>{{ $user->full_name }}</td>
			<td>{{ $user->username }}</td>
		</tr>
		@endforeach
	</tbody>
</table>
@else
	<p>No Member attached to this group</p>
@endif