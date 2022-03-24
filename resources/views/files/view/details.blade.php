
 <dl>
                <dt>Name:</dt>
                <dd>{{ $file->name }}</dd>

                <dt>Type:</dt>
                <dd>{{ $file->type }}</dd>

                <dt>Current Version:</dt>
                <dd>{{ $file->current_version }}</dd>

                <dt>Is locked:</dt>
                <dd>{{ $file->is_locked ? 'Yes':'No' }}</dd>

                <dt>Size:</dt>
                <dd>{{ sizeFilter($file->size) }}</dd>

                <dt>Date added:</dt>
                <dd>{{ @$file->created_at->toDayDateTimeString() }}</dd>


                 <dt>Added by:</dt>
                <dd>{{ @$file->createdByUser->first_name.' '.@$file->createdByUser->last_name }}</dd>

                <dt>Last modified:</dt>
                <dd>{{ @$file->updated_at->toDayDateTimeString() }}</dd>

            </dl>


	<div class="m-btn-group m-btn-group--pill btn-group m--hide" role="group" aria-label="Button group with nested dropdown">

        @if( (Auth::user()->access_type != "General staff" || Auth::user()->access_type !=  "Limited Staff") && @$file->trashed())
            <button type="button" class="m-btn btn btn-success" onclick="restoreFile();"><i class="fa fa-trash"></i> Restore</button>


        @elseif( $file->is_locked)
            <button type="button" class="m-btn btn btn-success" onclick="unlockFile();"><i class="fa fa-unlock"></i> Unlock</button>

        @else    
        
		
    		@if(@$userPivot->can_download || @$groupPivot->can_download)
    			<button type="button" class="m-btn btn btn-primary" onclick="location.href='{{ Storage::url($file->file_path) }}'" download><i class="fa fa-download"></i> Download</button>
    		@endif

    		@if(@$userPivot->can_write || @$groupPivot->can_write)
    			<button type="button" class="m-btn btn btn-secondary" onclick="location.href='{{ route('edit-file', [$file->id, 0]) }}'" ><i class="fa fa-edit"></i> Edit</button>
                <button type="button" class="m-btn btn btn-danger" onclick="deleteFile();"><i class="fa fa-trash"></i> Delete</button>
    		@endif

            

    		@if(!$file->is_locked && (@$userPivot->can_lock || @$groupPivot->can_lock))
    			<button type="button" class="m-btn btn btn-default" onclick="lockFile();"><i class="fa fa-lock"></i> Lock</button>
            @elseif(@$userPivot->can_lock && $file->created_by == Auth::user()->id )
    		{{-- @elseif(@$userPivot->can_lock && dd($file->created_by == Auth::user()->id)) --}}
    			<button type="button" class="m-btn btn btn-default" onclick="location.href='{{ route('lock-file', [$file->id, 0]) }}'"><i class="fa fa-unlock"></i> Unlock</button>
    		@endif

    		@if(!$file->is_checked_in && (@$userPivot->can_checkin || @$groupPivot->can_checkin))
    			<button type="button" class="m-btn btn btn-warning" data-view='{{ route("checkoutFile") }}' data-toggle="modal" data-placement="bottom" title="Profile" data-target="#commonModal" class=""  id="modalButton" data-type="wide" data-title="Chekcout File"><i class="fa fa-check"></i> Checkout</button>
    		@elseif($file->checked_in_by == Auth::user()->id && (@$userPivot->can_checkin || @$groupPivot->can_checkin))
    			<button type="button" class="m-btn btn btn-warning" data-view='{{ route("checkoutFile") }}' data-toggle="modal" data-placement="bottom" title="Profile" data-target="#commonModal" class=""  id="modalButton" data-type="wide" data-title="Chekcout File"><i class="fa fa-upload"></i> Checkin</button>

    		@endif



        @endif    

		{{-- <div class="m-btn-group btn-group" role="group">
			<button id="btnGroupDrop1" type="button" class="btn btn-secondary m-btn m-btn--pill-last dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Dropdown1
			</button>
			<div class="dropdown-menu" aria-labelledby="btnGroupDrop1" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 40px, 0px);">
				<a class="dropdown-item" href="#">Dropdown link</a>
				<a class="dropdown-item" href="#">Dropdown link</a>
				<a class="dropdown-item" href="#">Dropdown link</a>
				<a class="dropdown-item" href="#">Dropdown link</a>
			</div>
		</div> --}}
	</div>


{{-- 
	                                                                @if($userPivot->can_checkin)
                                                                    @if(!$file->is_checked_in)
                                                                        <a type="button" href="{{ route('checkin-file', [$file->id, 1]) }}" class="dropdown-item" type="button">CheckIn</a>
                                                                    @endif

                                                                     @if(!$file->is_locked)
                                                                        <a type="button" href="{{ route('lock-file', [$file->id, 1]) }}" class="dropdown-item" >Lock File</a>
                                                                    @endif

                                                                        <a data-view='{{ route("checkoutFile") }}' data-toggle="modal" data-placement="bottom" title="Profile" data-target="#commonModal" class=""  id="modalButton" data-type="wide" data-title="Chekcout File" > Checkout </a>

                                                                @endif --}}


                                                                <script type="text/javascript">
                                                                    function deleteFile() {
                                                                        if(confirm("Are you sure you want to trash this file?")){


                                                                            location.href='{{ route('delete-file', [$file->id]) }}'
                                                                        }
                                                                    }

                                                                    function restoreFile() {
                                                                        if(confirm("Are you sure you want to restore this deleted file?")){


                                                                            location.href='{{ route('restore-file', [$file->id]) }}'
                                                                        }
                                                                    }

                                                                    function unlockFile() {
                                                                        if(confirm("Are you sure you want to unlock this locked file?")){


                                                                            location.href='{{ route('lock-file', [$file->id, 0]) }}'
                                                                        }
                                                                    }

                                                                    function lockFile() {
                                                                        if(confirm("Are you sure you want to lock this locked file?\n\n No one will be able to download or make any changes until you unlock it.")){


                                                                            location.href='{{ route('lock-file', [$file->id, 0]) }}'
                                                                        }
                                                                    }
                                                                </script>
