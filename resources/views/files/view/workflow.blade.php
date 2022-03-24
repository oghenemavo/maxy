
 <dl>
                
                <dt>Category:</dt>
                <dd>{{ @$file->folder->name }}</dd>

                <dt>Workflow:</dt>
                <dd>{{ @$file->folder->workflow->name }}</dd>

                
                @if( isset($file->folder->workflow) )
                    <dt>Workflow steps:</dt>
                    <dd>

                     
                        <div class="m-list-timeline">
                            <div class="m-list-timeline__items">
 
                                @foreach($file->folder->workflow->steps as $step)
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--{{ ($file->step->rank > $step->rank) ? 'success' : (($file->step->id == $step->id) ? 'warning' : 'default') }}"></span>
                                    <span class="m-list-timeline__text">{{ $step->name }}</span>
                                    <span class="m-list-timeline__time">
                                        {{ ($file->step->rank > $step->rank) ? 'Completed' : (($file->step->id == $step->id) ? 'In Progress' : 'Pending') }}
                                    </span>
                                </div>

                                @endforeach
                               {{--  
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--danger"></span>
                                    <span class="m-list-timeline__text">Scheduled system reboot completed <span class="m-badge m-badge--success m-badge--wide">completed</span></span>
                                    <span class="m-list-timeline__time">14 mins</span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--warning"></span>
                                    <span class="m-list-timeline__text">New order has been planced and pending for processing</span>
                                    <span class="m-list-timeline__time">20 mins</span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--primary"></span>
                                    <span class="m-list-timeline__text">Database server overloaded 80% and requires quick reboot <span class="m-badge m-badge--info m-badge--wide">settled</span></span>
                                    <span class="m-list-timeline__time">1 hr</span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--brand"></span>
                                    <span class="m-list-timeline__text">System error occured and hard drive has been shutdown - <a href="#" class="m-link">Check</a></span>
                                    <span class="m-list-timeline__time">2 hrs</span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
                                    <span class="m-list-timeline__text">Production server is rebooting...</span>
                                    <span class="m-list-timeline__time">3 hrs</span>
                                </div> --}}
                            </div>
                        </div>
        

                    </dd>
                @endif    

            
            </dl> 

   

	<div class="m-btn-group m-btn-group--pill btn-group1" role="group" aria-label="Button group with nested dropdown">

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
            }
        }
    @endphp

    @if($canUpdate)
        <button type="button" class="m-btn btn btn-secondary" onclick="location.href='{{ route('edit-file', [$file->id, 0]) }}'" ><i class="fa fa-edit"></i> Update</button>
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
           
            SaveToDisk('{{ asset(env('UPLOAD_FILE_PATH', 'uploads/').$file->file_path ) }}', '{{ $file->name }}');

            
           

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
                                                                
</script>
