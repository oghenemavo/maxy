
 <dl>
                <dt>Name:</dt>
                <dd>{{ $file->name }}</dd>

                <dt>Category:</dt>
                <dd>{{ @$file->folder->name }}</dd>
                
                @foreach($file->fields as $field)

					<dt>{{ $field->name }}:</dt>
                	<dd>
                		@if($field->type == "Number")
                			{{ number_format($field->pivot->value) }}
                		@elseif($field->type == "Decimal")
                            {{ number_format($field->pivot->value, 2) }}
                        @elseif($field->type == "Timestamp")
                         {{$file->created_at->toDayDateTimeString()}}
                		@else
							{{ $field->pivot->value }}
                		@endif
                	</dd>
                @endforeach

                @if($folder->workflow)
                    <dt>Workflow Status:</dt>
                    <span class="m-list-timeline__text">{{($file->step) ? $file->step->name : $folder->workflow->steps()->first()->name }}</span>

                @endif
                @php
                $canUpdate = false;
                if($file->folder->workflow) {
                    foreach ($file->step->assignees as $assignee) {
                        if ($assignee->recipient_type === 'GROUP') {
                              $groupUsers = App\Models\Group::with('users')
                                  ->find($assignee->recipient_id)->users->pluck('id')->toArray();
                              if(in_array(Auth::user()->id, $groupUsers)){
                                  $canUpdate = true;
                                  break;
                              }
                        }
                        elseif ($assignee->recipient_type === 'USER' && $assignee->recipient_id == Auth::user()->id ) {
                            $canUpdate = true;
                            break;
                        }
			elseif ($assignee->recipient_type === 'DEFAULT' && $file->created_by == Auth::user()->id ) {
                            $canUpdate = true;
                            break;
                        }
                    }
                }
                @endphp
        
            @if($canUpdate && !$file->is_locked)
                <button type="button" class="m-btn btn btn-secondary" onclick="location.href='{{ route('edit-file', [$file->id, 0]) }}'" ><i class="fa fa-edit"></i> Update</button>
            @endif
                
</dl>


	<div class="m-btn-group m-btn-group--pill btn-group" role="group" aria-label="Button group with nested dropdown">


        @if(() Auth::user()->access_type != "General staff" || Auth::user()->access_type !=  "Limited Staff") && @$file->trashed())
            <button type="button" class="m-btn btn btn-success" onclick="restoreFile();"><i class="fa fa-trash"></i> Restore</button>


        @elseif( $file->is_locked && ($file->created_by == Auth::user()->id))
            <button type="button" class="m-btn btn btn-success" onclick="unlockFile();"><i class="fa fa-unlock"></i> Unlock</button>

        @else    
        
		
    		@if(@$userPivot->can_download || @$groupPivot->can_download || $file->is_permission_set == 0)
    			<button type="button" class="m-btn btn btn-primary" onclick="downloadFile( '{{ asset(env('UPLOAD_FILE_PATH', 'uploads/').$file->file_path ) }}', '{{ $file->name }}' )" ><i class="fa fa-download"></i> Download</button>
    			<button type="button" class="m-btn btn btn-warning" onclick="location.href=onclick='{{route('exportFile',['fileId' => $file->id])}}'" ><i class="fa fa-download"></i> Export</button>
    		@endif
            @if(!$file->folder->workflow)
                @if(@$userPivot->can_write || @$groupPivot->can_write || $file->is_permission_set == 0)
                    <button type="button" class="m-btn btn btn-secondary" onclick="location.href='{{ route('edit-file', [$file->id, 0]) }}'" ><i class="fa fa-edit"></i> Edit</button>
                    <button type="button" class="m-btn btn btn-danger" onclick="deleteFile();"><i class="fa fa-trash"></i> Delete</button>
                @endif
            @endif

            

    		@if(!$file->is_locked && (@$userPivot->can_lock || @$groupPivot->can_lock || $file->is_permission_set == 0))
    			<button type="button" class="m-btn btn btn-default" onclick="lockTheFile();"><i class="fa fa-lock"></i> Lock</button>
            @elseif((@$userPivot->can_lock || @$groupPivot->can_lock) && ($file->created_by == Auth::user()->id))
    			<button type="button" class="m-btn btn btn-default" onclick="location.href='{{ route('lock-file', [$file->id, 0]) }}'"><i class="fa fa-unlock"></i> Unlock</button>
    		@endif

    		@if(!$file->is_checked_in && (@$userPivot->can_checkin || @$groupPivot->can_checkin || $file->is_permission_set == 0) && !$isModal)
    			<button type="button" class="m-btn btn btn-default" onclick="checkOutFile();"><i class="fa fa-check"></i> Checkout</button>
                
            @endif
            
    		



        @endif 

        @if($file->checked_in_by == Auth::user()->id && (@$userPivot->can_checkin || @$groupPivot->can_checkin || $file->is_permission_set == 0) && $file->is_locked && !$isModal)
            <button type="button" class="m-btn btn btn-warning" data-view='{{ route('checkin-file', ['fileId' =>$file->id]) }}' data-toggle="modal" data-placement="bottom" title="Profile" data-target="#commonModal" class=""  id="modalButton" data-type="wide" data-title="Checkout File '{{ $file->name }}'"><i class="fa fa-upload"></i> Checkin</button>

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

    @if(@$userPivot->is_following)    
        <a class="btn m-btn--pill m--right btn-danger m-btn m-btn--custom" onclick="unfollowFile();"  >
            <i class="fa fa-thumbs-down"></i> Unfollow
        </a>

     @else
        <a class="btn m-btn--pill m--right btn-success m-btn m-btn--custom" onclick="followFile();"  >
            <i class="fa fa-thumbs-up"></i> Follow
        </a>

     @endif
    
    @if($isModal)    
        <a class="btn m-btn--pill m--right btn-accent m-btn m-btn--custom" onclick="activateTab('m_portlet_tab_1_2');"  >
            <i class="flaticon-search-1"></i> Preview
        </a>

    @else            

        <button type="button" class="btn m-btn--pill m--right btn-accent m-btn m-btn--custom" href="{{ route('file-preview', ['id'=> $file->id]) }}" title="Edit" data-view="{{ route('file-preview', ['id'=> $file->id]) }}" data-toggle="modal" data-placement="bottom" title="File Preview" data-target="#commonModal" class="" href="" id="modalButton" data-type='wide' data-title="File Preview" ><i class="flaticon-search-1"></i> Preview</button>


    @endif

    {{-- @if( (@$userPivot->can_checkin || @$groupPivot->can_checkin || $file->is_permission_set == 0) && !$isModal) --}}
    @if($isModal)
        <a class="btn m-btn--pill m--right btn-accent m-btn m-btn--custom" onclick="activateTab('m_portlet_tab_1_9');"  >
            <i class="fa fa-upload"></i> Upload
        </a>
    @else
    {{-- <button type="button" class="m-btn btn btn-primary" onclick="uploadFile();"><i class="fa fa-upload"></i> Upload</button> --}}
        <button type="button" class="btn m-btn--pill m--right btn-accent m-btn m-btn--custom" data-view='{{ route('upload-file', ['fileId' =>$file->id]) }}' data-toggle="modal" data-placement="bottom" title="Upload New Document" data-target="#commonModal" class=""  id="modalButton" data-type="wide" data-title="Upload New Document"><i class="fa fa-upload"></i>Upload</button>
    
@endif





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

    function lockTheFile() {
        if(confirm("Are  you sure you want to lock this locked file?\n\n No one will be able to download or make any changes until you unlock it.")){


            location.href='{{ route('lock-file', [$file->id, 1 ]) }}'
        }
    }


    function SaveToDisk(fileURL, fileName) {
        // for non-IE
        if (!window.ActiveXObject) {
            var save = document.createElement('a');
            save.href = fileURL;
            save.target = '_blank';
            save.download = fileName || 'unknown';

            var evt = new MouseEvent('click', {
                'view': window,
                'bubbles': true,
                'cancelable': false
            });
            save.dispatchEvent(evt);

            (window.URL || window.webkitURL).revokeObjectURL(save.href);
        }

        // for IE < 11
        else if ( !! window.ActiveXObject && document.execCommand)     {
            var _window = window.open(fileURL, '_blank');
            _window.document.close();
            _window.document.execCommand('SaveAs', true, fileName || fileURL)
            _window.close();
        }
    }

    function downloadFile(fileURL, fileName){
        $.ajax({
            type: "GET",   
            url: "{{ route('downloadFile', ['fileId' => $file->id ]) }}",
            success: function(l) {
               
                SaveToDisk(fileURL, fileName);

                
               

            },
            error: function() {
                toastr.error("An error occurred while downloading the file", "Error");
            }
        }); 

    }


    function checkOutFile(){

        if(confirm("Are  you sure you want to checkout this file?\n\n The file will be locked and no one will be able to download or make any changes until you check in back in.")){

            $.ajax({
                type: "GET",   
                url: "{{ route('checkoutFile', ['fileId' => $file->id ]) }}",
                success: function(l) {
                   
                    toastr.success("File has been checked out.");
                    SaveToDisk('{{ asset(env('UPLOAD_FILE_PATH', 'uploads/').$file->file_path ) }}', '{{ $file->name }}');

                    
                    setTimeout(function(){
                        location.reload();
                    }, 1000)

                },
                error: function() {
                    toastr.error("An error occurred while checking out the file", "Error");
                }
            }); 
        }

    }

    function followFile() {
        if(confirm("Are you sure you want to follow this file?\n\nYou will get updates and notifications on changes on this file.")){


            location.href='{{ route('follow-file', [$file->id]) }}'
        }
    }

    function uploadFile() {
        if(confirm("Are you sure you want to upload another file?")){

            location.href='{{ route('upload-file', [$file->id]) }}'
            
        }
    }

    function unfollowFile() {
        if(confirm("Are you sure you want to unfollow this file?\n\nYou will stop getting updates and notifications on changes on this file.")){


            location.href='{{ route('unfollow-file', [$file->id]) }}'
        }
    }
                                                                
</script>
