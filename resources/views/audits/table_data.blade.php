<div class="m-list-timeline__items">
    @foreach($audits as $audit)
    
    @php 
        $type = 'file'
    @endphp    
    @switch($audit->actionable_type)
        @case('App\Models\File')
            
            @php 
                $type = 'file'
            @endphp    

            @break
        @case('App\Models\User')
            
            @php 
                $type = 'user'
            @endphp    

        @break

        @case('App\Models\Folder')
            
            @php 
                $type = 'File Category'
            @endphp    

        @break

        @case('App\Models\Group')
            
            @php 
                $type = 'group'
            @endphp    

        @break


        
        @default
            @php 
                $type = 'Default'
            @endphp    
    @endswitch


    <div class="m-list-timeline__item">
        <span class="m-list-timeline__badge m-list-timeline__badge--state-success"></span>
        <a class="m-list-timeline__text"> <small> ({{ $audit->user->full_name }})</small> {{ $audit->description }} <span class="m-badge m-badge--warning m-badge--wide">{{ $type }}</span></a>
        <span class="m-list-timeline__time">{{ $audit->created_at->diffForHumans() }}</span>
    </div>
    @endforeach

    <div class="m-list-timeline__item">
                                                                <span class="m-list-timeline__badge m-list-timeline__badge--info"></span>
                                                                <span class="m-list-timeline__text">New file created 
                                                                    <span class="m-badge m-badge--success m-badge--wide">file</span></span>
                                                                <span class="m-list-timeline__time">14 mins</span>
                                                            </div>
                                                            <div class="m-list-timeline__item">
                                                                <span class="m-list-timeline__badge m-list-timeline__badge--danger"></span>
                                                                <span class="m-list-timeline__text">Checked in a new file</span>
                                                                <span class="m-list-timeline__time">20 mins</span>
                                                            </div>
                                                            <div class="m-list-timeline__item">
                                                                <span class="m-list-timeline__badge m-list-timeline__badge--accent"></span>
                                                                <span class="m-list-timeline__text">Created a new category <span class="m-badge m-badge--info m-badge--wide">category</span></span>
                                                                <span class="m-list-timeline__time">1 hr</span>
                                                            </div>
                                                            <div class="m-list-timeline__item">
                                                                <span class="m-list-timeline__badge m-list-timeline__badge--warning"></span>
                                                                <span class="m-list-timeline__text">Created new file version <a href="#" class="m-link">screen.xls</a></span>
                                                                <span class="m-badge m-badge--success m-badge--wide">file</span></span>
                                                                <span class="m-list-timeline__time">2 hrs</span>
                                                            </div>
                                                            <div class="m-list-timeline__item">
                                                                <span class="m-list-timeline__badge m-list-timeline__badge--brand"></span>
                                                                <span class="m-list-timeline__text">Downloaded  image2.png</span>
                                                                <span class="m-badge m-badge--success m-badge--wide">file</span></span>
                                                                <span class="m-list-timeline__time">3 hrs</span>
                                                            </div>
                                                            <div class="m-list-timeline__item">
                                                                <span class="m-list-timeline__badge m-list-timeline__badge--info"></span>
                                                                <span class="m-list-timeline__text">Downloaded image2.png</span>
                                                                <span class="m-list-timeline__time">5 hrs</span>
                                                            </div>
                                                            <div class="m-list-timeline__item">
                                                                <span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
                                                                <span href="" class="m-list-timeline__text">Lock file sample.pdf <span class="m-badge m-badge--danger m-badge--wide">lock</span></span>
                                                                <span class="m-list-timeline__time">7 hrs</span>
                                                            </div>
                                                            <div class="m-list-timeline__item">
                                                                <span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
                                                                <span class="m-list-timeline__text">You logged in </span>
                                                                <span class="m-list-timeline__time">Just now</span>
                                                            </div>
</div>


<script type="text/javascript">
	$(document).ready(function() {
    $('#m_form_status').DataTable();
} );
</script>