<h5>Version history</h5>

<table class="table">
                <thead>
                    <th>Version</th>
                    <th>Size</th>
                    <th>Type</th>
                    <th>Comments</th>
                    @if(!$isModal)
                    <th></th>
                    @endif
                </thead>
 
                <tbody>
                    @foreach($file->versions as $version)
                    <tr>
                        <td>{{ $version->version }}</td>            
                        <td>{{ sizeFilter($version->size) }}</td>            
                        <td>{{ ($version->type) }}</td>            
                        <td>{{ ($version->comments) }}</td>  
                        @if(!$isModal)
                        <td>
                            <a  href="{{ route('version-preview', ['id'=> $version->id]) }}" title="Preview" data-view="{{ route('version-preview', ['id'=> $version->id]) }}" data-toggle="modal" data-placement="bottom" title="Profile" data-target="#commonModal" class="" href="" id="modalButton" data-type='wide' data-title="{{ $version->version }} Preview" ><i class="flaticon-search-1"></i> </a>
                            @if(@$userPivot->can_download)
                             | 
                             <a title="Download" onclick="downloadFile( '{{ asset(env('UPLOAD_FILE_PATH', 'uploads/').$file->file_path ) }}', '{{ $file->name }}' )" ><i class="fa fa-download"></i></button>
                            @endif
                        </td>
                        @endif          
                    </tr>
                    @endforeach
                </tbody>
            </table>