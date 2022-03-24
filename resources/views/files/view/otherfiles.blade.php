<h5>Other Files</h5>

<table class="table">
                <thead>
                    <th>Name</th>
                    <th>Size</th>
                    <th>Type</th>
                    <th>Actions</th>
                    @if(!$isModal)
                    <th></th>
                    @endif
                </thead>
 
                <tbody>
                    @foreach($file->otherfiles as $otherfile)
                    <tr>
                        <td>{{ $otherfile->name }}</td>            
                        <td>{{ sizeFilter($otherfile->size) }}</td>            
                        <td>{{ ($otherfile->type) }}</td>
                        @if(!$isModal)
                        <td>
                            <a  href="{{ route('other_files-preview', ['id'=> $otherfile->id]) }}" title="Preview" data-view="{{ route('other_files-preview', ['id'=> $otherfile->id]) }}" data-toggle="modal" data-placement="bottom" title="Profile" data-target="#commonModal" class="" href="" id="modalButton" data-type='wide' data-title="{{ $otherfile->name }} Preview" ><i class="flaticon-search-1"></i> </a>
                            
                             | 
                             <a title="Download" onclick="downloadFile( '{{ asset(env('UPLOAD_FILE_PATH', 'uploads/').$otherfile->file_path ) }}', '{{ $otherfile->name }}' )" ><i class="fa fa-download"></i></button>
                            
                        </td>
                        @else
                        <td>
                             
                             <a title="Download" onclick="downloadFile( '{{ asset(env('UPLOAD_FILE_PATH', 'uploads/').$otherfile->file_path ) }}', '{{ $otherfile->name }}' )" ><i class="fa fa-download"></i></button>
                            
                        </td>
                        @endif          
                    </tr>
                    @endforeach
                </tbody>
            </table>

