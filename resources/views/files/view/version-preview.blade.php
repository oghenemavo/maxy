@if($version)
        @if(str_contains($version->type, 'image'))


                <img src="{{ asset(env('UPLOAD_FILE_PATH', 'uploads/').$version->file_path ) }}" width="100%" />
                

        @elseif(str_contains($version->type, 'pdf'))

                <object data='{{ asset(env('UPLOAD_FILE_PATH', 'uploads/').$version->file_path ) }}#toolbar=0' 
                type='application/pdf' 
                width='100%' 
                height="500px" 
                ></object>


        @elseif(str_contains($version->type, 'application'))

                <img src="{{ asset('PreviewNotAvailable.png') }}" width="100%" />


        @else

                <object data='{{ asset(env('UPLOAD_FILE_PATH', 'uploads/').$version->file_path ) }}#toolbar=1' 
                type='{{ $version->type }}' 
                width='100%' 
                height="500px" 
                ></object>

        @endif
@endif

@if($otherFile)
        @if(str_contains($otherFile->type, 'image'))


                <img src="{{ asset(env('UPLOAD_FILE_PATH', 'uploads/').$otherFile->file_path ) }}" width="100%" />

        @elseif(str_contains($otherFile->type, 'pdf'))

                <object data='{{ asset(env('UPLOAD_FILE_PATH', 'uploads/').$otherFile->file_path ) }}#toolbar=0' 
                type='application/pdf' 
                width='100%' 
                height="500px" 
                ></object>

        @elseif(str_contains($otherFile->type, 'application'))

                <img src="{{ asset('PreviewNotAvailable.png') }}" width="100%" />

        @else

                <object data='{{ asset(env('UPLOAD_FILE_PATH', 'uploads/').$otherFile->file_path ) }}#toolbar=1' 
                type='{{ $otherFile->type }}' 
                width='100%' 
                height="500px" 
                ></object>

        @endif
@endif