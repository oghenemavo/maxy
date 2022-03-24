<div class="m-list-search__results">

	@if(empty($files->toArray()) && empty($tags) && empty($folders))
	<span class="m-list-search__result-message m--hide2">
		No record found
	</span>

	@else
	
    {{-- @php dump(count($files->toArray())) @endphp  --}}
	@if(!empty($files->toArray()))
		<span class="m-list-search__result-category m-list-search__result-category--first">
			Files
		</span>

		@foreach($files as $file)
			<a data-view="{{ route('view-file').'/'.$file->id. '/1' }}" data-toggle="modal" data-placement="bottom" title="View details" data-target="#commonModal" href=""  id="modalButton" data-type='wide' data-title="View"  class="m-list-search__result-item m--hide2" onclick=" $('#m_quicksearch_input').val('');">
				<span class="m-list-search__result-item-icon"><i class="fa fa-file m--font-success"></i></span>
				<span class="m-list-search__result-item-text">{{ $file->name }}</span>
			</a>
		@endforeach

		@if(count($files->toArray()) == 0)

			<span><em>No file matching "{{ $q }}".</em></span>

		@elseif( count($files->toArray()) > 3)
			<a href="{{ route('file-search', ['q'=>@$q]) }}"  class="m-list-search__result-item m--hide2 text-right">
				{{-- <span class="m-list-search__result-item-icon"><i class="fa fa-file-alt m--font-success"></i></span> --}}
				<span class="m-list-search__result-item-text">... see all results</span>
			</a>
		@endif

	@endif
	
	@if(!empty($folders))	
		<span class="m-list-search__result-category">
			Categories
		</span>
		@foreach($folders as $folder)
			<a href="{{ route('all-files', ['fld'=>$folder->id]) }}" class="m-list-search__result-item">
				<span class="m-list-search__result-item-pic"><i class="fa fa-folder"></i></span>
				<span class="m-list-search__result-item-text">{{ $folder->name }}</span>
			</a>
		@endforeach

		@if(count($folders->toArray()) == 0)

			<span><em>No category matching "{{ $q }}".</em></span>

		@elseif( count($folders->toArray()) > 3)
			<a href="{{ route('file-categories') }}"  class="m-list-search__result-item text-right" onclick=" $('#m_quicksearch_input').val('');" >
				{{-- <span class="m-list-search__result-item-icon"><i class="fa fa-folder-alt m--font-success"></i></span> --}}
				<span class="m-list-search__result-item-text">... see all categories</span>
			</a>
		@endif
	@endif


	@if(!empty($metafiles))
		<span class="m-list-search__result-category">
			Files with "{{ $q }}" in their metadata
		</span>

		@foreach($metafiles as $file)
			<a data-view="{{ route('view-file').'/'.$file->id. '/1' }}" data-toggle="modal" data-placement="bottom" title="View details" data-target="#commonModal" href="" id="modalButton" data-type='wide' data-title="View"  class="m-list-search__result-item m--hide2" onclick=" $('#m_quicksearch_input').val('');">
				<span class="m-list-search__result-item-icon"><i class="fa fa-file m--font-success"></i></span>
				<span class="m-list-search__result-item-text">{{ $file->name }}</span>
			</a>
		@endforeach
		
		@if(count($metafiles->toArray()) == 0)

			<span><em>No file with "{{ $q }}" in their metadata</em></span>

		@elseif( count($metafiles->toArray()) > 3)
			<a href="{{ route('file-search', ['q'=>@$q]) }}"  class="m-list-search__result-item m--hide2 text-right">
				{{-- <span class="m-list-search__result-item-icon"><i class="fa fa-file-alt m--font-success"></i></span> --}}
				<span class="m-list-search__result-item-text">... see all results</span>
			</a>

		@endif	

	@endif


	{{-- @if(!empty($folders))	
	<span class="m-list-search__result-category">
		Tags
	</span>

	@foreach($tags as $tag)
	<a href="#" class="m-list-search__result-item">
		<span class="m-list-search__result-item-icon"><i class="flaticon-lifebuoy m--font-warning"></i></span>
		<span class="m-list-search__result-item-text">Revenue report</span>
	</a>
	@endforeach
	@endif --}}

	

	@endif
</div>