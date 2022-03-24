@if (session('success'))
    <div class="alert alert-success">
    	@if( is_array( session('success') ) )
			@foreach( session('success') as $msg )
				{{ $msg }} 
				@if( !$loop->last )
					<br>
				@endif
			@endforeach
		@else
			{{ session('success') }}
    	@endif
        
    </div>
@endif
@if (session('warning'))
    <div class="alert alert-warning">
        @if( is_array( session('warning') ) )
			@foreach( session('warning') as $msg )
				{{ $msg }} 
				@if( !$loop->last )
					<br>
				@endif
			@endforeach
		@else
			{{ session('warning') }}
    	@endif
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger">
        @if( is_array( session('error') ) )
			@foreach( session('error') as $msg )
				{{ $msg }} 
				@if( !$loop->last )
					<br>
				@endif
			@endforeach
		@else
			{{ session('error') }}
    	@endif
    </div>
@endif

@if (!empty($errors->all()))
<div class="alert alert-danger">
	<ul>
		@foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
	</ul>

</div>
@endif

<div class="alert alert-success" id="success" style="display:none;"></div>

<div class="alert alert-warning" id="warning" style="display:none;"></div>

<div class="alert alert-danger" id="error" style="display:none;"></div>




