<dl>
    <dt>User</dt>
    <dd>{{ $audit->user->full_name }}</dd>

    <dt>Details</dt>
    <dd>{{ $audit->description }}</dd>

     <dt>Type</dt>
    <dd>{{ str_ireplace("App\Models\\", "", $audit->actionable_type) }}</dd>

    <dt>Date</dt>
    <dd>{{ $audit->created_at->toDayDateTimeString() }}</dd>

</dl>


