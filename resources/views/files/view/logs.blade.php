 <h5>Logs</h5>

<hr/>
<br/>
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
                                                                <span class="m-list-timeline__text">Created a new folder <span class="m-badge m-badge--info m-badge--wide">folder</span></span>
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


                                                            <table class="table">
            <thead>
                <th>Name</th>
                <th>Description</th>
                <th>By</th>
                <th>Date</th>
            </thead>

            <tbody>
                @foreach($audits as $log)
                <tr>
                    <td>{{ $log->name }}</td>            
                    <td>{{ ($log->description) }}</td>            
                    <td>{{ ($log->causer_id) }}</td>            
                    <td>{{ ($log->created_at) }}</td>            
                </tr>
                @endforeach
            </tbody>
        </table>