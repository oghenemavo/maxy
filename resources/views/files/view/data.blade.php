@foreach($permissions as $perm)
<tr>
	<td> {{ $perm['name'] }} </td>

	@if(@$isFolder)
        <td> <input class="fluency" data-type="{{ $perm['type'] }}" data-id="{{ $perm['id'] }}" data-property="can_read" data-checked="{{ $perm['can_read'] }}"  type="checkbox" name="can_read" @if($perm['can_read']) checked="" @endif  onclick="doCheckBox(this)"> </td>

        <td> <input class="fluency" data-type="{{ $perm['type'] }}" data-id="{{ $perm['id'] }}" data-property="can_write" data-checked="{{ $perm['can_write'] }}" type="checkbox" name="can_write" @if($perm['can_write']) checked="" @endif onclick="doCheckBox(this)" > </td>
	@else

		<td> <input class="fluency" data-type="{{ $perm['type'] }}" data-id="{{ $perm['id'] }}" data-property="can_read" data-checked="{{ $perm['can_read'] }}"  type="checkbox" name="can_read" @if($perm['can_read']) checked="" @endif  onclick="doCheckBox(this)"> </td>

		<td> <input class="fluency" data-type="{{ $perm['type'] }}" data-id="{{ $perm['id'] }}" data-property="can_write" data-checked="{{ $perm['can_write'] }}" type="checkbox" name="can_write" @if($perm['can_write']) checked="" @endif onclick="doCheckBox(this)" > </td>

		<td> <input class="fluency" data-type="{{ $perm['type'] }}" data-id="{{ $perm['id'] }}" data-property="can_download" data-checked="{{ $perm['can_download'] }}" type="checkbox" name="can_download" @if($perm['can_download']) checked="" @endif onclick="doCheckBox(this)" > </td>


		<td> <input  class="fluency" data-type="{{ $perm['type'] }}" data-id="{{ $perm['id'] }}" data-property="can_lock" data-checked="{{ $perm['can_lock'] }}" type="checkbox" name="can_lock" @if($perm['can_lock']) checked="" @endif onclick="doCheckBox(this)" > </td>


		<td> <input  class="fluency" data-id="{{ $perm['id'] }}" data-type="{{ $perm['type'] }}" data-property="can_checkin" data-checked="{{ $perm['can_checkin'] }}" type="checkbox" name="can_checkin" @if($perm['can_checkin']) checked="" @endif onclick="doCheckBox(this)" > </td>

		<td> <input  class="fluency" data-id="{{ $perm['id'] }}" data-type="{{ $perm['type'] }}" data-property="can_force_checkin" data-checked="{{ $perm['can_force_checkin'] }}" type="checkbox" name="can_force_checkin" @if($perm['can_force_checkin']) checked="" @endif onclick="doCheckBox(this)" > </td>




	@endif

        <td onclick="removePermission(this)"  data-id="{{ $perm['id'] }}" data-type="{{ $perm['type'] }}" ><i class="fa fa-times danger m--danger"></i></td>


</tr>
@endforeach

