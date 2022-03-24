<div class="btn-group btn-group-xs">
    <a href="javascript:void(0)" data-toggle="dropdown" class="btn btn-alt btn-primary dropdown-toggle">Actions<span class="caret"></span></a>
        <ul class="dropdown-menu dropdown-custom  dropdown-menu-right">

        	<li>
				@if(isset($options))
					@foreach($options as $option)
						<?php $modalSize = ( isset( $option['modal_size'] ) ) ? $option['modal_size'] : 'normal'; ?>
						
						@if(($option['action_type'] == 'modal'))
                        	<a data-view="{{ $option['action_url'] }}" data-toggle="modal" data-placement="bottom" title="Profile" data-target="#commonModal" class="" href="" id="modalButton" data-type='wide' data-title="{{ $option['action_title'] }}" >{{ $option['action_label'] }} </a>        

						@endif

						@if(($option['action_type'] == 'link'))
							<a class="" alt="{{ $option['action_title'] }}" title="{{ $option['action_title'] }}"  href="{{ $option['action_url'] }}" > <i class="fa {{ @$option['icon'] }} pull-right"></i> {{ $option['action_label'] }}</a>
						@endif

						@if(($option['action_type'] == 'newpage_link'))
							<li><a class="text-right" target="_blank" alt="{{ $option['action_title'] }}" title="{{ $option['action_title'] }}" target="_blank" href="{{ $option['action_url'] }}" >{{ $option['action_label'] }}</a></li>
						@endif

						@if(($option['action_type'] == 'dialog'))
							<a class=""  href="{{ $option['action_url'] }}" id="modalButton" onclick="return confirm('{{ $option['modal'] }}');" > <i class="fa {{ @$option['icon'] }} pull-right"></i> {{ $option['action_label'] }}  </a>
						@endif

						@if($option['action_type'] == 'post')
							<li>
								{!! Form::open([
			                        'method'=>'POST',
			                        'url' => $option['action_url'],
			                        'style' => 'display:inline'
			                    ]) !!}
			                        {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> '.$option['action_title'], array(
			                                'type' => 'submit',
			                                'class' => 'text-right',
			                                'title' => $option['action_title'],
			                                'onclick'=>'return confirm("'.$option["confirm"].'")'
			                        )) !!}
			                    {!! Form::close() !!}
							</li>
						@endif

						@if($option['action_type'] == 'form')
							<li>
								{!! Form::open([
			                        'method'=>'POST',
			                        'url' => ['vlaappraisal/reset', $option['id']],
			                        'style' => 'display:inline'
			                    ]) !!}
			                        {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> '.$option['action_title'], array(
			                                'type' => 'submit',
			                                'class' => 'text-right',
			                                'title' => $option['action_title'],
			                                'onclick'=>'return confirm("'.$option["confirm"].'")'
			                        )) !!}
			                    {!! Form::close() !!}
							</li>
						@endif

					@endforeach
				@endif
			</li>
		</ul>

</div>