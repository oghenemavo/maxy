<div class="m-portlet__head">
    <div class="m-portlet__head-caption">
        <div class="m-portlet__head-title">
            <h3 class="m-portlet__head-text">
                {{ $file->name }}
            </h3>
        </div>
    </div>
    <div class="m-portlet__head-tools">
        <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--right m-tabs-line-danger" role="tablist">
            <li class="nav-item m-tabs__item">
                <a class="nav-link m-tabs__link active show" data-toggle="tab" href="#m_portlet_tab_1_1" role="tab" aria-selected="true">
                    Metadata
                </a>
            </li>
            <li class="nav-item m-tabs__item">
                <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_portlet_tab_1_2" role="tab" aria-selected="false">
                    Preview
                </a>
            </li>
            <li class="nav-item m-tabs__item">
                <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_portlet_tab_1_3" role="tab" aria-selected="false">
                    Permissions
                </a>
            </li>
            <li class="nav-item m-tabs__item">
                <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_portlet_tab_1_4" role="tab" aria-selected="false">
                    Versions
                </a>
            </li>
            <li class="nav-item m-tabs__item">
                <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_portlet_tab_1_5" role="tab" aria-selected="false">
                    Logs
                </a>
            </li>
        </ul>
    </div>
</div>
<div class="m-portlet__body">
    <div class="tab-content">
        <div class="tab-pane active show" id="m_portlet_tab_1_1">
            <dl>
                <dt>Name:</dt>
                <dd>{{ $file->name }}</dd>

                <dt>Type:</dt>
                <dd>{{ $file->type }}</dd>

                <dt>Current Version:</dt>
                <dd>{{ $file->current_version }}</dd>

                <dt>Is locked:</dt>
                <dd>{{ $file->is_locked ? 'Yes':'No' }}</dd>

                <dt>Size:</dt>
                <dd>{{ sizeFilter($file->size) }}</dd>

                <dt>Is CheckedIn:</dt>
                <dd>{{ $file->is_checked_in ? 'Yes':'No' }}</dd>

                <dt>Folder:</dt>
                <dd>{{ @$file->folder->name }}</dd>

            </dl>
        </div>
        <div class="tab-pane" id="m_portlet_tab_1_2">
            
        </div>
        <div class="tab-pane" id="m_portlet_tab_1_3">
            @include('files.view.permissions')
        </div>
        <div class="tab-pane" id="m_portlet_tab_1_4">
            <table class="table">
                <thead>
                    <th>Version</th>
                    <th>Size</th>
                    <th>Type</th>
                    <th>Comments</th>
                </thead>

                <tbody>
                    @foreach($file->versions as $version)
                    <tr>
                        <td>{{ $version->version }}</td>            
                        <td>{{ sizeFilter($version->size) }}</td>            
                        <td>{{ ($version->type) }}</td>            
                        <td>{{ ($version->comments) }}</td>            
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-pane" id="m_portlet_tab_1_5">
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
        </div>
    </div>
</div>




<ul class="nav nav-tabs  m-tabs-line m-tabs-line--success" role="tablist">
    <li class="nav-item m-tabs__item">
        <a class="nav-link m-tabs__link  active show" data-toggle="tab" href="#m_tabs_2_1" role="tab" aria-selected="false">Metadata</a>
    </li>

     <li class="nav-item m-tabs__item">
        <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_preview" role="tab" aria-selected="false">Preview</a>
    </li>

     <li class="nav-item m-tabs__item">
        <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_permisions" role="tab" aria-selected="false">Permissions</a>
    </li>

     <li class="nav-item m-tabs__item">
        <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_versions" role="tab" aria-selected="false">Versions</a>
    </li>
    
    <li class="nav-item m-tabs__item">
        <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_2_3" role="tab" aria-selected="true">Logs</a>
    </li>
</ul>

<div class="tab-content">
    <div class="tab-pane active show" id="m_tabs_2_1" role="tabpanel">
        <dl>
        	<dt>Name:</dt>
        	<dd>{{ $file->name }}</dd>

        	<dt>Type:</dt>
        	<dd>{{ $file->type }}</dd>

        	<dt>Current Version:</dt>
        	<dd>{{ $file->current_version }}</dd>

        	<dt>Is locked:</dt>
        	<dd>{{ $file->is_locked ? 'Yes':'No' }}</dd>

        	<dt>Size:</dt>
        	<dd>{{ sizeFilter($file->size) }}</dd>

        	<dt>Is CheckedIn:</dt>
        	<dd>{{ $file->is_checked_in ? 'Yes':'No' }}</dd>

        	<dt>Folder:</dt>
        	<dd>{{ @$file->folder->name }}</dd>

        </dl>
    </div>

    <div class="tab-pane" id="m_tabs_preview" role="tabpanel">
    	<img src="">
    </div>

    <div class="tab-pane" id="m_tabs_permisions" role="tabpanel">
      @include('files.view.permissions')
    </div>

    <div class="tab-pane" id="m_tabs_versions" role="tabpanel">
        
        
    </div>

    <div class="tab-pane" id="m_tabs_2_2" role="tabpanel">
        It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages.
    </div>
    <div class="tab-pane " id="m_tabs_2_3" role="tabpanel">
         
    </div>
</div>

<div class="m-separator m-separator--dashed"></div>