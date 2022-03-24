<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        @foreach( $file->otherfiles as $key => $otherfile)
                <li class="nav-item">
                        <a class="{{ ($key == 0) ? 'nav-link active' : 'nav-link'}}" id="pills-home-{{$otherfile->id}}-tab" data-toggle="pill" href="#pills-home-{{$otherfile->id}}" role="tab" aria-controls="pills-home-{{$otherfile->id}}" aria-selected="true">{{$otherfile->name}}</a>
                </li>
        @endforeach
</ul>

<div class="tab-content" id="pills-tabContent">
        
                @foreach( $file->otherfiles as $key => $otherfile)
                        <div class="{{ ($key == 0) ? 'tab-pane fade show active' : 'tab-pane' }}" id="pills-home-{{$otherfile->id}}" role="tabpanel" aria-labelledby="pills-home-{{$otherfile->id}}-tab">
                                
                                @if(str_contains($otherfile->type, 'image'))

                                        <img src="{{ asset(env('UPLOAD_FILE_PATH', 'uploads/').$otherfile->file_path ) }}" width="100%" />

                                @elseif(str_contains($otherfile->type, 'pdf'))

                                        <object data='{{ asset(env('UPLOAD_FILE_PATH', 'uploads/').$otherfile->file_path ) }}#toolbar=0' 
                                        type='application/pdf' 
                                        width='100%' 
                                        height="800px" 
                                        ></object>

                                @elseif(str_contains($otherfile->type, 'application'))

                                        <img src="{{ asset(env('UPLOAD_FILE_PATH', 'uploads/').$otherfile->file_path ) }}" width="100%" />

                                @else

                                        <object data='{{ asset(env('UPLOAD_FILE_PATH', 'uploads/').$otherfile->file_path ) }}#toolbar=1' 
                                        type='{{ $otherfile->type }}' 
                                        width='100%' 
                                        height="500px" 
                                        ></object>

                                @endif
                        </div>
                @endforeach       

</div>